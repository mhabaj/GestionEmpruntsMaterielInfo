


<?php
if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {
    ?>
    <h3>Espace Adminisatateur :</h3>
    <form action="CreateEquipment.php" enctype="multipart/form-data">
        <button type="submit" name="addEquip">Ajouter un nouvel Equipement</button>
    </form>
    <form method="POST" enctype="multipart/form-data">
        <label>Rechercher utilisateur:</label>
        <input type="search" placeholder="Matricule de l'utilisateur" name="UserToSearch">
        <button type="submit" name="startSearchingUser">Rechercher</button>
    </form>
    <?php
}