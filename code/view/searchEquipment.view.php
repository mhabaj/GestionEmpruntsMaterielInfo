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
