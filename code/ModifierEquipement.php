<?php

require_once("Controller/control-session.php");
require "Controller/DataBase.php";
require "Model/Equipment.php";
require "Model/UserRegular.php";


?>
    <html>
<body>


<?php
if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {
    echo("ADMIN DETECTEE");
    if (isset($_GET['ref_equip']) && $_GET['ref_equip'] != null) {
        echo("REF EQUIP DETECTEE");

        $bdd = new DataBase();
        $con = $bdd->getCon();

        $queryEquipments = "SELECT * FROM equipment WHERE equipment.ref_equip LIKE ?;";
        $myStatement = $con->prepare($queryEquipments);
        $myStatement->execute([$_GET['ref_equip']]);

        $donnees = $myStatement->fetch();
        if ($donnees['ref_equip'] != null) {
            $currentEquipement = new Equipment($donnees['ref_equip'], $donnees['type_equip'], $donnees['name_equip'], $donnees['brand_equip'], $donnees['version_equip']);
            ?>
            <form method="POST" enctype="multipart/form-data">
                <label>Modifier cette équipement (Disponible: <?php echo $currentEquipement->howMuchAvailable() ?>)</label>
                <br>

                <input type="text" placeholder="Reference de l'équipement" name="ref_equip" value="PAS UTILISER ENCORE">
                <input type="date" placeholder="Type de l'équipement" name="type_equip" value="">
                <input type="date" placeholder="Nom de l'équipement" name="nom_equip" value="">
                <input type="date" placeholder="Marque de l'équipement" name="marque_equip" value="">
                <input type="date" placeholder="Version de l'équipement" name="version_equip" value="">

                <input type="submit" value="Reserver l'équipement" placeholder="Reserver l'équipement"
                       name="reserveEquipment">
            </form>
            <?php

        }


    }
}











