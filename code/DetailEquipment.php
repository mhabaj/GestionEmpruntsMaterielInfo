<?php
    require "Model/Equipment.php";

    $bdd = new DataBase();
    $con = $bdd->getCon();

    $queryEquipments = "SELECT * FROM equipment WHERE ref_equip LIKE ?;";
    $myStatement = $con->prepare($queryEquipments);
    $myStatement->execute([$_GET['ref_equip']]);

    $donnees = $myStatement->fetch();

    $equip = new Equipment($donnees['ref_equip'], $donnees['type_equip'], $donnees['name_equip'], $donnees['brand_equip'], $donnees['version_equip']);

    $bdd->closeCon();
?>

<html>
    <body>
        <img src="donnée moi de la moulaga" alt="<?php echo $equip->getRefEquip()?>" width="200" height="200">

        <p><?php echo $equip->getNameEquip()?></p>
    </body>
</html>