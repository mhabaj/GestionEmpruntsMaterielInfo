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
            if (!isset($_GET['submitEquipment'])) {
                $currentEquipement = new Equipment("", "", "", "", "");
            } else {
                $currentEquipement = new Equipment($_GET["ref"], $_GET["type"], $_GET["name"], $_GET["brand"], $_GET["version"]);
                $quantity = $_GET['quantity'];
            }
            $EquipmentController->setEquipment($currentEquipement);
            ?>

            <?php
            //IMPORT LA VUE:

            require_once("view/createEquipment.view.php");


            ?>


            <?php

            if (isset($_GET['submitEquipment'])) {
                if (isset($_GET['ref']) && isset($_GET['type']) && isset($_GET['name']) && isset($_GET['brand']) && isset($_GET['version']) && isset($_GET['quantity'])) {

                    $currentEquipement->setRefEquip($_GET['ref']);
                    $currentEquipement->setTypeEquip($_GET['type']);
                    $currentEquipement->setBrandEquip($_GET['brand']);
                    $currentEquipement->setNameEquip($_GET['name']);
                    $currentEquipement->setVersionEquip($_GET['version']);
                    $quantity = $_GET['quantity'];

                    $ref_equip = $_GET['ref'];
                    $type_equip = $_GET['type'];
                    $nom_equip = $_GET['name'];
                    $marque_equip = $_GET['brand'];
                    $version_equip = $_GET['version'];
                    $quantite_equip = $_GET['quantity'];


                    try {
                        if ($currentUser->getPrivilege() == 1) {
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