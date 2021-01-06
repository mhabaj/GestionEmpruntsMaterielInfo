<?php

require_once("ControllerDAO/UserDAO.php");
ob_start();

if (!isset($_SESSION['id_user']) || ($_SESSION['id_user'] != '')) {
    $erreur = "";
    ?>

    <?php
    //INCLUDE VIEW ICI:
    require_once("view/authentification.view.php");
    ?>

    <?php

    if (isset($_POST['submitLogin'])) {

        $matricule = $_POST['matricule'];
        $password = $_POST['password'];

        if (strlen($matricule) == 7) {
            if (!UserDAO::connect($matricule, $password)) {
                echo "<p>Identifiant ou mot de passe incorrects.</p>";
            } else {
                ob_end_clean();
                header('Location: DashBoard.php');
            }

        } else {
            echo "<p>Matricule Entrée Invalide</p>";
        }
    }
} else {
    ob_end_clean();
    header('Location: DashBoard.php');
}

