<?php
require_once("Controller/control-session.php");

require "Controller/DataBase.php";

?>
<html>
<body>
<form method="POST" enctype="multipart/form-data">
    <h1>Catalogue</h1>
    <label>Rechercher équipement:</label>
    <input type="search" placeholder="Inserer l'équipement" name="EquipmentToSearch">
    <input type="radio" name="radio_recherche" id="radio_name" value="radio_name" checked>
    <label for="radio_name">par nom</label>
    <input type="radio" name="radio_recherche" id="radio_ref" value="radio_ref">
    <label for="radio_ref">par référence</label>
    <button type="submit" name="startSearching">Rechercher</button>
</form>

<?php

if (isset($_POST['startSearching']) && $_POST['EquipmentToSearch']!=null && $_POST['EquipmentToSearch']!=" ") {
    $bdd = new DataBase();
    $con = $bdd->getCon();
    $EquipToSearch = trim($_POST['EquipmentToSearch']);

    if($_POST['radio_recherche'] == "radio_name")
        $queryEquipments = "SELECT * FROM equipment WHERE name_equip LIKE ?;";
    elseif ($_POST['radio_recherche'] == "radio_ref")
        $queryEquipments = "SELECT * FROM equipment WHERE ref_equip LIKE ?;";

    $myStatement = $con->prepare($queryEquipments);
    $myStatement->execute([$EquipToSearch."%"]);

    if($myStatement->rowCount() > 0)
    {
        while ($donnees = $myStatement->fetch()) { ?>
            <a href="DetailEquipement.php?ref_equip=<?php echo $donnees['ref_equip'] ?>">
                <div>
                    <strong> Type </strong> : <?php echo $donnees['type_equip']; ?> <br/>
                    <strong> Matériel </strong> : <?php echo $donnees['brand_equip'] . " " . $donnees['name_equip']; ?> <br/>
                    <strong> Version </strong> : <?php echo $donnees['version_equip']; ?> <br/> <br/>
                </div>
            </a>
            <?php
        }
        $myStatement->closeCursor();
    }
    else{
        ?>
        <label>Aucun document ne correspond aux termes de recherche spécifiés.</label>
        <?php
    }
    $myStatement->closeCursor();
}

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

</body>
</html>