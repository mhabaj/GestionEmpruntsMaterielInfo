<?php
$title = "Catalogue";
$erreur = "";
$erreurAdmin = "";
require_once("Controller/control-session.php");
require_once "Controller/DataBase.php";
require_once "Model/Equipment.php";
require_once "Controller/Functions.php";
require_once "Controller/EquipmentController.php";
require_once "ControllerDAO/CatalogueController.php";
ob_start();

$myCatalogueController = new CatalogueController();

/*********************************************************************************************************************/


if (isset($_POST['startSearching']) && $_POST['EquipmentToSearch'] != null && $_POST['EquipmentToSearch'] == trim($_POST['EquipmentToSearch'])) {
    try {
        $myCatalogueController->searchEquipment();
    } catch (Exception $e) {
        $erreur = "<p>" . $e->getMessage() . "</p>";
    }
}
require_once "view/buttondetailUser.view.php";
require_once "view/searchEquipment.view.php";
/********************************************************************************************************************/
$myCatalogueController->getEquipmentList();

if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {

    /*****************************************************************************************************************************************/
    if (isset($_POST['startSearchingUser']) && $_POST['UserToSearch'] != null && $_POST['UserToSearch'] == trim($_POST['UserToSearch'])) {
        try {
            $myCatalogueController->searchUser();
        } catch (Exception $e) {
            $erreurAdmin = "<p>" . $e->getMessage() . "</p>";
        }
    }
    require_once "view/adminOverview.view.php";

}
/*****************************************************************************************************************************************/