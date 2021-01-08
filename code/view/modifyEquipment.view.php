<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
    <label>Modifier cette équipement: </label>
    <br>
    <p>Reference d'équipement: </p>

    <input type="text" placeholder="Reference de l'équipement" name="ref_equip" required
           value="<?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) echo $currentEquipment->getRefEquip(); ?>">
    <p>Type d'équipement: </p>
    <input type="text" placeholder="Type de l'équipement" name="type_equip" required
           value="<?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) echo $currentEquipment->getTypeEquip(); ?>">
    <p> Nom du materiel: </p>
    <input type="text" placeholder="Nom de l'équipement" name="nom_equip" required
           value="<?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) echo $currentEquipment->getNameEquip() ?>">
    <p>Marque: </p>
    <input type="text" placeholder="Marque de l'équipement" name="marque_equip" required
           value="<?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) echo $currentEquipment->getBrandEquip(); ?>">
    <p> Version du materiel: </p>
    <input type="text" placeholder="Version de l'équipement" name="version_equip" required
           value="<?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) echo $currentEquipment->getVersionEquip(); ?>">
    <p> Quantité totale du materiel <b>(Disponible à modifier/ Occupé / Total présent:
            <mark><?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) echo $equipmentController->getEquipmentDAO()->howMuchAvailable($currentEquipment->getRefEquip()) . "/" . ($equipmentController->getEquipmentDAO()->howMuchAvailable($currentEquipment->getRefEquip()) - $equipmentController->getEquipmentDAO()->howMuchTotal($currentEquipment->getRefEquip())) * -1 . "/" . $equipmentController->getEquipmentDAO()->howMuchTotal($currentEquipment->getRefEquip()); ?></mark>
            ): </b></p>
    <input type="number" placeholder="Quantite de l'équipement" name="quantite_equip" required
           min="<?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) echo($equipmentController->getEquipmentDAO()->howMuchTotal($currentEquipment->getRefEquip()) - $equipmentController->getEquipmentDAO()->howMuchAvailable($currentEquipment->getRefEquip())); ?>"
           value="<?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) echo $equipmentController->getEquipmentDAO()->howMuchTotal($currentEquipment->getRefEquip()); ?>">
    <br>
    <p><label><b>Images: </label></p>

    <?php
    if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) {
        $arrayPhotos = $currentEquipment->getPhotoArray();
        foreach ($arrayPhotos as $photoURL) {
            ?>
            <img src="<?php echo $photoURL ?>" alt="Photo Device" width="200" height="150">
            <?php
        }
    }
    ?>

    <input type="image" max="1024" value="" name="photo">
    <input type="hidden" name="MAX_FILE_SIZE" value="8388608">
    <p><label for="photo"> Photo (JPG, JPEG, PNG or GIF | max.8 Mo) :</label><br/></p>
    <input type="file" id="photo" name="photo"/><br/>


    <p><input class="btn btn-success" type="submit" value="Modifier l'equipement" placeholder="Modifier l'équipement"
              name="modifierEquipment"></p>
</form>
<?php if (isset($erreur) && !$erreur == "") echo "<p>" . $erreur . "</p>"; ?>
<?php
require_once("footer.view.php");
?>