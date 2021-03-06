<?php
$title = "Modifier l'utilisateur";
$erreur = "";
require_once("Controller/control-session.php");
require_once("Model/User.php");
require_once("Controller/UserController.php");
require_once("ControllerDAO/UserDAO.php");
ob_start();

if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1 && isset($_GET['id_user_toDisplay']) || $_GET['id_user_toDisplay'] == $_SESSION['id_user'] && isset($_GET['id_user_toDisplay'])) {
    $tmpUsrCtrl = new UserController();


    if (!$tmpUsrCtrl->getUserDAO()->userExists($_GET['id_user_toDisplay']))

        header('Location: DashBoard.php');

    $userController = new UserController($_GET['id_user_toDisplay']);

    $currentUser = $userController->getUser();


    /* Traitement de la page modifier utilisateur */
    if (isset($_POST['submitModification'])) {
        $postAdmin = 0;
        if (isset($_POST['administrateur']) && $_POST['administrateur'] != null) {
            $postAdmin = 1;
        }
        try {


            if ($userController->modifyUser($_GET['id_user_toDisplay'], $_POST['matricule'], $_POST['email'], $_POST['lastname'], $_POST['name'], $_POST['phone'], $postAdmin) == true) {

                if ($_SESSION['isAdmin_user'] == 1 && $postAdmin == 0 && $currentUser->getIdUser() == $_SESSION["id_user"]) {
                    ob_end_clean();

                    $userController->disconnect();
                }

                ob_end_clean();
                header('Location: DetailUser.php?id_user_toDisplay=' . $currentUser->getIdUser());
            }
        } catch (Exception $e) {
            ob_end_clean();

            $url = 'DetailUser.php?id_user_toDisplay=' . $currentUser->getIdUser();
            header("refresh:3;url=$url");
             echo "<p>" . $e->getMessage() . " Vous serez redirigé vers la page de compte dans 3 secondes.</p>";
        }
    }


    /* Traitement de la page modifier password  */
    if (isset($_POST['submitModificationMdp'])) {
        if (isset($_POST['password']) && isset($_POST['passwordrepeat'])) {
            try {
                if ($userController->modifyPassword($_POST['password'], $_POST['passwordrepeat']) == false) {
                    $url = 'DetailUser.php?id_user_toDisplay=' . $currentUser->getIdUser();
                    header("refresh:2;url=$url");

                    echo "<p> Les deux mots de passe ne correspondent pas <p/>";
                    echo "<p> Vous allez etre rediriges dans 2 secondes.. <p/>";

                } else {
                    header('Location: DetailUser.php?id_user_toDisplay=' . $currentUser->getIdUser());
                }
            } catch (Exception $e) {
                $erreur = "<p>" . $e->getMessage() . "</p>";
            }
        }

    }
    /* si l'utilisateur a cliqué sur modifier utilisateur */
    if (isset($_POST['modifyUser']) && isset($_GET['id_user_toDisplay']) && (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null)) {

        //include modifyUser.view
        require_once('view/modifyUser.view.php');

    }


    /* si l'utilisateur a cliqué sur modifier password */
    if (isset($_GET['id_user_toDisplay']) && isset($_POST['modifyPassword']) && (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null)) {

        //include modifyPassword.view
        require_once('view/modifyPassword.view.php');

    }

} else {
    header('Location: DashBoard.php');
}
