<?php

require_once("Model/UserAdmin.php");
require_once("Model/UserRegular.php");

class MainDAO
{

    public function __construct()
    {}

    public static function startBorrow($ref_equip_toBorrow,$start_date,$dateFin)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        try
        {
            $con->beginTransaction();

            $requestSelect = "SELECT id_device FROM DEVICE WHERE isAvailable = TRUE AND ref_equip = '$ref_equip_toBorrow';";
            $answerSelect = $con->query($requestSelect);
            $resultSelect = $answerSelect->fetch();
            $device_id = $resultSelect['id_device'];

            $requestUpdate = "UPDATE DEVICE SET isAvailable = FALSE WHERE id_device = '$device_id';";
            $con->query($requestUpdate);

            $requestInsert = "INSERT INTO borrow_info (startdate_borrow, enddate_borrow, isActive) VALUES ('$start_date', ? , TRUE); ";
            $myStatement = $con->prepare($requestInsert);
            $myStatement->execute([$dateFin]);
            $id_borrow = $con->lastInsertId("id_borrow");

            $requestInsert1 = "INSERT INTO borrow (id_user, id_device, id_borrow) VALUES (?, '$device_id' , '$id_borrow');";
            $myStatement = $con->prepare($requestInsert1);
            $myStatement->execute([$_SESSION['id_user']]);

            $con->commit();
            return true;
        }
        catch (PDOException $e)
        {
            $con->rollback();
            throw new Exception("Exception User: couldn't borrow Equipment\n");

        }
    }

    public static function stopBorrow($id_borrow,$device_id,$end_date)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $con->beginTransaction();
        try
        {
            $requestUpdate = "UPDATE DEVICE SET isAvailable = 1 WHERE id_device = '$device_id';";
            $con->query($requestUpdate);

            $requestUpdate2 = "UPDATE borrow_info SET enddate_borrow = '$end_date',isActive = 0 WHERE id_borrow = '$id_borrow';";
            $con->query($requestUpdate2);
            $con->commit();
            return true;
        }
        catch (Exception $e)
        {
            $con->rollback();
            throw new Exception("Could not end the borrow");
        }
    }

    public static function isUserAdmin($user)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        try
        {
            $query = "SELECT * FROM users WHERE id_user = ? ;";
            $stmt = $con->prepare($query);
            $stmt->execute([$user->getIdUser()]);
            $result = $stmt->fetch();

            if($result['isAdmin_user'] == 1)
                return true;
            else
                return false;
        }
        catch (PDOException $e)
        {
            throw new Exception("Could not determine if user was admin");
        }
    }

    public static function getUser($id_userToLoad)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        try
        {
            $query = "SELECT * FROM users WHERE id_user = ? ;";
            $stmt = $con->prepare($query);
            $stmt->execute([$id_userToLoad]);
            $result = $stmt->fetch();

            if($result['isAdmin_user'] == 1)
            {
                $CurrentUserAdmin = new UserAdmin();
                $CurrentUserAdmin->setIdUser($id_userToLoad);
                $CurrentUserAdmin->setEmail($result['email_user']);
                $CurrentUserAdmin->setMatriculeUser($result['matricule_user']);
                $CurrentUserAdmin->setPassword($result['password_user']);
                $CurrentUserAdmin->setName($result['name_user']);
                $CurrentUserAdmin->setLastName($result['lastname_user']);
                $CurrentUserAdmin->setPhone($result['phone_user']);
                $CurrentUserAdmin->setPrivilege($result['isAdmin_user']);
                MainDAO::getUserBorrow($CurrentUserAdmin);
                return $CurrentUserAdmin;
            }
            else
            {
                $CurrentUser = new UserRegular();
                $CurrentUser->setIdUser($id_userToLoad);
                $CurrentUser->setEmail($result['email_user']);
                $CurrentUser->setMatriculeUser($result['matricule_user']);
                $CurrentUser->setPassword($result['password_user']);
                $CurrentUser->setName($result['name_user']);
                $CurrentUser->setLastName($result['lastname_user']);
                $CurrentUser->setPhone($result['phone_user']);
                $CurrentUser->setPrivilege($result['isAdmin_user']);
                MainDAO::getUserBorrow($CurrentUser);
                return $CurrentUser;
            }
        }
        catch (Exception $e)
        {
            throw new Exception("Could not get the current user");
        }
    }

    public static function changePassword($idUser,$newPassword)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $con->beginTransaction();

        $hashedNewPassword= sha1($newPassword);

        try
        {
            $requete = "UPDATE USERS SET password_user= ? WHERE id_user = ?;";
            $stmt = $con->prepare($requete);
            $stmt->execute([$hashedNewPassword,$idUser]);
            $con->commit();
            return true;
        }
        catch (Exception $e)
        {
            $con->rollback();
            throw new Exception("Could not update password");
        }
    }

    private static function getUserBorrow($user)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        try
        {
            $myQuery = "SELECT borrow_info.id_borrow,startdate_borrow,enddate_borrow,isActive, borrow.id_device, device.ref_equip FROM borrow_info 
                        INNER JOIN borrow INNER JOIN device ON borrow.id_borrow= borrow_info.id_borrow AND borrow.id_device= device.id_device
                        WHERE borrow.id_user = ? AND borrow_info.isActive=1;";
            $myStatement = $con->prepare($myQuery);
            $myStatement->execute([$user->getIdUser()]);

            $result = $myStatement->rowCount();
            $borrowLignes = $myStatement->fetchAll();

            if ($result == 0)
            {
                // nothing to push into borrow
            }
            else
            {
                foreach ($borrowLignes as $borrow)
                {
                    $BorrowItem = new Borrow($borrow['ref_equip'], $borrow['enddate_borrow']);
                    $BorrowItem->setStartDate($borrow['startdate_borrow']);
                    $BorrowItem->setDeviceId($borrow['id_device']);
                    $BorrowItem->setIdBorrow($borrow['id_borrow']);
                    $user->addBorrowToList($BorrowItem);
                }
            }
            return true;
        }
        catch (PDOException $e)
        {
            throw new Exception("Could not get current user borrows");
        }

    }

    /* PRECONDITION ON NE PEUT PAS DELETE DES DEVICES DONT LE CHAMP isAVAILABLE EST FALSE, $desiredQuantity ne peut pas etre < 0, */
    public static function updateDeviceCount($_ref_equip, $desiredQuantity)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $requestCount = "SELECT COUNT(*) FROM DEVICE WHERE ref_equip = '$_ref_equip';";
        $answerCount = $con->query($requestCount);
        $resultCount = $answerCount->fetch();
        $numberOfDevices = $resultCount['COUNT(*)'];

        if ($numberOfDevices > $desiredQuantity)
        {
            $indexOf = 0;
            echo ("numberOfDevices". $numberOfDevices."\n");
            echo ("desiredQuantity". $desiredQuantity."\n");

            while ($indexOf < ($numberOfDevices - $desiredQuantity))
            {
                echo ("indexOf". $indexOf."\n");
                $con->beginTransaction();
                try
                {
                    $requestDelete = "DELETE FROM device WHERE ref_equip = ? AND isAvailable = 1 LIMIT 1;";
                    $myStatement = $con->prepare($requestDelete);
                    $myStatement->execute([$_ref_equip]);
                    $con->commit();
                }
                catch (PDOException $e)
                {
                    $con->rollback();
                    //throw new PDOException('Erreur update device count');
                }
                $indexOf++;
            }

        } elseif ($numberOfDevices < $desiredQuantity) {
            $indexOf = 0;
            while ($indexOf < ($desiredQuantity - $numberOfDevices)) {
                $con->beginTransaction();
                try {
                    $requestDelete = "INSERT INTO device(isAvailable,ref_equip) VALUES (1, ? ); ";
                    $myStatement = $con->prepare($requestDelete);
                    $myStatement->execute([$_ref_equip]);
                    $con->commit();
                } catch (PDOException $e) {
                    $con->rollback();
                    throw new PDOException('Erreur update device count ');
                }
                $indexOf++;
            }
        }
    }

    /* PREC l'utilistauer existe dans la bdd + AJOUTE FONCTION UPDATEPASSWORD */
    public static function modifyAnyProfile($_id_user, $_matricule_user, $_email_user, $_name_user, $_lastname_user, $_phone, $_isAdmin_user)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        try {

            $con->beginTransaction();

            $query = "UPDATE users SET matricule_user=?,email_user=?,name_user=?,lastname_user=?,phone_user=?,isAdmin_user=? where users.id_user = ?  ;";
            $stmt = $con->prepare($query);
            $stmt->execute([$_matricule_user, $_email_user, $_name_user, $_lastname_user, $_phone, $_isAdmin_user, $_id_user]);
            $con->commit();

        } catch (PDOException $e) {
            $con->roleback();
            throw new PDOException("Error!: " . $e->getMessage());
        }
        $bdd->closeCon();
    }

    /* prec le ref equipement ne doit pas deja etre dans la bdd et quantity >0   */
    public static function createEquipment($_ref_equipNew, $type_equipNew, $brand_equipNew, $name_equipNew, $version_equipNew, $quantity)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $con->beginTransaction();

        try
        {
            $requestCreate = " INSERT INTO equipment (ref_equip, type_equip, brand_equip, name_equip,version_equip) VALUES 
            (?, ?, ?,?,?) ;";
            $myStatement = $con->prepare($requestCreate);
            $myStatement->execute([$_ref_equipNew, $type_equipNew, $brand_equipNew, $name_equipNew, $version_equipNew]);

            for ($indexOf = 0; $indexOf < $quantity; $indexOf++) {
                $requestCreate2 = " INSERT INTO device (isAvailable, ref_equip) VALUES ( 1, ?) ;";
                $myStatement2 = $con->prepare($requestCreate2);
                $myStatement2->execute([$_ref_equipNew]);
            }
            $con->commit();
            return true;
        }
        catch (PDOException $e)
        {
            $con->rollback();
            throw new Exception("Erreur dans la création de l'équipement");
        }
    }

    /* PREC $_ref_equipUpdate != any existent ref*/
    public static function modifyEquipment($ref_equipToUpdate, $ref_equipUpd, $type_equipUpd, $brand_equipUpd, $name_equipUpd, $version_equipUpd)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        try {

            $con->beginTransaction();
            $requestUpdate = "UPDATE EQUIPMENT SET ref_equip=?, type_equip =?, brand_equip =?, name_equip =?, version_equip =? where ref_equip like ? ;";
            $myStatement = $con->prepare($requestUpdate);
            $myStatement->execute([$ref_equipUpd, $type_equipUpd, $brand_equipUpd, $name_equipUpd, $version_equipUpd, $ref_equipToUpdate]);

            $requestUpdate2 = "UPDATE device SET ref_equip=? where ref_equip like ? ;";
            $myStatement2 = $con->prepare($requestUpdate2);
            $myStatement2->execute([$ref_equipUpd,$ref_equipToUpdate]);

            $con->commit();
        } catch (PDOException $e) {
            $con->rollback();
            throw new Exception("Error ModifyEquipment() : " . $e->getMessage());
        }
        $bdd->closeCon();
    }

    public static function createUser($_matricule_user, $_email_user, $_password_user, $_name_user, $_lastname_user, $_phone, $_isAdmin_user)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        try
        {
            $con->beginTransaction();

            $query = "INSERT INTO users (matricule_user,email_user,password_user,name_user,lastname_user,phone_user,isAdmin_user) VALUES (?,?,?,?,?,?,?);";
            $stmt = $con->prepare($query);
            $stmt->execute([$_matricule_user, $_email_user, $_password_user, $_name_user, $_lastname_user, $_phone, $_isAdmin_user]);
            $con->commit();
        }
        catch (PDOException $e)
        {
            $con->rollback();
            throw new Exception("<p> Could not create the user, invalid user input </p> ");
        }
        $bdd->closeCon();
    }

    public static function connection($matriculeUser,$hash_mdp)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        try
        {
            $requete = "SELECT * FROM users WHERE matricule_user = ? AND password_user= ? ;";
            $stmt = $con->prepare($requete);
            $stmt->execute([$matriculeUser, $hash_mdp]);
            $count = $stmt->rowCount();

            $result = $stmt->fetch();

            if($count ==1)
            {
                return $result['id_user'];
            }
            else
                return false;
        }
        catch (PDOException $e)
        {
            throw new Exception("Could not connect to DataBase");
        }
    }

    public static function howMuchAvailable($ref_equip)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $query = "select count(*) as 'somme' from device INNER JOIN equipment on device.ref_equip Like equipment.ref_equip where device.ref_equip like ? and isAvailable = 1; ";
        $stmt = $con->prepare($query);
        $stmt->execute([$ref_equip]);
        $result = $stmt->fetch();

        return $result['somme'];
    }

    public static function howMuchTotal($ref_equip)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $query = "select count(*) as 'somme' from device INNER JOIN equipment on device.ref_equip Like equipment.ref_equip where device.ref_equip like ? ; ";
        $stmt = $con->prepare($query);
        $stmt->execute([$ref_equip]);
        $result = $stmt->fetch();

        return $result['somme'];
    }

