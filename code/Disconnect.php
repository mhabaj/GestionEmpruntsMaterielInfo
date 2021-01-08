<?php
require_once("Controller/control-session.php");
require_once("Controller/UserController.php");

if (isset($_GET["disconnect"]) && isset($_SESSION["id_user"]) && $_SESSION["id_user"] != null){

    $tmpUsrCtrl = new UserController($_SESSION["id_user"]);
    $tmpUsrCtrl->disconnect();
    header('Location: Authentification.php');
    exit();
}