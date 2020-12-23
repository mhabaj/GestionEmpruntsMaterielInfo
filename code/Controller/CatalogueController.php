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
                { ?>
                    <a href="DetailEquipment.php?ref_equip=<?php echo $donnees['ref_equip']?>">
                        <div>
                            <strong> Type </strong> : <?php echo $donnees['type_equip'];?> <br/>
                            <strong> Matériel </strong> : <?php echo $donnees['brand_equip']." ".$donnees['name_equip'];?> <br/>
                            <strong> Version  </strong> : <?php echo $donnees['version_equip'];?> <br/> <br/>
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
}