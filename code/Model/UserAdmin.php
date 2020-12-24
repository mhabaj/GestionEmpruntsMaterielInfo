<?php


require_once("Model/User.php");

class UserAdmin extends User
{
    // dans le controller
    public function identification($_matriculeUser, $_password)
    {
        $this->_matriculeUser = $_matriculeUser;
        $this->_password = $_password;
        $this->connect();
    }

    public function consultUser($_id_user)
    {
        $bdd= new DataBase();
        $con= $bdd->getCon();
        $query="SELECT * FROM users WHERE id_user= ? ;";
        $stmt=$con->prepare($query);
        $stmt->execute([$_id_user]);
        $result=$stmt->fetchAll();

        echo 'pseudo :', $result['matricule_user'];
        echo 'email :', $result['email_user '];
        echo 'prenom :', $result['name_user'];
        echo 'nom :', $result['lastname_user'];
        echo 'numero :', $result['phone_user'];
        $bdd->closeCon();
    }
    public function createUser($_matricule_user,$_email_user,$_password_user,$_name_user,$_lastname_user,$_phone,$_isAdmin_user)
    {
        $bdd= new DataBase();
        $con= $bdd->getCon();
        $query="INSERT INTO users (matricule_user,email_user,password_user,name_user,lastname_user,phone_user,isAdmin_user) VALUES (?,?,?,?,?,?,?);";
        $stmt=$con->prepare($query);
        $stmt->execute([$_matricule_user,$_email_user,$_password_user,$_name_user,$_lastname_user,$_phone,$_isAdmin_user]);
        $bdd->closeCon();
    }
    /* PRECONDITION ON NE PEUT PAS DELETE DES DEVICES DONT LE CHAMP isAVAILABLE EST FALSE, $desiredQuantity ne peut pas etre < 0, */
    public function updateDeviceCount($_ref_equip,$desiredQuantity)
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
            echo $numberOfDevices;
            echo $desiredQuantity;
            echo "avant";
            while($indexOf < ($numberOfDevices - $desiredQuantity))
            {
                echo $indexOf;
                $con->beginTransaction();
                try
                {
                    $requestDelete = "DELETE FROM device WHERE ref_equip = ? AND isAvailable = 1 LIMIT 1;";
                    $myStatement = $con->prepare($requestDelete);
                    $myStatement->execute([$_ref_equip]);
                    $con->commit();
                }
                catch(PDOException $e)
                {
                    $con->rollback();
                    throw new PDOException('Erreur update device count');
                }
                $indexOf++;
            }

        }
        elseif ($numberOfDevices < $desiredQuantity)
        {
            $indexOf = 0;
            while($indexOf < ($desiredQuantity - $numberOfDevices))
            {
                $con->beginTransaction();
                try
                {
                    $requestDelete = "INSERT INTO device(isAvailable,ref_equip) VALUES (1, ? ); ";
                    $myStatement = $con->prepare($requestDelete);
                    $myStatement->execute([$_ref_equip]);
                    $con->commit();
                }
                catch(PDOException $e)
                {
                    $con->rollback();
                    throw new PDOException('Erreur update device count');
                }
                $indexOf++;
            }

        }
        else
        {
            //rien à changer
        }
    }
    /* */
    public function deleteEquipment($_ref_equipDel)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $con->beginTransaction();
        try
        {
            $requestDelete = " DELETE FROM device WHERE isAvailable = TRUE AND ref_equip = ? ; ";
            $myStatement = $con->prepare($requestDelete);
            $myStatement->execute([$_ref_equipDel]);
            $con->commit();
        }
        catch(PDOException $e)
        {
            $con->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
        $bdd->closeCon();
    }
    /* PREC $_ref_equipUpdate != any existent ref*/
    public function modifyEquipment($_ref_equipUpdate, $type_equipUpd, $brand_equipUpd,$name_equipUpd, $version_equipUpd)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $con->beginTransaction();

        try
        {
            $requestUpdate = "UPDATE EQUIPMENT SET type_equip =?, brand_equip =?, name_equip =?, version_equip =? where ref_equip like ? ;";
            $myStatement = $con->prepare($requestUpdate);
            $myStatement->execute([$_ref_equipUpdate, $type_equipUpd, $brand_equipUpd, $name_equipUpd, $version_equipUpd, $_ref_equipUpdate]);
            $con->commit();
        }
        catch(PDOException $e)
        {
            $con->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
        $bdd->closeCon();
    }

    /* prec le ref equipement ne doit pas deja etre dans la bdd et quantity >0   */
    public function createEquipment($_ref_equipNew, $type_equipNew, $brand_equipNew,$name_equipNew, $version_equipNew,$quantity)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $con->beginTransaction();

        try
        {
            $requestCreate = " INSERT INTO equipment (ref_equip, type_equip, brand_equip, name_equip,version_equip) VALUES 
            (?, ?, ?,?,?) ;";
            $myStatement = $con->prepare($requestCreate);
            $myStatement->execute([$_ref_equipNew,$type_equipNew,$brand_equipNew,$name_equipNew,$version_equipNew]);

            for($indexOf =0 ; $indexOf < $quantity ; $indexOf++)
            {
                $requestCreate2 = " INSERT INTO device (isAvailable, ref_equip) VALUES ( 1, ?) ;";
                $myStatement2 = $con->prepare($requestCreate2);
                $myStatement2->execute([$_ref_equipNew]);
            }
            $con->commit();
        }
        catch(PDOException $e)
        {
            $con->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
        $bdd->closeCon();
    }

    /* PREC l'utilistauer existe dans la bdd */
    public function modifyRole($_id_user,$_new_isAdmin_user)
    {
        $bdd= new DataBase();
        $con= $bdd->getCon();
        $query="UPDATE users SET isAdmin_user=? WHERE id_user=?;";
        $stmt=$con->prepare($query);
        $stmt->execute([$_new_isAdmin_user,$_id_user]);
        $bdd->closeCon();

    }
    /* PREC l'utilistauer existe dans la bdd */
    public function modifyAnyProfile($_id_user,$_matricule_user,$_email_user,$_password_user,$_name_user,$_lastname_user,$_phone,$_isAdmin_user)
    {
        $bdd= new DataBase();
        $con= $bdd->getCon();
        $con->beginTransaction();
        try {
            $query = "UPDATE users SET matricule_user=?,email_user=?,password_user=?,name_user=?,lastname_user=?,phone_user=?,isAdmin_user=? where users.id_user = ?  ;";
            $stmt = $con->prepare($query);
            $stmt->execute([$_matricule_user, $_email_user, $_password_user, $_name_user, $_lastname_user, $_phone, $_isAdmin_user, $_id_user]);
        }catch(PDOException $e)
        {
            throw new PDOException("Error!: " . $e->getMessage());
        }
        $bdd->closeCon();
    }

    /**
     * @param $id_borrow_toDel
     */
    public function endborrow($id_borrow_toDel)
    {
        $cpt_array = 0;
        foreach($this->_borrowList as $borrow):
            echo 'JE SUIS DANS LA FOR';
            var_dump($borrow);
            if($borrow->getIdBorrow() == $id_borrow_toDel )
            {
                echo 'JE SUIS DANS LA BOUCLE';
                $borrow->stopBorrow();
                unset($this->_borrowList[$cpt_array]);
                break;
            }
            $cpt_array+=1;
        endforeach;
    }

}

//$admin = new UserAdmin();
//$admin->identification('admin','12345');

//$admin->loadUser();
//$admin->createEquipment('AX151','Smartphone','Iphone','9','9.0',6);
//$admin->createEquipment('XX157','Smartphone','HUWEI','11','15.0',5);
//$admin->createEquipment('XX283','Smartphone','HUWEI','11','15.0',5);
//$admin->borrowEquipement('XX157','2021/12/05',1);
//$admin->borrowEquipement('AX156','2021/07/15',1);
//$admin->borrowEquipement('AX156','2021/11/12',1);

//$admin->updateDeviceCount('XX157',3);

//var_dump($admin);
//$admin->endborrow(5);
//echo 'salut';
//var_dump($admin->getBorrowList());

