<?php
require_once("Controller/control-session.php");

require "Controller/DataBase.php";

if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1  && isset($_GET['id_user_toDisplay']) || $_GET['id_user_toDisplay'] == $_SESSION['id_user'] && isset($_GET['id_user_toDisplay'])) {
    $bdd = new DataBase();
    $con = $bdd->getCon();

    $queryUser="SELECT * FROM borrow_info INNER JOIN borrow ON borrow_info.id_borrow=borrow.id_borrow WHERE borrow.id_user=? AND borrow_info.isActive=0";
    $myStatement = $con->prepare($queryUser);
    $myStatement->execute([$_GET['id_user_toDisplay']]);

    if($myStatement->rowCount() > 0)
    {
        while ($donnees = $myStatement->fetch()) { ?>
                <div>
                    <strong> Emprunt numéro </strong> : <?php echo $donnees['id_borrow']; ?> <br/>
                    <strong> Id du matériel physique emprunté </strong> : <?php echo $donnees['id_device']; ?> <br/>
                    <strong> Date début emprunt </strong> : <?php echo $donnees['startdate_borrow']; ?> <br/>
                    <strong> Date fin emprunt </strong> : <?php echo $donnees['enddate_borrow']; ?> <br/>
                    <br/>
                </div>
            </a>
            <?php
        }
    }
    else{
        ?>
        <label>L'utilisateur n'a emprunté aucun objet jusqu'à présent.</label>
        <?php
    }
    $myStatement->closeCursor();
}
else{
    ?>
    <label>Erreur veuillez contacter le support</label>
    <?php
}
?>

</body>
</html>