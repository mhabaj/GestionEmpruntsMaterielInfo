<?php

require_once("Controller/control-session.php");
require_once "Controller/DataBase.php";
require_once "Model/Equipment.php";
require_once "Model/UserRegular.php";
require_once "Model/UserAdmin.php";
require_once "Controller/Functions.php";
require_once "Controller/EquipmentController.php";


if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {
    $currentUser = new UserAdmin();
    $currentUser->loadUser();
    if ($currentUser->getPrivilege() == 1) {
        try {
            $EquipmentController = new EquipmentController();

            $currentEquipement = null;
            $quantity = 1;
            if (!isset($_POST['submitEquipment'])) {
                $currentEquipement = new Equipment("", "", "", "", "");
            } else {
                $currentEquipement = new Equipment($_POST["ref"], $_POST["type"], $_POST["name"], $_POST["brand"], $_POST["version"]);
                $quantity = $_POST['quantity'];
            }
            $EquipmentController->setEquipment($currentEquipement);
            ?>

            <?php
            //IMPORT LA VUE:

            require_once("view/createEquipment.view.php");


            ?>


            <?php

            if (isset($_POST['submitEquipment'])) {
                if (isset($_POST['ref']) && isset($_POST['type']) && isset($_POST['name']) && isset($_POST['brand']) && isset($_POST['version']) && isset($_POST['quantity'])) {

                    $currentEquipement->setRefEquip($_POST['ref']);
                    $currentEquipement->setTypeEquip($_POST['type']);
                    $currentEquipement->setBrandEquip($_POST['brand']);
                    $currentEquipement->setNameEquip($_POST['name']);
                    $currentEquipement->setVersionEquip($_POST['version']);
                    $quantity = $_POST['quantity'];

                    $ref_equip = $_POST['ref'];
                    $type_equip = $_POST['type'];
                    $nom_equip = $_POST['name'];
                    $marque_equip = $_POST['brand'];
                    $version_equip = $_POST['version'];
                    $quantite_equip = $_POST['quantity'];


                    try {
                        if ($currentUser->getPrivilege() == 1) {
                            $photo = Functions::uploadImage($type_equip);

                            $EquipmentController->createNewEquipment($ref_equip, $type_equip, $marque_equip, $nom_equip, $version_equip, $quantite_equip);

                            unset($currentEquipement);
                            unset($EquipmentController);
                            header("Location: DetailEquipement.php?ref_equip=" . $ref_equip);
                        }

                    } catch (Exception $e) {
                        echo $e->getMessage();

                    }

                } else {
                    //header("refresh:0");
                }
            }


        } catch (Exception $e) {
            header("refresh:3;url=Catalogue.php");
            echo $e->getMessage();
            echo "<p> Redirection dans 3 secondes.. </p>";


        }
    }

}
?>