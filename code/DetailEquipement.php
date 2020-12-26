<?php
require_once("Controller/control-session.php");

require_once("Controller/DataBase.php");
require_once("Model/UserRegular.php");
require_once("Model/Equipment.php");
require_once ("Controller/EquipmentController.php");


if (isset($_GET['ref_equip']) && $_GET['ref_equip'] != null) {

try {
$EquipmentController = new EquipmentController($_GET['ref_equip']);
$currentEquipement = $EquipmentController->getEquipment();
?>

    <?php
    //INCLUDE VIEW:

    include_once ("view/detailEquipment.view.php");



    ?>


<?php
if (isset($_POST['reserveEquipment']) && isset($_POST['dateRes']) && isset($_POST['quantiteNumber']) && isset($EquipmentController) && $EquipmentController != null) {

    $dateFinBorrow = $_POST['dateRes'];
    $quantite_equip = $_POST['quantiteNumber'];


    if ($dateFinBorrow != null && $quantite_equip != null && is_numeric($quantite_equip) && $quantite_equip >= 0) {
        if ($currentEquipement->howMuchAvailable() >= $quantite_equip) {
            $currentUser = new UserRegular();
            $currentUser->loadUser();
            if ($currentUser->borrowEquipement($currentEquipement->getRefEquip(), $dateFinBorrow, $quantite_equip)) {
                echo "<p> Reservation effectuée </p>";
                header("Refresh:1");


            }
        } else {
            echo "<p> Quantité demandée indisponible </p>";
        }
    } else {
        echo "<p> Données de reservation entrées invalides </p>";

    }
}

} catch (Exception $e) {
    echo "Exception Equipment Controller: " . $e->getMessage();
}
} else {
    header('Location: Catalogue.php');

}
?>
