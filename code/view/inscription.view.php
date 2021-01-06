<?php
require_once("head.view.php");
require_once("navbar.view.php");
?>
    <!-- Intro -->
    <div class="container">
        <div class="maincontent">
            <br> <br>
            <h2 class="thin"></h2>
            <p class="text-muted">

            </p>
            <!-- /Intro-->
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
    <button class="btn btn-success" type="submit" name="submitInscription">Confirmer l'inscription</button>
</form>
<br>
<form method="Post">
    <button class="btn btn-danger" type="submit"  name="cancelbtn">Annuler l'inscription </button>
</form>

<?php
require_once("footer.view.php");
?>