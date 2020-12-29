<?php
require_once("Controller/control-session.php");

require "Controller/DataBase.php";

if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1)
{
    ?>
    <html>
        <body>
            <form method="POST" enctype="multipart/form-data">
        <h1>Recherche utilisateur</h1>
        <label>Rechercher utilisateur:</label>
        <input type="search" placeholder="Matricule de l'utilisateur" name="UserToSearch">
        <button type="submit" name="startSearching">Rechercher</button>
            </form>
    <?php

    if (isset($_POST['startSearching']) && $_POST['UserToSearch']!=null && $_POST['UserToSearch']!=" ")
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $UserToSearch = trim($_POST['UserToSearch']);

        $queryEquipments = "SELECT * FROM users WHERE matricule_user LIKE ?;";
        $myStatement = $con->prepare($queryEquipments);
        $myStatement->execute([$UserToSearch."%"]);

        if($myStatement->rowCount() > 0)
        {
            while ($donnees = $myStatement->fetch()) { ?>
                <a href="DetailUser.php?id_user_toDisplay=<?php echo $donnees['id_user'] ?>">
                    <div>
                        <strong> Matricule </strong> : <?php echo $donnees['matricule_user']; ?> <br/>
                        <strong> Firstname </strong> : <?php echo $donnees['name_user']; ?> <br/>
                        <strong> Lastname </strong> : <?php echo $donnees['lastname_user']; ?> <br/>
                        <strong> email </strong> : <?php echo $donnees['email_user']; ?> <br/> <br/>
                    </div>
                </a>
                <?php
            }
        }
        else{
            ?>
            <label>Aucun document ne correspond aux termes de recherche spécifiés.</label>
            <?php
        }
        $myStatement->closeCursor();
    }
    else
    {
        ?>
        <label>Veuillez remplir le champ de recherche avant d'appuyer sur le bouton.</label>
        <?php
    }
}
else
{
    header("refresh:3;url=Catalogue.php");
    echo "Vous n'avez pas accès à cette page";
    echo "<p> Redirection dans 3 secondes.. </p>";
}
?>

    </body>
</html>