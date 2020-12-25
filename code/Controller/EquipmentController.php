<?php

/**
 * Class EquipmentController
 */
class EquipmentController
{

    private $_equipment;
    private $photosArray = array();

    /**
     * EquipmentController constructor.
     * @param string $refEquipment
     * @throws Exception  Invalid refEquipment;
     */
    public function __construct(string $refEquipment)
    {
        $newEquip = $this->initEquipmentController($refEquipment);
        if ($newEquip != null) {
            $this->_equipment = $newEquip;
        } else {
            throw new Exception("Exception Equipment Controller: Invalid refEquipment");
        }

    }

    public function initEquipmentController(string $refEquipment): ?Equipment
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $queryEquipments = "SELECT * FROM equipment WHERE equipment.ref_equip LIKE ?;";
        $myStatement = $con->prepare($queryEquipments);
        $myStatement->execute([$_GET['ref_equip']]);

        $donnees = $myStatement->fetch();
        if ($donnees['ref_equip'] != null) {
            $equipment = new Equipment($donnees['ref_equip'], $donnees['type_equip'], $donnees['name_equip'], $donnees['brand_equip'], $donnees['version_equip']);
            $queryPhotos = "SELECT link_photo FROM stock_photo WHERE ref_equip LIKE ?; ";
            $myStatement1 = $con->prepare($queryPhotos);
            $myStatement1->execute([$_GET['ref_equip']]);
            while ($donnees1 = $myStatement1->fetch()) {
                if (isset($donnees1['link_photo'])) {
                    $arrayPhoto = array();
                    array_push($arrayPhoto, $donnees1['link_photo']);
                    $equipment->setPhotoArray($arrayPhoto);
                } else {
                    $arrayPhoto = array();
                    $equipment->setPhotoArray($arrayPhoto);

                }
            }
            $myStatement1->closeCursor();
            $bdd->closeCon();
            return $equipment;
        } else {
            return null;
        }
    }


    /**
     * @return Equipment
     */
    public function getEquipment(): Equipment
    {
        return $this->_equipment;
    }

    /**
     * @return array
     */
    public function getPhotosArray(): array
    {
        return $this->photosArray;
    }

}