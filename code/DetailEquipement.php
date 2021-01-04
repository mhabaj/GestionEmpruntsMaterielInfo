<?php
require_once("Controller/control-session.php");

require_once("Controller/DataBase.php");
require_once("Model/UserRegular.php");
require_once("Model/Equipment.php");
require_once("Controller/EquipmentController.php");
require_once "Controller/Functions.php";


if (isset($_GET['ref_equip']) && $_GET['ref_equip'] != null) {

    try {
        $EquipmentController = new EquipmentController();
        $EquipmentController->initEquipmentController($_GET['ref_equip']);
        $currentEquipement = $EquipmentController->getEquipment();
        ?>

        <?php
        //INCLUDE VIEW:

        include_once("view/detailEquipment.view.php");


        ?>


        <?php
        if (isset($_POST['reserveEquipment']) && isset($_POST['dateRes']) && isset($_POST['quantiteNumber']) && isset($EquipmentController) && $EquipmentController != null) {

            $dateFinBorrow = $_POST['dateRes'];
            $quantite_equip = $_POST['quantiteNumber'];

            $EquipmentController->reserveEquipment($dateFinBorrow, $quantite_equip);

        }

    } catch (Exception $e) {
        header("refresh:3;url=Catalogue.php");
        echo $e->getMessage();
        echo "<p> Redirection dans 3 secondes.. </p>";


    }
} else {
    header('Location: Catalogue.php');

}

