<html lang="fr">
    <body>
        <form method="POST" enctype="multipart/form-data">
            <h1>Modifier un utilisateur</h1>
            <p>Veuillez remplir les champs ci-dessous pour modifier un utilisateur</p>
            <hr>

            <label><b>Nom d'utilisateur</b></label>
            <input type="text"
                   value="<?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getMatriculeUser() ?>"
                   name="matricule">
            <br><br>

            <label><b>Email</b></label>
            <input type="email"
                   value="<?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getEmail() ?>"
                   name="email">
            <br><br>
            <label><b>Nom de famille</b></label>
            <input type="text"
                   value="<?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getLastName() ?>"
                   name="lastname">

            <label><b>Prénom</b></label>
            <input type="text"
                   value="<?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getFirstName() ?>"
                   name="name">
            <br><br>
            <label><b>Numéro de téléphone</b></label>
            <input type="tel" pattern="[0-9]{10}"
                   value="<?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getPhone() ?>"
                   name="phone">
            <br><br>
            <?php
            if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user']==1) {
                ?>
                <label><b>Modifer les droits de l'utilisateur</b></label>
                <label>
                    <input type="checkbox" checked="checked" name="administrateur" value="ok" style="margin-bottom:15px">Administrateur
                </label>
                <?php
            }
            ?>

            <hr>
            <button type="submit" name="submitModification">Confirmer les modifications</button>
        </form>

        <form action="DetailUser.php?<?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getIdUser()?>" enctype="multipart/form-data">
            <button type="button" name="cancelbtn">Annuler les modifications</button>
        </form>
    </body>
</html>