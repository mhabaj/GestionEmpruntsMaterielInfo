<?php
require_once("Controller/control-session.php");
require_once("Controller/DataBase.php");
require_once("Model/User.php");
require_once("Model/UserRegular.php");
require_once("Model/UserAdmin.php");
<<<<<<< HEAD
<<<<<<< HEAD
require_once("Controller/UserController.php");


if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1 && isset($_GET['id_user_toDisplay']) || isset($_GET['id_user_toDisplay']) && $_GET['id_user_toDisplay'] == $_SESSION['id_user'] )
{
    $userController = new UserController();
=======
>>>>>>> parent of 730364f... MERGE AVEC ADRIEN ET ALEX
=======
>>>>>>> parent of 730364f... MERGE AVEC ADRIEN ET ALEX

if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1 || $_GET['id_user_toDisplay'] == $_SESSION['id_user']) {
    ?>
    <html>
<body>
    <?php
    if (isset($_GET['id_user_toDisplay'])) {
        try {
            $currentUser = new UserRegular();
            $currentUser->loadingUser($_GET['id_user_toDisplay']);
        } catch (PDOException $e) {
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

<<<<<<< HEAD
<<<<<<< HEAD
    if (isset($userController) && $userController != null && isset($currentUser) && $currentUser != null)
    {
    ?>
        <?php
            // on include view ici
            require_once("view/detailUser.view.php")
        ?>

        <?php
        if(isset($_POST['endBorrow']) && $_SESSION['isAdmin_user'] == 1 && isset($_POST['idBorrow']) && is_numeric($_POST['idBorrow']) && isset($_POST['idDevice']))
        {
            $userController->returnBorrow($_SESSION['id_user'],$_POST['idBorrow'],$_POST['idDevice']);
            header("Refresh:0");
        }
    }
    else
    {
        header('Location: Catalogue.php');
    }
}
else
{
    echo "Vous n'avez pas accès à cette page";
    header("refresh:3;url=Catalogue.php");
    echo "<p> Redirection dans 3 secondes.. </p>";
}
=======
        <h3> Liste des emprunts courants de l'utilisateurs </h3>
        <?php foreach ($currentUser->getBorrowList() as $borrowedItem) {
            ?>
            <p> Emprunt numero : <?php echo $borrowedItem->getIdBorrow(); ?></p>
            <p> Reference de l'équipement emprunté : <?php echo $borrowedItem->getRefEquip(); ?> </p>
            <p> Id du matériel physique preté : <?php echo $borrowedItem->getDeviceId(); ?> </p>
            <p> Date de debut de l'emprunt : <?php echo $borrowedItem->getStartDate(); ?> </p>
            <p> Date de fin de l'emprunt : <?php echo $borrowedItem->getEndDate(); ?></p>
            <br/>
            </div>
            <?php
        }
        /* l'utilisateur et l'admin peuvent acceder à l'historique */

        /* seulement l'admin peut acceder à la modification de user */
        if ($_SESSION['isAdmin_user'] == 1) {
            ?>
            <a href="ModifyUser.php?id_user_toDisplay=<?php echo $_GET['id_user_toDisplay'] ?>"
               title="Modifier l'utilisateur">Modifier l'utilisateur</a>
            </body>
            </html>
            <?php
        }
=======
        <h3> Liste des emprunts courants de l'utilisateurs </h3>
        <?php foreach ($currentUser->getBorrowList() as $borrowedItem) {
            ?>
            <p> Emprunt numero : <?php echo $borrowedItem->getIdBorrow(); ?></p>
            <p> Reference de l'équipement emprunté : <?php echo $borrowedItem->getRefEquip(); ?> </p>
            <p> Id du matériel physique preté : <?php echo $borrowedItem->getDeviceId(); ?> </p>
            <p> Date de debut de l'emprunt : <?php echo $borrowedItem->getStartDate(); ?> </p>
            <p> Date de fin de l'emprunt : <?php echo $borrowedItem->getEndDate(); ?></p>
            <br/>
            </div>
            <?php
        }
        /* l'utilisateur et l'admin peuvent acceder à l'historique */

        /* seulement l'admin peut acceder à la modification de user */
        if ($_SESSION['isAdmin_user'] == 1) {
            ?>
            <a href="ModifyUser.php?id_user_toDisplay=<?php echo $_GET['id_user_toDisplay'] ?>"
               title="Modifier l'utilisateur">Modifier l'utilisateur</a>
            </body>
            </html>
            <?php
        }
>>>>>>> parent of 730364f... MERGE AVEC ADRIEN ET ALEX
    } else
        echo "Erreur, impossible de charger l'utilisateur";
} else
    echo "Vous n'avez pas accès à cette page"
<<<<<<< HEAD
?>
>>>>>>> parent of 730364f... MERGE AVEC ADRIEN ET ALEX
=======
?>
>>>>>>> parent of 730364f... MERGE AVEC ADRIEN ET ALEX
