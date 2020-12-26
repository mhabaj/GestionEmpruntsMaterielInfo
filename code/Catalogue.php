<?php

require_once("Controller/control-session.php");
require_once "Controller/DataBase.php";
require_once "Model/Equipment.php";
require_once "Model/UserRegular.php";
require_once "Model/UserAdmin.php";
require_once "Controller/Functions.php";
require_once "Controller/EquipmentController.php";

class CatalogueController{

}


?>

<html>
<body>
<form method="POST" enctype="multipart/form-data">
    <h1>Catalogue</h1>
    <label>Rechercher équipement:</label>
    <input type="search" placeholder="Inserer l'équipement" name="EquipmentToSearch">
    <button type="submit" name="startSearching">Rechercher</button>
</form>

<?php

if (isset($_GET['type'])) {
    $bdd = new DataBase();
    $con = $bdd->getCon();

    $queryEquipments = "SELECT * FROM equipment WHERE type_equip LIKE ?;";
    $myStatement = $con->prepare($queryEquipments);
    $myStatement->execute([$_GET['type']]);

    while ($donnees = $myStatement->fetch()) { ?>
        <a href="DetailEquipement.php?ref_equip=<?php echo $donnees['ref_equip'] ?>">
            <div>
                <strong> Type </strong> : <?php echo $donnees['type_equip']; ?> <br/>
                <strong> Matériel </strong> : <?php echo $donnees['brand_equip'] . " " . $donnees['name_equip']; ?>
                <br/>
                <strong> Version </strong> : <?php echo $donnees['version_equip']; ?> <br/> <br/>
            </div>
        </a>
        <?php
    }
    $myStatement->closeCursor();
} else {
    $bdd = new DataBase();
    $con = $bdd->getCon();

    $queryEquipments = "SELECT DISTINCT(type_equip) FROM equipment ;";
    $myStatement = $con->query($queryEquipments);

    while ($donnees = $myStatement->fetch()) { ?>
        <a href="Catalogue.php?type=<?php echo $donnees['type_equip'] ?>">
            <div>
                <strong> Type </strong> : <?php echo $donnees['type_equip']; ?> <br/>
            </div>
        </a>
        <?php
    }
    $myStatement->closeCursor();

}
?>

<?php
if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {
    $currentUser = new UserAdmin();
    $currentUser->loadUser();
    if ($currentUser->getPrivilege() == 1) {
        ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Espace Admin: </label>
            <button type="submit" name="addEquip">Ajouter un nouvel Equipement</button>
        </form>

        <?php
        if (isset($_POST['addEquip'])) {
            header("Location: creationEquipement.php");
        }


    }
}

?>
</body>
</html>