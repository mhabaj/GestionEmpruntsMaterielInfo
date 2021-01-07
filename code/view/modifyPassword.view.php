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
    <label><b>Veuillez entrer un nouveau mot de passe</b></label>
    <input type="password" placeholder="Veuillez entrer un mot de passe" name="password" required >
    <br><br>
    <label><b>Retapez le mot de passe</b></label>
    <input type="password" placeholder="Répéter le mot de passe" name="passwordrepeat" required>
    <br><br>

    <button class="btn btn-success" type="submit" name="submitModificationMdp">Confirmer les modifications </button>
</form>

<?php
require_once("footer.view.php");
?>