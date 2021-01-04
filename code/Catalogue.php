<?php

require_once("Controller/control-session.php");
require_once "Controller/DataBase.php";
require_once "Model/Equipment.php";
require_once "Model/UserRegular.php";
require_once "Model/UserAdmin.php";
require_once "Controller/Functions.php";
require_once "Controller/EquipmentController.php";
require_once "Controller/CatalogueController.php";

$myCatalogueController = new CatalogueController();

/*********************************************************************************************************************/

require_once "view/buttondetailUser.view.php";
require_once "view/searchEquipment.view.php";
if (isset($_POST['startSearching']) && $_POST['EquipmentToSearch'] != null && $_POST['EquipmentToSearch'] != " ") {
    $myCatalogueController->searchEquipment();
}

/********************************************************************************************************************/
$myCatalogueController->getEquipmentList();
?>

<?php
if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {
    $currentUser = MainDAO::getUser($_SESSION['id_user']);

    require_once "view/adminOverview.view.php";
    if ($currentUser->getPrivilege() == 1) {
        if (isset($_POST['addEquip'])) {
            header("Location: creationEquipement.php");
        }
    }
    /*****************************************************************************************************************************************/
    if (isset($_POST['startSearchingUser']) && $_POST['UserToSearch'] != null && $_POST['UserToSearch'] != " ") {
        $myCatalogueController->searchUser();
    }
}
/*****************************************************************************************************************************************/

?>

