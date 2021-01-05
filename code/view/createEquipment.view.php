<html>
<body>
<form method="POST" enctype="multipart/form-data">
    <h1>Création matériel</h1>

    <label><b>Référence</b></label>
    <input type="text" placeholder="Référence matériel" name="ref"
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipment) && $currentEquipment != null)
               echo $currentEquipment->getRefEquip(); ?>"
           required>

    <br/><label><b>Type</b></label>
    <input type="text" placeholder="Type matériel" name="type"
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipment) && $currentEquipment != null)
               echo $currentEquipment->getTypeEquip(); ?>"
           required>

    <br/><label><b>Marque</b></label>
    <input type="text" placeholder="Marque matériel" name="brand"
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipment) && $currentEquipment != null)
               echo $currentEquipment->getBrandEquip(); ?>"
           required>

    <br/><label><b>Nom</b></label>
    <input type="text" placeholder="Nom matériel" name="name"
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipment) && $currentEquipment != null)
               echo $currentEquipment->getNameEquip(); ?>"
           required>

    <br/><label><b>Version</b></label>
    <input type="text" placeholder="Version matériel" name="version"
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipment) && $currentEquipment != null)
               echo $currentEquipment->getVersionEquip(); ?>" required>

    <br/><label><b>Quantité</b></label>
    <input type="number" placeholder="Quantité matériel" name="quantity"
           value="<?php if (isset($EquipmentController) && $EquipmentController != null && isset($currentEquipment) && $currentEquipment != null)
               if (isset($quantity) && $quantity != null) echo $quantity; ?>" required>


    <br/><label><b>Images: </b></label>
    <input type="image" max="1024" value="" name="photo">
    <input type="hidden" name="MAX_FILE_SIZE" value="8388608">
    <label for="photo"> Photo (JPG, JPEG, PNG or GIF | max.8 Mo) :</label><br/>
    <input type="file" id="photo" name="photo"/><br/>



    <br/>
    <button type="submit" name="submitEquipment">Create Equipment</button>
</form>
</body>
</html>