/*
    public static function getIdBorrow($ref_equip)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        try
        {
            $requestSelect = "SELECT * FROM borrow WHERE isAvailable = TRUE AND ref_equip = '$ref_equip';";
            $answerSelect = $con->query($requestSelect);
            $resultSelect = $answerSelect->fetch();
            return $resultSelect['id_borrow'];

        }
        catch (Exception $e)
        {
            throw new Exception("Could not get idBorrow");
        }
    }
*/
    public static function getIdDevice($ref_equip)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        try
        {
            $requestSelect = "SELECT id_device FROM DEVICE WHERE isAvailable = TRUE AND ref_equip = '$ref_equip';";
            $answerSelect = $con->query($requestSelect);
            $resultSelect = $answerSelect->fetch();
            return $resultSelect['id_device'];

        }
        catch (PDOException $e)
        {
            throw new Exception("Could not get the idDevice");
        }
    }

    /*
    public function isRefEquipValid(): bool
    {
        if (strlen($this->_ref_equip)) {
            $bdd = new DataBase();
            $con = $bdd->getCon();
            $query = ("select count(*) as 'somme' from equipment where ref_equip like ? ;");
            $stmt = $con->prepare($query);
            $stmt->execute([$this->_ref_equip]);
            $result = $stmt->fetch();
            $bdd->closeCon();
            if ($result['somme'] > 0) {
                return true;
            }

        }
        return false;
    }*/

}