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
        : <?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) echo $currentEquipment->getRefEquip() ?> </p>
    <br/>
    <p> Type d'équipement
        : <?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) echo $currentEquipment->getTypeEquip() ?> </p>
    <br/>
    <p> Matériel
        : <?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) echo $currentEquipment->getBrandEquip(); ?> </p>
    <br/>
    <p> Nom
        : <?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) echo $currentEquipment->getNameEquip(); ?> </p>
    <br/>
    <p> Version
        : <?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) echo $currentEquipment->getVersionEquip() ?> </p>
    <br/>
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

    <form method="POST" enctype="multipart/form-data">
        <label> <b>----- Reserver cet équipement ----- </b></label>


        <p>Date fin de reservation: </p>

        <input type="date" placeholder="Date fin de reservation" name="dateRes">
        <p> Quantite du materiel souhaité <b>(Disponible / Occupé / Total présent:
                <mark><?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) echo $equipmentController->getEquipmentDAO()->howMuchAvailable($currentEquipment->getRefEquip()) . "/" . ($equipmentController->getEquipmentDAO()->howMuchAvailable($currentEquipment->getRefEquip()) - $equipmentController->getEquipmentDAO()->howMuchTotal($currentEquipment->getRefEquip())) * -1 . "/" . $equipmentController->getEquipmentDAO()->howMuchTotal($currentEquipment->getRefEquip()); ?></mark>
                ): </b></p>

        <input type="number" placeholder="Quantité souhaité" name="quantiteNumber" min="1" value="1"
               max="<?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) echo $equipmentController->getEquipmentDAO()->howMuchAvailable($currentEquipment->getRefEquip()) ?>">
        <input type="submit" value="Reserver l'équipement" placeholder="Reserver l'équipement"
               name="reserveEquipment">
    </form>
    <?php if (isset($erreur) && !$erreur == "") echo "<p>" . $erreur . "</p>"; ?>

    <?php

    if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) { ?>
        <p>---------------------------------------------</p>
        <label> <b> ESPACE ADMINISTRATEUR: </b> </label>
        <form method="POST" enctype="multipart/form-data">
            <input type="submit" value="Modifier cet équipement" placeholder="Modifier cet équipement"
                   name="modifierEquipement">
        </form>


        <?php
        if (isset($_POST["modifierEquipement"])) {
            if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null) {
                header("Location: ModifyEquipment.php?ref_equip=" . $currentEquipment->getRefEquip());
            }
        }

    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ?>
</div>

</body>
</html>