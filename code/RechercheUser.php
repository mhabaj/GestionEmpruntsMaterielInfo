<?php
require_once("Controller/control-session.php");

require "Controller/DataBase.php";

?>
<html>
<body>
<form method="POST" enctype="multipart/form-data">
    <h1>Recherche utilisateur</h1>
    <label>Rechercher utilisateur:</label>
    <input type="search" placeholder="Inserer le matricule de l'utilisateur" name="UserToSearch">
    <button type="submit" name="startSearching">Rechercher</button>
</form>
<?php

if (isset($_POST['startSearching'])) {
    $bdd = new DataBase();
    $con = $bdd->getCon();
    $UserToSearch = $_POST['UserToSearch'];

    $queryEquipments = "SELECT * FROM users WHERE matricule_user LIKE ?;";
    $myStatement = $con->prepare($queryEquipments);
    $myStatement->execute(["%".$UserToSearch."%"]);

    while ($donnees = $myStatement->fetch()) { ?>
        <a href="https://youtu.be/rrNTRqf-Nqs">
            <div>
                <strong> Firstname </strong> : <?php echo $donnees['name_user']; ?> <br/>
                <strong> Lastname </strong> : <?php echo $donnees['lastname_user']; ?> <br/>
                <strong> email </strong> : <?php echo $donnees['email_user']; ?> <br/> <br/>
            </div>
        </a>
        <?php
    }
    $myStatement->closeCursor();

}
?>

</body>
</html>