<?php

require_once("Controller/control-session.php");
require_once("Controller/DataBase.php");
require_once("Model/User.php");
require_once("Model/UserRegular.php");
require_once("Model/UserAdmin.php");

/* catch les erreurs */
if(isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1)
{
    $currentUser = new UserAdmin();
    $currentUser->loadUser();
    if(isset($_POST['submitInscription'])){

        $matricule = $_POST['matricule'];
        $password = $_POST['password'];
        $passwordrepeat = $_POST['passwordrepeat'];
        $email = $_POST['email'];
        $lastname = $_POST['lastname'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $isAdmin =0;
        if(isset($_POST['administrateur']))
        {
            $isAdmin = $_POST['administrateur'];
            if ($isAdmin == 'ok')
            {
                $isAdmin = 1;
            }
        }

        if(strlen($matricule) == 7 && ($password == $passwordrepeat))
        {
            try
            {
                $currentUser->createUser($matricule,$email,$password,$name,$lastname,$phone,$isAdmin);
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
            }
        }
        else
            {
            echo "<p> Erreur, le matricule doit comporter 7 caracteres et/ou les mots de passe entrés ne correspondent pas <p/>";
        }
    }
    if(isset($_POST['cancelbtn'])){
        header('Location: Catalogue');
    }

    ?>

    <html lang="fr">

    <body>

    <form method="POST" enctype="multipart/form-data">
        <h1>Inscrire un utilisateur</h1>
        <p>Veuillez remplir les champs ci-dessous pour inscrire un utilisateur</p>
        <hr>

        <label><b>Nom d'utilisateur</b></label>
        <input type="text" placeholder="Entrer le nom d'utilisateur" name="matricule" required>
        <br><br>
        <label><b>Mot de passe</b></label>
        <input type="password" placeholder="Entrer le mot de passe" name="password" required>

        <label><b>Retapez le mot de passe</b></label>
        <input type="password" placeholder="Répéter le mot de passe" name="passwordrepeat" required>
        <br><br>
        <label><b>Email</b></label>
        <input type="email" placeholder="Entrez l'adresse mail de l'utilisateur" name="email" required>
        <br><br>
        <label><b>nom de famille</b></label>
        <input type="text" placeholder="Entrez le nom de famille" name="lastname" required>

        <label><b>prénom</b></label>
        <input type="text" placeholder="Entrez le prénom" name="name" required>
        <br><br>
        <label><b>numéro de téléphone</b></label>
        <input type="tel" pattern="[0-9]{10}" placeholder="Entrez le numéro de téléphone" name="phone" required>
        <br><br>
        <label><b>Confirmez si l'utilisateur sera un administrateur</b></label>
        <label>
            <input type="checkbox" checked="checked" name="administrateur"  value ="ok" style="margin-bottom:15px">Administrateur
        </label>

        <hr>
        <button type="button" name="cancelbtn">Annuler l'inscription</button>
        <button type="submit" name="submitInscription">Confirmer l'inscription</button>

    </form>

    </body>

    </html>

    <?php
}
?>