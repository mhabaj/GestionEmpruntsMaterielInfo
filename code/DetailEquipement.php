<?php
require_once("Controller/control-session.php");

require "Controller/DataBase.php";
require "Model/Equipment.php";

?>
<html>
<body>

<?php

if (isset($_GET['ref_equip']) && $_GET['ref_equip'] != null) {
    $bdd = new DataBase();
    $con = $bdd->getCon();

    $queryEquipments = "SELECT * FROM equipment WHERE equipment.ref_equip LIKE ?;";
    $myStatement = $con->prepare($queryEquipments);
    $myStatement->execute([$_GET['ref_equip']]);

    $donnees = $myStatement->fetch();
    $currentEquipement = new Equipment($donnees['ref_equip'], $donnees['type_equip'], $donnees['name_equip'], $donnees['brand_equip'], $donnees['version_equip']);
    ?>
    <div>
        <p> Reference d'équipement: : <?php echo $currentEquipement->getRefEquip() ?> </p><br/>
        <p> Type d'équipement : <?php echo $currentEquipement->getTypeEquip() ?> </p><br/>
        <p> Matériel
            : <?php echo $currentEquipement->getBrandEquip() . " " . $currentEquipement->getNameEquip(); ?> </p> <br/>
        <p> Version : <?php echo $currentEquipement->getVersionEquip() ?> </p> <br/>
        <?php
        $bdd2 = new DataBase();
        $con2 = $bdd2->getCon();
        $queryEquipments1 = "SELECT link_photo FROM stock_photo WHERE ref_equip LIKE ?; ";
        $myStatement1 = $con2->prepare($queryEquipments);
        $myStatement1->execute([$_GET['ref_equip']]);
        while ($donnees1 = $myStatement1->fetch()) {

            if (isset($donnees1['link_photo'])) { ?>

                <img src="<?php echo $donnees1['link_photo'] ?>" alt="Photo Device" width="500" height="600">
                <?php
            }
        }
        $myStatement1->closeCursor();
        ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Reserver cette équipement (Disponible: <?php echo $currentEquipement->howMuchAvailable() ?>)</label> <br>
            <input type="date" placeholder="Date Reservation" name="dateRes">
            <input type="number" placeholder="Quantité souhaité" name="quantiteNumber">
            <input type="button" value="Reserver l'équipement" placeholder="Reserver l'équipement"
                   name="reserveEquipment">


            

        </form>
        <?php
        if (isset($_POST['reserveEquipment']) && isset($_POST['dateRes']) && isset($_POST['quaniteNumber'])) {

            $dateFinBorrow = $_POST['dateRes'];
            $quantiteToReserve = $_POST['quantiteNumber'];

            if ($currentEquipement->howMuchAvailable() >= $quantiteToReserve) {
                $_SESSION['User']->borrowEquipement($currentEquipement->getRefEquip(), $dateFinBorrow, $quantiteToReserve);
            }else{
                echo "<p> C PAS BON POTO </p>";
            }
        }
        ?>
    </div>
    <?php


} else {
    header('Location: Catalogue.php');

}
?>

</body>
</html>