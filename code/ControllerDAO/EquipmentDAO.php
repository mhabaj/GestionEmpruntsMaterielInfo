<?php

require_once "D:/wamp64/www/GestionEmpruntsMaterielInfo/code/Controller/DataBase.php";

/**
 * Class EquipmentDAO
 */
class EquipmentDAO
{


    public function __construct()
    {
    }

    /**
     * @param $refEquipment
     * @return Equipment
     * @throws Exception
     */
    public function initEquipmentController($refEquipment): Equipment
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $queryEquipments = "SELECT * FROM equipment WHERE equipment.ref_equip LIKE ?;";
        $myStatement = $con->prepare($queryEquipments);
        $myStatement->execute([$refEquipment]);

        $donnees = $myStatement->fetch();
        if ($donnees['ref_equip'] != null) {
            $equipment = new Equipment($donnees['ref_equip'], $donnees['type_equip'], $donnees['name_equip'], $donnees['brand_equip'], $donnees['version_equip']);
            $queryPhotos = "SELECT link_photo FROM stock_photo WHERE ref_equip LIKE ?; ";
            $myStatement1 = $con->prepare($queryPhotos);
            $myStatement1->execute([$refEquipment]);
            while ($donnees1 = $myStatement1->fetch()) {
                if (isset($donnees1['link_photo'])) {
                    $arrayPhoto = array();
                    array_push($arrayPhoto, $donnees1['link_photo']);
                    $equipment->setPhotoArray($arrayPhoto);
                } else {
                    $arrayPhoto = array();
                    $equipment->setPhotoArray($arrayPhoto);

                }
            }
            $myStatement1->closeCursor();
            $bdd->closeCon();

            if ($equipment != null) {
                return $equipment;
            } else {
                throw new Exception("Exception Equipment Controller: Invalid refEquipment");
            }
        } else {
            throw new Exception("Exception Equipment Controller: Invalid refEquipment");
        }
    }

    /* PREC $_ref_equipUpdate != any existent ref*/
    /**
     * @param $ref_equipToUpdate
     * @param $ref_equipUpd
     * @param $type_equipUpd
     * @param $brand_equipUpd
     * @param $name_equipUpd
     * @param $version_equipUpd
     * @throws Exception
     */
    public function modifyEquipment($ref_equipToUpdate, $ref_equipUpd, $type_equipUpd, $brand_equipUpd, $name_equipUpd, $version_equipUpd)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        try {

            $con->beginTransaction();
            $requestUpdate = "UPDATE EQUIPMENT SET ref_equip=?, type_equip =?, brand_equip =?, name_equip =?, version_equip =? where ref_equip like ? ;";
            $myStatement = $con->prepare($requestUpdate);
            $myStatement->execute([$ref_equipUpd, $type_equipUpd, $brand_equipUpd, $name_equipUpd, $version_equipUpd, $ref_equipToUpdate]);
            $con->commit();
        } catch (PDOException $e) {
            $con->rollback();
            throw new Exception("Error ModifyEquipment() : " . $e->getMessage());
        }
        $bdd->closeCon();
    }

    /* prec le ref equipement ne doit pas deja etre dans la bdd et quantity >0   */
    /**
     * @param $_ref_equipNew
     * @param $type_equipNew
     * @param $brand_equipNew
     * @param $name_equipNew
     * @param $version_equipNew
     * @param $quantity
     */
    public function createEquipment($_ref_equipNew, $type_equipNew, $brand_equipNew, $name_equipNew, $version_equipNew, $quantity)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $con->beginTransaction();

        try {
            $requestCreate = " INSERT INTO equipment (ref_equip, type_equip, brand_equip, name_equip,version_equip) VALUES 
            (?, ?, ?,?,?) ;";
            $myStatement = $con->prepare($requestCreate);
            $myStatement->execute([$_ref_equipNew, $type_equipNew, $brand_equipNew, $name_equipNew, $version_equipNew]);

            for ($indexOf = 0; $indexOf < $quantity; $indexOf++) {
                $requestCreate2 = " INSERT INTO device (isAvailable, ref_equip) VALUES ( 1, ?) ;";
                $myStatement2 = $con->prepare($requestCreate2);
                $myStatement2->execute([$_ref_equipNew]);
            }

            $requestCreate = " INSERT INTO `stock_photo` (`link_photo`, `ref_equip`) VALUES (?,?);";
            $myStatement = $con->prepare($requestCreate);
            $myStatement->execute(["", $_ref_equipNew]);


            $con->commit();
        } catch (PDOException $e) {
            $con->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
        $bdd->closeCon();
    }

    /* PRECONDITION ON NE PEUT PAS DELETE DES DEVICES DONT LE CHAMP isAVAILABLE EST FALSE, $desiredQuantity ne peut pas etre < 0, */
    public function updateDeviceCount($_ref_equip, $desiredQuantity)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $requestCount = "SELECT COUNT(*) FROM DEVICE WHERE ref_equip = '$_ref_equip';";
        $answerCount = $con->query($requestCount);
        $resultCount = $answerCount->fetch();
        $numberOfDevices = $resultCount['COUNT(*)'];

        if ($numberOfDevices > $desiredQuantity) {
            $indexOf = 0;
            while ($indexOf < ($numberOfDevices - $desiredQuantity)) {
                $con->beginTransaction();
                try {
                    $requestDelete = "DELETE FROM device WHERE ref_equip = ? AND isAvailable = 1 LIMIT 1;";
                    $myStatement = $con->prepare($requestDelete);
                    $myStatement->execute([$_ref_equip]);
                    $con->commit();
                } catch (PDOException $e) {
                    $con->rollback();
                    throw new PDOException('Erreur update device count');
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


    /**
     * @param string $photo
     * @param string $refEquip
     * @throws Exception
     */
    public function addImageToEquipment(string $photo, string $refEquip)
    {

        $bdd = new DataBase();
        $con = $bdd->getCon();
        $con->beginTransaction();

        try {
            $requestCreate = "INSERT INTO `stock_photo` (`link_photo`, `ref_equip`) VALUES ( ?, ?);";
            $myStatement = $con->prepare($requestCreate);
            $myStatement->execute([$photo, $refEquip]);
            $con->commit();
        } catch (PDOException $e) {
            $con->rollback();
            throw new Exception($e->getMessage());
        }
        $bdd->closeCon();


    }

    /**
     * @param string $photo
     * @param string $refEquip
     * @throws Exception
     */
    public function updateImageToEquipment(string $photo, string $refEquip)
    {

        $bdd = new DataBase();
        $con = $bdd->getCon();
        $con->beginTransaction();

        try {
            $requestCreate = "UPDATE `stock_photo` SET `link_photo` = ? WHERE `stock_photo`.ref_equip like  ?;";

            $myStatement = $con->prepare($requestCreate);
            $myStatement->execute([$photo, $refEquip]);
            $con->commit();
        } catch (PDOException $e) {
            $con->rollback();
            throw new Exception($e->getMessage());
        }
        $bdd->closeCon();


    }

    /**
     * @param $ref
     * @param $equipment
     * @return bool
     * @throws Exception
     */
    public function isRefEquipUsed($ref, $equipment): bool
    {
        if ($ref != $equipment->getRefEquip()) {
            $bdd = new DataBase();
            $con = $bdd->getCon();
            $query = "select count(*) as 'somme' from equipment where ref_equip like ? ;";
            $stmt = $con->prepare($query);
            $stmt->execute([$ref]);
            $result = $stmt->fetch();
            $bdd->closeCon();

            if ($result['somme'] >= 1) {
                throw new Exception("Ref equipment is already used");
            } else {
                return false;
            }

        }

        return false;
    }

    /**
     * @param $ref_equip
     * @return bool
     * @throws Exception
     */
    public function isNewRefEquipUsed($ref_equip): bool
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $query = "select count(*) as 'somme' from equipment where ref_equip like ? ;";
        $stmt = $con->prepare($query);
        $stmt->execute([$ref_equip]);
        $result = $stmt->fetch();
        $bdd->closeCon();

        if ($result['somme'] >= 1) {
            throw new Exception("Ref equipment is already used");
        }


        return false;
    }

    /**
     * @param $ref_equip
     * @return bool
     */


    /**
     * @param $ref_equip
     * @return mixed
     */
    public function howMuchAvailable($ref_equip)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $query = "select count(*) as 'somme' from device INNER JOIN equipment on device.ref_equip Like equipment.ref_equip where device.ref_equip like ? and isAvailable = 1; ";
        $stmt = $con->prepare($query);
        $stmt->execute([$ref_equip]);
        $result = $stmt->fetch();
        $bdd->closeCon();
        return $result['somme'];
    }

    /**
     * @param $ref_equip
     * @return mixed
     */
    public function howMuchTotal($ref_equip)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $query = "select count(*) as 'somme' from device INNER JOIN equipment on device.ref_equip Like equipment.ref_equip where device.ref_equip like ? ; ";
        $stmt = $con->prepare($query);
        $stmt->execute([$ref_equip]);
        $result = $stmt->fetch();
        $bdd->closeCon();
        return $result['somme'];
    }

}