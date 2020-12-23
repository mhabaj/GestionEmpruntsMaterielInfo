<?php

require_once("Controller/control-session.php");
require_once("Controller/DataBase.php");
require_once("Model/User.php");
require_once("Model/UserRegular.php");
require_once("Model/UserAdmin.php");

if ((!isset($_SESSION['id_user'])) || ($_SESSION['id_user'] == ''))
{
    if (isset($_GET['id_user_toDisplay'])) {
        echo "alut";
    } else {
        echo "mais t ou t pas la ?";
    }
}
?>



<html lang="fr">
    <body>
        <form method="POST" enctype="multipart/form-data">
            <h1>Modifier un utilisateur</h1>
            <p>Veuillez remplir les champs ci-dessous pour modifier un utilisateur</p>
            <hr>

            <label><b>Nom d'utilisateur</b></label>
            <input type="text" placeholder="<?php ?>" name="matricule" required>
            <br><br>
            <label><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrer le mot de passe" name="password" required>

            <label><b>Email</b></label>
            <input type="email" placeholder="Entrez l'adresse mail de l'utilisateur" name="email" required>
            <br><br>
            <label><b>Nom de famille</b></label>
            <input type="text" placeholder="Entrez le nom de famille" name="lastname" required>

            <label><b>Prénom</b></label>
            <input type="text" placeholder="Entrez le prénom" name="name" required>
            <br><br>
            <label><b>Numéro de téléphone</b></label>
            <input type="tel" pattern="[0-9]{10}" placeholder="Entrez le numéro de téléphone" name="phone" required>
            <br><br>
            <label><b>Modifer les droits de l'utilisateur</b></label>
            <label>
                <input type="checkbox" checked="checked" name="administrateur"  value ="ok" style="margin-bottom:15px">Administrateur
            </label>

            <hr>
            <button type="button" name="cancelbtn">Annuler les modifications</button>
            <button type="submit" name="submitInscription">Confirmer les modifications </button>

        </form>
    </body>
</html>