<html>
    <body>
        <h2>Informations sur l'utilisateur </h2>

        <div>
            <p> Nom : <?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getLastName(); ?> </p>
            <p> Prénom : <?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getName(); ?> </p>
            <p> Mail : <?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getEmail(); ?> </p>
            <p> Identifiant de connexion : <?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getMatriculeUser(); ?> </p>
            <p> numéro ID : <?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getIdUser(); ?> </p>
            <p> numéro de telephone : <?php if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null) echo $currentUser->getPhone(); ?> </p>
            <br/>

            <h3> Liste des emprunts courants de l'utilisateurs </h3>

            <?php

            if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null)
            {
                foreach ($currentUser->getBorrowList() as $borrowedItem)
                {
                    ?>
                    <p> Emprunt numero : <?php echo $borrowedItem->getIdBorrow(); ?></p>
                    <p> Reference de l'équipement emprunté : <?php echo $borrowedItem->getRefEquip(); ?> </p>
                    <p> Id du matériel physique preté : <?php echo $borrowedItem->getDeviceId(); ?>
                    <p> Date de debut de l'emprunt : <?php echo $borrowedItem->getStartDate(); ?> </p>
                    <p> Date de fin de l'emprunt : <?php echo $borrowedItem->getEndDate(); ?></p>

                    <br/>
        </div>

                    <?php
                    if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1)
                    {
                        ?>
                        <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" value="<?php echo $borrowedItem->getIdBorrow() ?>" name="idBorrow" />
                        <input type="submit" value="Cliquez pour terminer un emprunt" name ="endBorrow" />
                        </form>
                        <?php
                    }
                }
            }
            /* l'utilisateur et l'admin peuvent acceder à l'historique */

            /* seulement l'admin ou l'utilisateur (pour son profil) peut acceder à la modification de user */
            ?>

            <form method="POST" enctype="multipart/form-data" action="ModifyUser.php?id_user_toDisplay=<?php if(isset($_GET['id_user_toDisplay'])) echo $_GET['id_user_toDisplay'] ?>">
                <input type="submit" value="Modify User" name ="modifyUsers"/>
            </form>

            <form method="POST" enctype="multipart/form-data" action="ModifyUser.php?id_user_toDisplay=<?php if(isset($_GET['id_user_toDisplay'])) echo $_GET['id_user_toDisplay'] ?>">
                <input type="submit" value="Modify password" name="modifyPassword" />
            </form>

            <form method="POST" enctype="multipart/form-data" action="HistoryUser.php?id_user_toDisplay=<?php if(isset($_GET['id_user_toDisplay'])) echo $_GET['id_user_toDisplay'] ?>">
                <input type="submit" value="Historique de l'utilisateur" name ="History"/>
            </form>
    </body>
</html>