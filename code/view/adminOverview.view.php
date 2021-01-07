<?php
if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {
    ?>
    <h3>Espace Administrateur :</h3>
    <form action="CreateEquipment.php" enctype="multipart/form-data">

        <button type="submit" name="addEquip">Creer un équipement</button>
    </form>
    <form method="POST" enctype="multipart/form-data">
        <input type="search" placeholder="Matricule de l'utilisateur" name="UserToSearch">
        <button type="submit" name="startSearchingUser">Rechercher utilisateur</button>
    </form>

    <form action="RegisterUser.php" enctype="multipart/form-data">
        <button type="submit" name="startSearchingUser">Creer un Utilisateur</button>
    </form>
    <?php if (isset($erreurAdmin) && !$erreurAdmin == "") echo "<p>" . $erreurAdmin . "</p>"; ?>

    <?php
}