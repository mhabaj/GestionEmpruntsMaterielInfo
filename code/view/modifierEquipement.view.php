<html>
<body>
<form method="POST" enctype="multipart/form-data">
    <label>Modifier cette équipement: </label>
    <br>
    <p>Reference d'équipement: </p>

    <input type="text" placeholder="Reference de l'équipement" name="ref_equip" required
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->getRefEquip(); ?>">
    <p>Type d'équipement: </p>
    <input type="text" placeholder="Type de l'équipement" name="type_equip" required
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->getTypeEquip(); ?>">
    <p> Nom du materiel: </p>
    <input type="text" placeholder="Nom de l'équipement" name="nom_equip" required
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->getNameEquip() ?>">
    <p>Marque: </p>
    <input type="text" placeholder="Marque de l'équipement" name="marque_equip" required
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->getBrandEquip(); ?>">
    <p> Version du materiel: </p>
    <input type="text" placeholder="Version de l'équipement" name="version_equip" required
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->getVersionEquip(); ?>">
    <p> Quantité totale du materiel <b>(Disponible à modifier/ Occupé / Total présent:
            <mark><?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->howMuchAvailable() . "/" . ($currentEquipement->howMuchAvailable() - $currentEquipement->howMuchTotal()) * -1 . "/" . $currentEquipement->howMuchTotal(); ?></mark>
            ): </b></p>
    <input type="number" placeholder="Quantite de l'équipement" name="quantite_equip" required
           min="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo($currentEquipement->howMuchTotal() - $currentEquipement->howMuchAvailable()); ?>"
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->howMuchTotal(); ?>">
    <br>
    <p><label><b>Images: </label></p>

    <?php
    if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) {
        $arrayPhotos = $currentEquipement->getPhotoArray();
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


   <p> <input type="submit" value="Modifier l'equipement" placeholder="Modifier l'équipement"
              name="modifierEquipment"> </p>
</form>