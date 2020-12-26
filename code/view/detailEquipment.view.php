<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<html>
<body>
<div>
    <p> Reference d'équipement:
        : <?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->getRefEquip() ?> </p>
    <br/>
    <p> Type d'équipement
        : <?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->getTypeEquip() ?> </p>
    <br/>
    <p> Matériel
        : <?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->getBrandEquip() . " " . $currentEquipement->getNameEquip(); ?> </p>
    <br/>
    <p> Version
        : <?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->getVersionEquip() ?> </p>
    <br/>
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

    <form method="POST" enctype="multipart/form-data">
        <label> <b>Reserver cette équipement
                (Dispo/Total: <?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->howMuchAvailable() . "/" . $currentEquipement->howMuchTotal(); ?>
                ): </b></label>
        <br>
        <p>Date fin de reservation: </p>

        <input type="date" placeholder="Date fin de reservation" name="dateRes">
        <br>
        <p>Quantité souhaité: </p>
        <input type="number" placeholder="Quantité souhaité" name="quantiteNumber" min="0"
               max="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipement) && $currentEquipement != null) echo $currentEquipement->howMuchAvailable() ?>">
        <input type="submit" value="Reserver l'équipement" placeholder="Reserver l'équipement"
               name="reserveEquipment">
    </form>
    <?php

    if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) { ?>
    <label> <b> ESPACE ADMINISTRATEUR: </b> </label>
    <form method="POST" enctype="multipart/form-data">
        <input type="submit" value="Modifier cet équipement" placeholder="Modifier cet équipement"
               name="modifierEquipement">
    </form>

</div>

</body>
</html>
<?php
if (isset($_POST["modifierEquipement"])) {
    header("Location: ModifierEquipement.php?ref_equip=" . $currentEquipement->getRefEquip());

}

}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
