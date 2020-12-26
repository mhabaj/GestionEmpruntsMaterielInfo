<html>
<body>
<form method="POST" enctype="multipart/form-data">
    <label>Modifier cette équipement: </label>
    <br>
    <p>Reference d'équipement: </p>

    <input type="text" placeholder="Reference de l'équipement" name="ref_equip"
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->getRefEquip(); ?>">
    <p>Type d'équipement: </p>
    <input type="text" placeholder="Type de l'équipement" name="type_equip"
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->getTypeEquip(); ?>">
    <p> Nom du materiel: </p>
    <input type="text" placeholder="Nom de l'équipement" name="nom_equip"
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->getNameEquip() ?>">
    <p>Marque: </p>
    <input type="text" placeholder="Marque de l'équipement" name="marque_equip"
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->getBrandEquip(); ?>">
    <p> Version du materiel: </p>
    <input type="text" placeholder="Version de l'équipement" name="version_equip"
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->getVersionEquip(); ?>">
    <p> Quantité totale du materiel <b>(Disponible à modifier/ Occupé / Total présent: <mark><?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->howMuchAvailable() . "/". ($currentEquipement->howMuchAvailable() - $currentEquipement->howMuchTotal())*-1 ."/". $currentEquipement->howMuchTotal(); ?></mark>): </b> </p>
    <input type="number" placeholder="Quantite de l'équipement" name="quantite_equip"
           min="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo($currentEquipement->howMuchTotal() - $currentEquipement->howMuchAvailable()); ?>"
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->howMuchTotal(); ?>">

    <input type="submit" value="Modifier Valeur" placeholder="Modifier l'équipement"
           name="modifierEquipment">
</form>