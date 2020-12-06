<?php

require("Controller/DataBase.php");
require("Model/UserAdmin.php");


//require("Model/UserAdmin.php");


if(isset($_POST['submitLogin'])){

    if(!isset($_SESSION['id_user'])) {
        $matricule = $_POST['matricule'];
        $password = $_POST['password'];

        if(strlen($matricule) > 7){

        }

    }
}

?>
<html>


    <body>

        <form method="POST" enctype="multipart/form-data">
            <h1>Connexion</h1>

            <label><b>Nom d'utilisateur</b></label>
            <input type="text" placeholder="Entrer le nom d'utilisateur" name="matricule" required>

            <label><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrer le mot de passe" name="password" required>


            <button type="submit" name="submitLogin">Connexion</button>


        </form>


    </body>

</html>


