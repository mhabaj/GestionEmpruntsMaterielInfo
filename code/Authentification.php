<?php
$title = "Page d'authentification";
require_once("Controller/UserController.php");
$erreur = "";
ob_start();

if (!isset($_SESSION['id_user']) || ($_SESSION['id_user'] != '')) {


    if (isset($_POST['submitLogin'])) {

        $matricule = $_POST['matricule'];
        $password = $_POST['password'];

        try {
            if (Functions::checkMatricule($matricule)) {
                $tmpUserCtrl = new UserController();
                if (!$tmpUserCtrl->getUserDAO()->connect($matricule, $password)) {
                    $erreur = "<p>Identifiant ou mot de passe incorrects.</p>";
                } else {
                    ob_end_clean();
                    header('Location: DashBoard.php');
                }

            }
        } catch (Exception $e) {

            $erreur = "<p>" . $e->getMessage() . "</p>";

        }
    }


    //INCLUDE VIEW ICI:
    require_once("view/authentification.view.php");

} else {
    //ob_end_clean();
    header('Location: DashBoard.php');
}

