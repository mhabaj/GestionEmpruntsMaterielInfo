<?php

require_once("Controller/control-session.php");
require_once "Model/Equipment.php";
require_once "Controller/Functions.php";
require_once "Controller/EquipmentController.php";
require_once("ControllerDAO/UserDAO.php");


if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {
    $currentUser = UserDAO::getUserById($_SESSION['id_user']);

    try {
        $currentEquipment = null;
        $quantity = 1;
        if (!isset($_POST['submitEquipment'])) {
            $currentEquipment = new Equipment("", "", "", "", "");
        } else {
            $currentEquipment = new Equipment($_POST["ref"], $_POST["type"], $_POST["name"], $_POST["brand"], $_POST["version"]);
            $quantity = $_POST['quantity'];
        }
        $equipmentController = new EquipmentController();
        $equipmentController->loadEquipmentFromObject($currentEquipment);
        ?>

        <?php
        //IMPORT LA VUE:

        require_once("view/createEquipment.view.php");


        ?>


        <?php

        if (isset($_POST['submitEquipment'])) {
            if (isset($_POST['ref']) && isset($_POST['type']) && isset($_POST['name']) && isset($_POST['brand']) && isset($_POST['version']) && isset($_POST['quantity'])) {

                $currentEquipment->setRefEquip($_POST['ref']);
                $currentEquipment->setTypeEquip($_POST['type']);
                $currentEquipment->setBrandEquip($_POST['brand']);
                $currentEquipment->setNameEquip($_POST['name']);
                $currentEquipment->setVersionEquip($_POST['version']);
                $quantity = $_POST['quantity'];

                $equipmentController->loadEquipmentFromObject($currentEquipment);

                try {

                    $equipmentController->createNewEquipment($quantity);
                    $tempRef = $currentEquipment->getRefEquip();

                    $photo = Functions::uploadImage($currentEquipment->getTypeEquip());
                    if ($photo != null && $photo != "") {
                        $currentUser->addImageToEquipment($photo, $currentEquipment->getTypeEquip());
                    }
                    unset($currentEquipment);
                    unset($equipmentController);
                    header("Location: DetailEquipment.php?ref_equip=" .$tempRef);

                } catch (Exception $e) {
                    echo $e->getMessage();

                }

            }
        }


    } catch (Exception $e) {
        header("refresh:3;url=DashBoard.php");
        echo $e->getMessage();
        echo "<p> Redirection dans 3 secondes.. </p>";


    }

}
?>