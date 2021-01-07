<?php
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
    <h1>Création matériel</h1>

    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm"><label><b>Référence</b></label></span>
        </div>
        <input class="form-control" aria-label="Small"  type="text" placeholder="Référence matériel" name="ref"
               value="<?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null)
                   echo $currentEquipment->getRefEquip(); ?>"
               required>
    </div>

    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm"><br/><label><b>Type</b></label></span>
        </div>
        <input class="form-control" aria-label="Small"  placeholder="Type matériel" name="type"
               value="<?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null)
                   echo $currentEquipment->getTypeEquip(); ?>"
               required>
    </div>

    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm"><br/><label><b>Marque</b></label></span>
        </div>
        <input class="form-control" aria-label="Small"  type="text" placeholder="Marque matériel" name="brand"
               value="<?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null)
                   echo $currentEquipment->getBrandEquip(); ?>"
               required>
    </div>

    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm"><br/><label><b>Nom</b></label></span>
        </div>
        <input class="form-control" aria-label="Small"  type="text" placeholder="Nom matériel" name="name"
               value="<?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null)
                   echo $currentEquipment->getNameEquip(); ?>"
               required>
    </div>

    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm"><br/><label><b>Version</b></label></span>
        </div>
        <input class="form-control" aria-label="Small"  type="text" placeholder="Version matériel" name="version"
               value="<?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null)
                   echo $currentEquipment->getVersionEquip(); ?>" required>
    </div>

    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm"><br/><label><b>Quantité</b></label></span>
        </div>
        <input class="form-control" aria-label="Small"  type="number" placeholder="Quantité matériel" name="quantity"
               value="<?php if (isset($equipmentController) && $equipmentController != null && isset($currentEquipment) && $currentEquipment != null)
                   if (isset($quantity) && $quantity != null) echo $quantity; ?>" required>
    </div>

    <br/><label><b>Images: </b></label>
    <input type="image" max="1024" value="" name="photo">
    <input type="hidden" name="MAX_FILE_SIZE" value="8388608">
    <label for="photo"> Photo (JPG, JPEG, PNG or GIF | max.8 Mo) :</label><br/>
    <input class="form-control" type="file" id="photo" name="photo"/><br/>



    <br/>
    <button class="btn btn-success" type="submit" name="submitEquipment">Create Equipment</button>
</form>
<?php
require_once("footer.view.php");
?>