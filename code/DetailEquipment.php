<?php
require_once("Controller/control-session.php");

require_once("Model/Equipment.php");
require_once("Controller/EquipmentController.php");
require_once "Controller/Functions.php";


if (isset($_GET['ref_equip']) && $_GET['ref_equip'] != null) {

    try {
        $equipmentController = new EquipmentController();
        $equipmentController->loadEquipmentFromDDB($_GET['ref_equip']);
        $currentEquipment = $equipmentController->getEquipment();
        ?>

        <?php
        //INCLUDE VIEW:

        include_once("view/detailEquipment.view.php");


        ?>


        <?php
        if (isset($_POST['reserveEquipment']) && isset($_POST['dateRes']) && isset($_POST['quantiteNumber']) && isset($equipmentController) && $equipmentController != null) {

            $dateFinBorrow = $_POST['dateRes'];
            $quantite_equip = $_POST['quantiteNumber'];

            $userController = new UserController(['id_user']);

            $userController->startBorrow($currentEquipment->getRefEquip(), $dateFinBorrow, $quantite_equip);

        }

    } catch (Exception $e) {
        header("refresh:3;url=DashBoard.php");
        echo $e->getMessage();
        echo "<p> Redirection dans 3 secondes.. </p>";


    }
} else {
    header('Location: DashBoard.php');

}

