<?php

require_once("Controller/control-session.php");
require_once "Controller/DataBase.php";
require_once "Model/Equipment.php";
require_once "Model/UserRegular.php";
require_once "Model/UserAdmin.php";
require_once "Controller/Functions.php";
require_once "Controller/EquipmentController.php";
require_once "Controller/CatalogueController.php";

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
if (isset($_POST['startSearching']) && $_POST['EquipmentToSearch'] != null && $_POST['EquipmentToSearch'] != " ") {
    $bdd = new DataBase();
    $con = $bdd->getCon();
    $EquipToSearch = trim($_POST['EquipmentToSearch']);

    if ($_POST['radio_recherche'] == "radio_name")
        $queryEquipments = "SELECT * FROM equipment WHERE name_equip LIKE ?;";
    elseif ($_POST['radio_recherche'] == "radio_ref")
        $queryEquipments = "SELECT * FROM equipment WHERE ref_equip LIKE ?;";

    $myStatement = $con->prepare($queryEquipments);
    $myStatement->execute([$EquipToSearch . "%"]);

    if ($myStatement->rowCount() > 0) {
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
        ?>
        <label>Aucun document ne correspond aux termes de recherche spécifiés.</label>
        <?php
    }
    $myStatement->closeCursor();
}

$myCatalogueController = new CatalogueController();
$myCatalogueController->getEquipmentList();
?>


<?php
if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {
    $currentUser = new UserAdmin();
    $currentUser->loadUser();
    if ($currentUser->getPrivilege() == 1) {
        ?>
        <h3>Espace Adminisatateur :</h3>
        <form method="POST" enctype="multipart/form-data">
            <button type="submit" name="addEquip">Ajouter un nouvel Equipement</button>
        </form>
        <form method="POST" enctype="multipart/form-data">
            <label>Rechercher utilisateur:</label>
            <input type="search" placeholder="Matricule de l'utilisateur" name="UserToSearch">
            <button type="submit" name="startSearchingUser">Rechercher</button>
        </form>
        <?php
        if (isset($_POST['addEquip'])) {
            header("Location: creationEquipement.php");
        }
    }

    if (isset($_POST['startSearchingUser']) && $_POST['UserToSearch']!=null && $_POST['UserToSearch']!=" ") {
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
    else{
        ?>
        <label>Veuillez remplir le champ de recherche avant d'appuyer sur le bouton.</label>
        <?php
    }
}

?>

</body>
</html>


</body>
</html>