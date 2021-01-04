<?php

require_once("Controller/control-session.php");
require_once("Controller/DataBase.php");
require_once("Model/User.php");
require_once("Model/UserRegular.php");
require_once("Model/UserAdmin.php");
require_once("Controller/UserController.php");


if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1 && isset($_GET['id_user_toDisplay']) || isset($_GET['id_user_toDisplay']) && $_GET['id_user_toDisplay'] == $_SESSION['id_user'] )
{
    $userController = new UserController();

    try
    {
        $userController->initUserController($_GET['id_user_toDisplay']);
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
        echo $_GET['id_user_toDisplay'];

        //header('Location: Catalogue.php');
    }

    $currentUser = $userController->getUser();

    if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null)
    {
    ?>
        <?php
            // on include view ici
            require_once("view/detailUser.view.php")
        ?>

        <?php
        if(isset($_POST['endBorrow']) && $_SESSION['isAdmin_user'] == 1 && isset($_POST['idBorrow']) && is_numeric($_POST['idBorrow']) && isset($_POST['idDevice']))
        {
            $userController->returnBorrow($_SESSION['id_user'],$_POST['idBorrow'],$_POST['idDevice']);
            header("Refresh:0");
        }
    }
    else
    {
        header('Location: Catalogue.php');
    }
}
else
{
    echo "Vous n'avez pas accès à cette page";
    header("refresh:3;url=Catalogue.php");
    echo "<p> Redirection dans 3 secondes.. </p>";
}
