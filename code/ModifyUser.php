<?php

require_once("Controller/control-session.php");
require_once("Model/User.php");
require_once("Controller/UserController.php");
require_once("ControllerDAO/UserDAO.php");

if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1 && isset($_GET['id_user_toDisplay']) || $_GET['id_user_toDisplay'] == $_SESSION['id_user'] && isset($_GET['id_user_toDisplay']))
{
    if(!UserDAO::userExists($_GET['id_user_toDisplay']))
        header('Location: DashBoard.php');

    $userController = new UserController($_GET['id_user_toDisplay']);

    $currentUser = $userController->getUser();

    /* si l'utilisateur a cliqué sur modifier utilisateur */
    if (isset($_POST['modifyUser']) && isset($_GET['id_user_toDisplay']) && (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null)) {

        //include modifyUser.view
        require_once('view/modifyUser.view.php');

    }
    /* Traitement de la page modifier utilisateur */
    if (isset($_POST['submitModification'])) {
        try {
            if ($userController->modifyUser($_GET['id_user_toDisplay'], $_POST['matricule'], $_POST['email'], $_POST['lastname'], $_POST['name'], $_POST['phone'], $_POST['administrateur']) == true)
                header('Location: DetailUser.php?id_user_toDisplay=' . $currentUser->getIdUser());
        } catch (Exception $e) {
            $url = 'DetailUser.php?id_user_toDisplay=' . $currentUser->getIdUser();
            header("refresh:2;url=$url");
            echo $e->getMessage();
        }
    }

    if (isset($_POST['cancelbtn'])) {
        header('Location: DetailUser.php?id_user_toDisplay=' . $currentUser->getIdUser());
    }

    /* si l'utilisateur a cliqué sur modifier password */
    if (isset($_GET['id_user_toDisplay']) && isset($_POST['modifyPassword']) && (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null)) {
        ?>


        <?php
        //include modifyPassword.view
        require_once('view/modifyPassword.view.php');
        ?>


        <?php
    }
    /* Traitement de la page modifier password  */
    if (isset($_POST['submitModificationMdp'])) {
        if (isset($_POST['password']) && isset($_POST['passwordrepeat'])) {
            if ($userController->modifyPassword($_POST['password'], $_POST['passwordrepeat']) == false) {
                $url = 'DetailUser.php?id_user_toDisplay=' . $currentUser->getIdUser();
                header("refresh:2;url=.$url");
                $erreur = "<p> Les deux mots de passe ne correspondent pas <p/>";
            } else {
                header('Location: DetailUser.php?id_user_toDisplay=' . $currentUser->getIdUser());
            }
        }

    }

    if (isset($_POST['cancelMdp'])) {
        header('Location: Catalogue');
    }
} else {
    echo "Vous n'avez pas accès à cette page";
    header('Location: DashBoard.php');
}
