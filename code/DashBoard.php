<?php
//Local class for main dashboard structure
require_once "Controller/DataBase.php";

/**
 * Class CatalogueController
 */
class CatalogueController
{
    /**
     * CatalogueController constructor.
     */
    public function __construct()
    {

    }

    /**
     *
     */
    public function getEquipmentList()
    {
        if (isset($_GET['type'])) {
            try {
                $bdd = new DataBase();
                $con = $bdd->getCon();

                $queryEquipments = "SELECT * FROM equipment WHERE type_equip LIKE ?;";
                $myStatement = $con->prepare($queryEquipments);
                $myStatement->execute([$_GET['type']]);


                while ($donnees = $myStatement->fetch()) {
                    require "view/resultSearchEquipment.view.php";
                }
            } catch (PDOException $e) {
                throw new PDOException("Error!: " . $e->getMessage());
            }
            $myStatement->closeCursor();
        } else {
            try {
                $bdd = new DataBase();
                $con = $bdd->getCon();

                $queryEquipments = "SELECT DISTINCT(type_equip) FROM equipment ;";
                $myStatement = $con->query($queryEquipments);
                echo "<strong> Affichage par Type </strong>";
                while ($donnees = $myStatement->fetch()) { ?>
                    <a href="DashBoard.php?type=<?php echo $donnees['type_equip']; ?>">
                        <div>
                            <?php echo $donnees['type_equip']; ?> <br/>
                        </div>
                    </a>
                    <?php
                }
            } catch (PDOException $e) {
                throw new PDOException("Error!: " . $e->getMessage());
            }
            $myStatement->closeCursor();
        }
    }

    /**
     * @throws Exception
     */
    public function searchEquipment()
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $EquipToSearch = trim($_POST['EquipmentToSearch']);

        $queryEquipments = "";
        if ($_POST['radio_recherche'] == "radio_name")
            $queryEquipments = "SELECT * FROM equipment WHERE name_equip LIKE ?;";
        elseif ($_POST['radio_recherche'] == "radio_ref")
            $queryEquipments = "SELECT * FROM equipment WHERE ref_equip LIKE ?;";

        $myStatement = $con->prepare($queryEquipments);
        $myStatement->execute([$EquipToSearch . "%"]);

        if ($myStatement->rowCount() > 0) {
            while ($donnees = $myStatement->fetch()) {
                require "view/resultSearchEquipment.view.php";
            }
            $myStatement->closeCursor();
        } else {
            throw new Exception("Aucun équipement ne correspond aux termes de recherche spécifiés.");
        }
        $myStatement->closeCursor();
    }

    /**
     * @throws Exception
     */
    public function searchUser()
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $UserToSearch = trim($_POST['UserToSearch']);

        $queryEquipments = "SELECT * FROM users WHERE matricule_user LIKE ?;";
        $myStatement = $con->prepare($queryEquipments);
        $myStatement->execute([$UserToSearch . "%"]);

        if ($myStatement->rowCount() > 0) {
            while ($donnees = $myStatement->fetch()) {
                require "view/resultSearchUser.view.php";
            }
        } else {
            throw new Exception("Aucun utilisateur ne correspond aux termes de recherche spécifiés.");
        }
        $myStatement->closeCursor();
    }


}

?>


<?php
$title = "Catalogue";
$erreur = "";
$erreurAdmin = "";
require_once("Controller/control-session.php");
require_once "Controller/DataBase.php";
require_once "Model/Equipment.php";
require_once "Controller/Functions.php";
require_once "Controller/EquipmentController.php";
ob_start();

$myCatalogueController = new CatalogueController();

/*********************************************************************************************************************/


if (isset($_POST['startSearching']) && $_POST['EquipmentToSearch'] != null && $_POST['EquipmentToSearch'] == trim($_POST['EquipmentToSearch'])) {
    try {
        $myCatalogueController->searchEquipment();
    } catch (Exception $e) {
        $erreur = "<p>" . $e->getMessage() . "</p>";
    }
}
require_once "view/buttondetailUser.view.php";
require_once "view/searchEquipment.view.php";
/********************************************************************************************************************/
$myCatalogueController->getEquipmentList();

if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {

    /*****************************************************************************************************************************************/
    if (isset($_POST['startSearchingUser']) && $_POST['UserToSearch'] != null && $_POST['UserToSearch'] == trim($_POST['UserToSearch'])) {
        try {
            $myCatalogueController->searchUser();
        } catch (Exception $e) {
            $erreurAdmin = "<p>" . $e->getMessage() . "</p>";
        }
    }
    require_once "view/adminOverview.view.php";

}
/*****************************************************************************************************************************************/