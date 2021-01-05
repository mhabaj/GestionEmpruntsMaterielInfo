<?php

require_once("Controller/control-session.php");
require_once("Model/User.php");
require_once("ControllerDAO/UserDAO.php");
require_once("Controller/UserController.php");


if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1 && isset($_GET['id_user_toDisplay']) || isset($_GET['id_user_toDisplay']) && $_GET['id_user_toDisplay'] == $_SESSION['id_user'] )
{
    if(!UserDAO::userExists($_GET['id_user_toDisplay']))
        header('Location: DashBoard.php');

    $userController = new UserController($_GET['id_user_toDisplay']);

    $currentUser = $userController->getUser();

    if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null)
    {
        ?>
        <?php
        // on include view ici
        require_once("view/detailUser.view.php")
        ?>

        <?php
        if(isset($_POST['endBorrow']) && $_SESSION['isAdmin_user'] == 1 && isset($_POST['idBorrow']) && is_numeric($_POST['idBorrow']))
        {
            $userController->endBorrow($_SESSION['id_user'],$_POST['idBorrow']);
            header("Refresh:0");
        }
    }
    else
    {
        header('Location: DashBoard.php');
    }
}
else
{
    header('Location: DashBoard.php');
}