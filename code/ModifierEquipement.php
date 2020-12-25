<?php

require_once("Controller/control-session.php");
require_once "Controller/DataBase.php";
require_once "Model/Equipment.php";
require_once "Model/UserRegular.php";
require_once "Model/UserAdmin.php";
require_once "Controller/Functions.php";


if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {
    $currentUser = new UserAdmin();
    $currentUser->loadUser();
    if (isset($_GET['ref_equip']) && $_GET['ref_equip'] != null) {

        $bdd = new DataBase();
        $con = $bdd->getCon();

        $queryEquipments = "SELECT * FROM equipment WHERE equipment.ref_equip LIKE ?;";
        $myStatement = $con->prepare($queryEquipments);
        $myStatement->execute([$_GET['ref_equip']]);

        $donnees = $myStatement->fetch();
        if ($donnees['ref_equip'] != null) {

            $bdd = new DataBase();
            $con = $bdd->getCon();

            $queryEquipments = "SELECT * FROM equipment WHERE equipment.ref_equip LIKE ?;";
            $myStatement = $con->prepare($queryEquipments);
            $myStatement->execute([$_GET['ref_equip']]);

            $donnees = $myStatement->fetch();
            if ($donnees['ref_equip'] != null) {
                $currentEquipement = new Equipment($donnees['ref_equip'], $donnees['type_equip'], $donnees['name_equip'], $donnees['brand_equip'], $donnees['version_equip']);
                ?>
                <html>
            <body>
            <form method="POST" enctype="multipart/form-data">
                <label>Modifier cette équipement (Disponible: <?php echo $currentEquipement->howMuchAvailable() ?>
                    )</label>
                <br>
                <input type="text" placeholder="Reference de l'équipement" name="ref_equip"
                       value="<?php echo $currentEquipement->getRefEquip(); ?>">
                <input type="text" placeholder="Type de l'équipement" name="type_equip"
                       value="<?php echo $currentEquipement->getTypeEquip(); ?>">
                <input type="text" placeholder="Nom de l'équipement" name="nom_equip"
                       value="<?php echo $currentEquipement->getNameEquip() ?>">
                <input type="text" placeholder="Marque de l'équipement" name="marque_equip"
                       value="<?php echo $currentEquipement->getBrandEquip(); ?>">
                <input type="text" placeholder="Version de l'équipement" name="version_equip"
                       value="<?php echo $currentEquipement->getVersionEquip(); ?>">
                <input type="number" placeholder="Quantite de l'équipement" name="quantite_equip" min="0"
                       value="<?php echo $currentEquipement->howMuchAvailable(); ?>">

                <input type="submit" value="Modifier Valeur" placeholder="Modifier l'équipement"
                       name="modifierEquipment">
            </form>
                <?php

                if (isset($_POST['modifierEquipment'])) {

                    $ref_equip = $_POST['ref_equip'];
                    $type_equip = $_POST['type_equip'];
                    $nom_equip = $_POST['nom_equip'];
                    $marque_equip = $_POST['marque_equip'];
                    $version_equip = $_POST['version_equip'];
                    $quantite_equip = $_POST['quantite_equip'];
                    try {
                        if (Functions::checkRefEquip($ref_equip) && Functions::checkNameMateriel($nom_equip)
                            && Functions::checkBrandEquip($marque_equip) && Functions::checkTypeEquip($type_equip)
                            && Functions::checkVersionMateriel($version_equip) && $quantite_equip != null && is_numeric($quantite_equip) && $quantite_equip >= 0) {
                            if ($currentEquipement->howMuchAvailable() != $quantite_equip) {
                                $currentUser->updateDeviceCount($currentEquipement->getRefEquip(), $quantite_equip);
                            }
                            $currentUser->modifyEquipment($currentEquipement->getRefEquip(), $ref_equip, $type_equip, $marque_equip, $nom_equip, $version_equip);

                            header("Location: DetailEquipement.php?ref_equip=" . $ref_equip);


                        } else {
                            echo " Incorrect Input\n ";
                        }
                    } catch (Exception | PDOException $e) {
                        echo "Exception : " . $e->getMessage();
                    }

                }
            }
        } else {
            header('Location: Catalogue.php');
        }

    }
}
