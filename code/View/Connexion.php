<html>

<?php

include("../Model/User.php");


?>
<body>

<form method="POST" enctype="multipart/form-data">
    <h1>Connexion</h1>

    <label><b>Nom d'utilisateur</b></label>
    <input type="text" placeholder="Entrer le nom d'utilisateur" name="username" required>

    <label><b>Mot de passe</b></label>
    <input type="password" placeholder="Entrer le mot de passe" name="password" required>


    <button type="submit" name="submitCo" class="btn btn-primary">Connexion</button>


</form>

<?php
if(isset($_POST['submitCo'])){
    echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
}
?>


</body>

</html>