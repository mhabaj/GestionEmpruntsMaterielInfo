<?php

require_once "Controller/DataBase.php";

class CatalogueController
{
    public function __construct()
    {

    }

    public function getEquipmentList()
    {
        if( isset($_GET['type']))
        {
            try
            {
                $bdd = new DataBase();
                $con = $bdd->getCon();

                $queryEquipments = "SELECT * FROM equipment WHERE type_equip LIKE ?;";
                $myStatement = $con->prepare($queryEquipments);
                $myStatement->execute([$_GET['type']]);


                while($donnees = $myStatement->fetch())
                {
                    require "view/resultSearchEquipment.view.php";
                }
            }
            catch(PDOException $e)
            {
                throw new PDOException("Error!: " . $e->getMessage());
            }
            $myStatement->closeCursor();
        }
        else
        {
            try
            {
                $bdd = new DataBase();
                $con = $bdd->getCon();

                $queryEquipments = "SELECT DISTINCT(type_equip) FROM equipment ;";
                $myStatement = $con->query($queryEquipments);

                while($donnees = $myStatement->fetch())
                { ?>
                    <a href="Catalogue.php?type=<?php echo $donnees['type_equip']?>">
                        <div>
                            <strong> Type </strong> : <?php echo $donnees['type_equip'];?> <br/>
                        </div>
                    </a>
                    <?php
                }
            }
            catch(PDOException $e)
            {
                throw new PDOException("Error!: " . $e->getMessage());
            }
            $myStatement->closeCursor();
        }
    }

    public function searchEquipment()
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $EquipToSearch = trim($_POST['EquipmentToSearch']);

        if ($_POST['radio_recherche'] == "radio_name")
            $queryEquipments = "SELECT * FROM equipment WHERE name_equip LIKE ?;";
        elseif ($_POST['radio_recherche'] == "radio_ref")
            $queryEquipments = "SELECT * FROM equipment WHERE ref_equip LIKE ?;";

        $myStatement = $con->prepare($queryEquipments);
        $myStatement->execute([$EquipToSearch . "%"]);

        if ($myStatement->rowCount() > 0) {
            while ($donnees = $myStatement->fetch())
            {
                require "view/resultSearchEquipment.view.php";
            }
            $myStatement->closeCursor();
        } else {
            ?>
            <label>Aucun document ne correspond aux termes de recherche spécifiés.</label>
            <?php
        }
        $myStatement->closeCursor();
    }

    public function searchUser()
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $UserToSearch = trim($_POST['UserToSearch']);

        $queryEquipments = "SELECT * FROM users WHERE matricule_user LIKE ?;";
        $myStatement = $con->prepare($queryEquipments);
        $myStatement->execute([$UserToSearch."%"]);

        if($myStatement->rowCount() > 0)
        {
            while ($donnees = $myStatement->fetch()) {
                require "view/resultSearchUser.view.php";
            }
        }
        else{
            ?>
            <label>Aucun document ne correspond aux termes de recherche spécifiés.</label>
            <?php
        }
        $myStatement->closeCursor();
    }

}