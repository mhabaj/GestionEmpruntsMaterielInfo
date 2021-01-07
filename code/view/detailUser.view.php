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
    <h2>Informations sur l'utilisateur </h2>

    <div>
        <p> Nom
            : <?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getLastName(); ?> </p>
        <p> Prénom
            : <?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getFirstName(); ?> </p>
        <p> Mail
            : <?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getEmail(); ?> </p>
        <p> Identifiant de connexion
            : <?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getMatriculeUser(); ?> </p>
        <p> numéro ID
            : <?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getIdUser(); ?> </p>
        <p> numéro de telephone
            : <?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getPhone(); ?> </p>
        <br/>

        <form method="POST" enctype="multipart/form-data"
              action="ModifyUser.php?id_user_toDisplay=<?php if (isset($_GET['id_user_toDisplay'])) echo $_GET['id_user_toDisplay'] ?>">
            <input class="btn btn-primary" type="submit" value="Modifier Utilisateur" name="modifyUser"/>
        </form>
        <br/>
        <form method="POST" enctype="multipart/form-data"
              action="ModifyUser.php?id_user_toDisplay=<?php if (isset($_GET['id_user_toDisplay'])) echo $_GET['id_user_toDisplay'] ?>">
            <input class="btn btn-primary" type="submit" value="Modifier mot de passe" name="modifyPassword"/>
        </form>
        <br/>
        <form method="POST" enctype="multipart/form-data"
              action="HistoryUser.php?id_user_toDisplay=<?php if (isset($_GET['id_user_toDisplay'])) echo $_GET['id_user_toDisplay'] ?>">
            <input class="btn btn-info" type="submit" value="Historique de l'utilisateur" name="History"/>
        </form>

        <h3> Liste des emprunts courants de l'utilisateur </h3>

        <?php

        if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null)
        {
        foreach ($currentUser->getBorrowList() as $borrowedItem)
        {

        ?>
    <br/>
    <div class="panel panel-default" style="width: 60%;">
        <div class="panel-body">
            <p> Emprunt numero : <?php echo $borrowedItem->getIdBorrow(); ?></p>
            <p> Reference de l'équipement emprunté : <?php echo $borrowedItem->getRefEquip(); ?> </p>
            <p> Id du matériel physique preté : <?php echo $borrowedItem->getDeviceId(); ?>
            <p> Date de debut de l'emprunt : <?php echo $borrowedItem->getStartDate(); ?> </p>
            <p> Date de fin de l'emprunt : <?php echo $borrowedItem->getEndDate(); ?></p>
        </div>
    </div>

            

    <?php
    if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {
        ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $borrowedItem->getIdBorrow() ?>" name="idBorrow"/>
            <input class="btn btn-secondary" type="submit" value="Cliquez pour terminer un emprunt" name="endBorrow"/>
        </form>
        <?php
    }
    }
    }
    /* l'utilisateur et l'admin peuvent acceder à l'historique */

    /* seulement l'admin ou l'utilisateur (pour son profil) peut acceder à la modification de user */
    ?>
<?php
require_once("footer.view.php");
?>