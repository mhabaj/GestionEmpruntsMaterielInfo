<?php
    require_once("Controller/control-session.php");
    require_once("Controller/DataBase.php");
    require_once("Model/User.php");
    require_once("Model/UserRegular.php");
    require_once("Model/UserAdmin.php");
?>

<html>
    <body>
        <?php
            if (isset($_GET['id_user_toDisplay']))
            {
                try
                {
                    $bdd = new DataBase();
                    $con = $bdd->getCon();

                    $query = "SELECT * FROM users WHERE id_user= ? ;";
                    $myStatement = $con->prepare($query);
                    $myStatement->execute([$_GET['id_user_toDisplay']]);

                    $donnees = $myStatement->fetch();

                    $currentUser = new UserRegular();
                    $currentUser->loadingUser($_GET['id_user_toDisplay']);
                }
                catch(PDOException $e)
                {
                    throw new PDOException("Error!: " . $e->getMessage());
                }
        ?>

        <h2>Informations sur l'utilisateur </h2>

        <div>
            <p> Nom : <?php echo $currentUser->getLastName(); ?> </p>
            <p> Prénom : <?php echo $currentUser->getName(); ?> </p>
            <p> Mail : <?php echo $currentUser->getEmail(); ?> </p>
            <p> Identifiant de connexion : <?php echo $currentUser->getMatriculeUser(); ?> </p>
            <p> numéro ID : <?php echo $currentUser->getIdUser(); ?> </p>
            <br/>

            <h3> Liste des emprunts courants de l'utilisateurs </h3>
            <?php foreach ($currentUser->getBorrowList() as $borrowedItem)
            {?>
                <p> Emprunt numero : <?php echo $borrowedItem->getIdBorrow(); ?></p>
                <p> Reference de l'équipement emprunté : <?php echo $borrowedItem->getRefEquip(); ?> </p>
                <p> Id du matériel physique preté : <?php echo $borrowedItem->getDeviceId(); ?>
                <p> Date de debut de l'emprunt : <?php echo $borrowedItem->getStartDate(); ?> </p>
                <p> Date de fin de l'emprunt :  <?php echo $borrowedItem->getEndDate(); ?></p>
                <br/>
        </div>

        <?php
            }
        }
        else
            echo "Erreur, impossible de charger l'utilisateur";
        ?>

        <form action="ModifyUser.php?id_user_toDisplay=<?php echo $_GET['id_user_toDisplay'] ?>">
            <input type="submit" value="Modifier l'utilisateur" />
        </form>

    </body>
</html>