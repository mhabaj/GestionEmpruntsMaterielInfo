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
            $EquipmentController->initEquipmentController($_GET['ref_equip']);
            $currentEquipement = $EquipmentController->getEquipment();

            ?>
            <?php

            require_once("view/modifierEquipement.view.php");


            ?>
            <?php

            if (isset($_POST['modifierEquipment']) && isset($EquipmentController) && $EquipmentController != null) {
                if (isset($_POST['ref_equip']) && isset($_POST['type_equip']) && isset($_POST['nom_equip']) && isset($_POST['marque_equip']) && isset($_POST['version_equip']) && isset($_POST['quantite_equip'])) {
                    $ref_equip = $_POST['ref_equip'];
                    $type_equip = $_POST['type_equip'];
                    $nom_equip = $_POST['nom_equip'];
                    $marque_equip = $_POST['marque_equip'];
                    $version_equip = $_POST['version_equip'];
                    $quantite_equip = $_POST['quantite_equip'];
                    try {
                        if ($currentUser->getPrivilege() == 1) {
                            $EquipmentController->modifyEquipment($ref_equip, $type_equip, $nom_equip, $marque_equip, $version_equip, $quantite_equip, $currentUser->getIdUser());
                            $photo = Functions::uploadImage($type_equip);
                            if ($photo != null && $photo != "") {
                                $currentUser->updateImageToEquipment($photo, $ref_equip);
                            }
                            unset($currentEquipement);
                            unset($EquipmentController);
                            header("Location: DetailEquipement.php?ref_equip=" . $ref_equip);


                        }

                    } catch (Exception $e) {
                        echo $e->getMessage();

                    }

                } else {
                    header("refresh:0");
                }
            }


        } catch (Exception $e) {
            header("refresh:3;url=Catalogue.php");
            echo $e->getMessage();
            echo "<p> Redirection dans 3 secondes.. </p>";


        }
    }

}