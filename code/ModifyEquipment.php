<?php

require_once("Controller/control-session.php");
require_once "Model/Equipment.php";
require_once "Controller/Functions.php";
require_once "Controller/EquipmentController.php";
require_once("ControllerDAO/EquipmentDAO.php");
ob_start();


if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1 && isset($_GET['ref_equip'])) {

    try {
        $equipmentController = new EquipmentController();
        $equipmentController->loadEquipmentFromDDB($_GET['ref_equip']);
        $currentEquipment = $equipmentController->getEquipment();

        ?>
        <?php

        require_once("view/modifyEquipment.view.php");


        ?>
        <?php

        if (isset($_POST['modifierEquipment']) && isset($equipmentController) && $equipmentController != null) {
            if (isset($_POST['ref_equip']) && isset($_POST['type_equip']) && isset($_POST['nom_equip']) && isset($_POST['marque_equip']) && isset($_POST['version_equip']) && isset($_POST['quantite_equip'])) {
                $ref_equip = $_POST['ref_equip'];
                $type_equip = $_POST['type_equip'];
                $nom_equip = $_POST['nom_equip'];
                $marque_equip = $_POST['marque_equip'];
                $version_equip = $_POST['version_equip'];
                $quantite_equip = $_POST['quantite_equip'];
                try {
                    $equipmentController->modifyEquipment($ref_equip, $type_equip, $nom_equip, $marque_equip, $version_equip, $quantite_equip);
                    $photo = Functions::uploadImage($type_equip);
                    if ($photo != null && $photo != "") {
                        ob_end_clean();
                        EquipmentDAO::updateImageToEquipment($photo, $ref_equip);
                    }
                    unset($currentEquipment);
                    unset($equipmentController);
                    ob_end_clean();

                    header("Location: DetailEquipment.php?ref_equip=" . $ref_equip);

                } catch (Exception $e) {
                    echo $e->getMessage();

                }

            } else {
                ob_end_clean();

                header("refresh:0");
            }
        }


    } catch (Exception $e) {
        ob_end_clean();

        header("refresh:3;url=DashBoard.php");
        echo $e->getMessage();
        echo "<p> Redirection dans 3 secondes.. </p>";

    }
} else {
    ob_end_clean();

    header("refresh:3;url=DashBoard.php");
    echo "L'equipement que vous essayer de consulter est invalide";
    echo "<p> Redirection dans 3 secondes.. </p>";
}
