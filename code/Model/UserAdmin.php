<?php


require_once("Model/User.php");
require_once("Controller/Functions.php");

class UserAdmin extends User
{
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

    /* if la photo existe deja ->update sinon insert */
    public function updateImageToEquipment(string $photo, string $refEquip)
    {

        $bdd = new DataBase();
        $con = $bdd->getCon();
        $con->beginTransaction();
        echo(1);

        try
        {
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

}
/*
$admin = new UserAdmin();
$admin->identification('admin12','admin');
$admin->endborrow(5);*/
//$admin->loadUser();
//$admin->createEquipment('AX151','Smartphone','Iphone','9','9.0',6);
//$admin->createEquipment('XX157','Smartphone','HUWEI','11','15.0',5);
//$admin->createEquipment('XX283','Smartphone','HUWEI','11','15.0',5);
//$admin->borrowEquipement('XX157','2021/12/05',1);
//$admin->borrowEquipement('AX156','2021/07/15',1);


//$admin->updateDeviceCount('XX157',3);

//var_dump($admin);
//$admin->endborrow(5);
//echo 'salut';
//var_dump($admin->getBorrowList());

