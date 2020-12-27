<?php
require_once("Controller/DataBase.php");
require_once("Model/User.php");
require_once("Model/UserRegular.php");
require_once("Model/UserAdmin.php");
require_once ("Controller/AuthentificationController.php");

if (!isset($_SESSION['id_user']))
{
?>

    <?php
        //INCLUDE VIEW ICI:
            require_once("view/authentification.view.php");
    ?>


    <?php


    if (isset($_POST['submitLogin'])) {

        if (!isset($_SESSION['id_user'])) {
            $matricule = $_POST['matricule'];
            $password = $_POST['password'];

            if (strlen($matricule) == 7)
            {
                $authCont = new AuthentificationController($matricule, $password);
                $authCont->identification();
            }

        } else {
            header('Location: Catalogue.php');
        }
    }
} else {
    header('Location: Catalogue.php');
}

?>