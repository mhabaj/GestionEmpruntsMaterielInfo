<?php
if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {
    ?>

    <h3>Espace Administrateur :</h3>
    <form action="CreateEquipment.php" enctype="multipart/form-data">
        <button class="btn btn-primary" type="submit" name="addEquip">Creer un équipement</button>
    </form>
    <br>
    <form action="RegisterUser.php" enctype="multipart/form-data">
        <button class="btn btn-primary"  type="submit" name="createUser">Creer un Utilisateur</button>
    </form>
    <br>
    <form method="POST" enctype="multipart/form-data">
        <input type="search" placeholder="Matricule de l'utilisateur" name="UserToSearch">
        <button class="btn btn-success" type="submit" name="startSearchingUser">Rechercher utilisateur</button>
    </form>
    <?php if (isset($erreurAdmin) && !$erreurAdmin == "") echo "<p>" . $erreurAdmin . "</p>"; ?>
    
    <?php

}