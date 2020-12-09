<?php
require_once "Controller/DataBase.php";
require_once "Controller/CatalogueController.php";
?>

<html>
<body>
<form method="POST" enctype="multipart/form-data">
    <h1>Catalogue</h1>
    <label>Rechercher équipement:</label>
    <input type="search"  placeholder="Taper équipement" name="EquipmentToSearch">
    <button type="submit" name="startSearching">Rechercher</button>
</form>
<?php $myCatalogueController = new CatalogueController();
$myCatalogueController->getEquipmentList();
?>
</body>
</html>