<?php

require_once("Controller/control-session.php");
require_once("Controller/DataBase.php");
require_once("Model/User.php");
require_once("Model/UserRegular.php");
require_once("Model/UserAdmin.php");
require_once("Controller/InscriptionController.php");

/* catch les erreurs */
if(isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1)
{

    //on include inscriptions.view
    require_once('view/inscripition.view.php');
    ?>

    <?php
    /* si l'admin décide d'annuler sa création d'utilisateur */
    if(isset($_POST['cancelbtn']))
    {
        header('Location: Catalogue');
    }

    /* si l'admin décide de créer un utilisateur*/
    if(isset($_POST['submitInscription']))
    {
        try
        {
            $myInscriptionController = new InscriptionController();
            $myInscriptionController->initInscriptionController();

            if(isset($_POST['administrateur']) && isset($_POST['matricule']) && isset($_POST['password']) && isset($_POST['passwordrepeat']) && isset($_POST['name']) && isset($_POST['lastname'])
                && isset($_POST['phone']) && isset($_POST['administrateur']))
            {
                if($myInscriptionController->createUserController($_POST['matricule'],$_POST['password'],$_POST['passwordrepeat'],$_POST['email'],$_POST['name'],$_POST['lastname'],$_POST['phone'],$_POST['administrateur']) == true)
                {
                    echo "L'utilisateur a correctement été créé";
                    header( "refresh:3;url=Inscription.php");
                }
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            header( "refresh:3;url=Inscription.php");
        }

    }

}
else
{
    echo "Vous n'avez pas accès à cette page, vous allez être redirigé";
    header( "refresh:2;url=Catalogue.php");
}
?>