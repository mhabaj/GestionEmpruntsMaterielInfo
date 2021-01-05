<?php
require_once("ControllerDAO/UserDAO.php");
if (!isset($_SESSION['id_user'])) {
    $erreur = "";
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

            if (strlen($matricule) == 7) {
                if(!UserDAO::connect($matricule, $password))
                {
                    $erreur = "Identifiant ou mot de passe incorrects.";
                }else {
                    header('Location: DashBoard.php');
                }

            }

        } else {
            header('Location: DashBoard.php');
        }
    }
} else {
    header('Location: DashBoard.php');
}

?>