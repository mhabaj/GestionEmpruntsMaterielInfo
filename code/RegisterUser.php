<?php

require_once("Controller/control-session.php");
require_once("Controller/DataBase.php");
require_once("Model/User.php");
require_once("Controller/UserController.php");

/* catch les erreurs */
if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {


    //on include inscriptions.view
    require_once('view/inscription.view.php');
    ?>

    <?php


    /* si l'admin décide de créer un utilisateur*/
    if (isset($_POST['submitInscription'])) {
        try {
            $userController = new UserController($_SESSION['id_user']);

            if (isset($_POST['administrateur']) && isset($_POST['matricule']) && isset($_POST['password']) && isset($_POST['passwordrepeat']) && isset($_POST['name']) && isset($_POST['lastname'])
                && isset($_POST['phone']) && isset($_POST['administrateur'])) {
                if ($userController->createUser($_POST['matricule'], $_POST['password'], $_POST['passwordrepeat'], $_POST['email'], $_POST['name'], $_POST['lastname'], $_POST['phone'], $_POST['administrateur']) == true) {
                    header('Location:DashBoard.php');
                }
            }
        } catch (Exception $e) {
            header('Location:DashBoard.php');
            echo $e->getMessage();

        }

    }

} else {
    header('Location:DashBoard.php');

}
