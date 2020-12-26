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
    public function __construct()
    {


    }

    public function initEquipmentController($refEquipment)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $queryEquipments = "SELECT * FROM equipment WHERE equipment.ref_equip LIKE ?;";
        $myStatement = $con->prepare($queryEquipments);
        $myStatement->execute([$refEquipment]);

        $donnees = $myStatement->fetch();
        if ($donnees['ref_equip'] != null) {
            $equipment = new Equipment($donnees['ref_equip'], $donnees['type_equip'], $donnees['name_equip'], $donnees['brand_equip'], $donnees['version_equip']);
            $queryPhotos = "SELECT link_photo FROM stock_photo WHERE ref_equip LIKE ?; ";
            $myStatement1 = $con->prepare($queryPhotos);
            $myStatement1->execute([$refEquipment]);
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

            if ($equipment != null) {
                $this->_equipment = $equipment;
            } else {
                throw new Exception("Exception Equipment Controller: Invalid refEquipment");
            }
        } else {
            throw new Exception("Exception Equipment Controller: Invalid refEquipment");
        }
    }

    public function reserveEquipment($dateFinBorrow, $quantite_equip)
    {
        try {
            if (Functions::checkReservationDate($dateFinBorrow) && Functions::checkQuantityEquipment($quantite_equip)) {
                if ($this->_equipment->howMuchAvailable() >= $quantite_equip && $quantite_equip > 0) {
                    $currentUser = new UserRegular();
                    $currentUser->loadUser();
                    if ($currentUser->borrowEquipement($this->_equipment->getRefEquip(), $dateFinBorrow, $quantite_equip)) {
                        echo "<p> Reservation effectuée </p>";
                        header("Refresh:1");


                    }
                } else {
                    echo "<p> Quantité demandée indisponible ou invalide </p>";
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();

        }
    }

    public function modifyEquipment($ref_equip, $type_equip, $nom_equip, $marque_equip, $version_equip, $quantite_equip, $currentUser)
    {

        try {
            if (Functions::checkRefEquip($ref_equip) && $this->isRefEquipUsed($ref_equip) == false && Functions::checkNameMateriel($nom_equip)
                && Functions::checkBrandEquip($marque_equip) && Functions::checkTypeEquip($type_equip)
                && Functions::checkVersionMateriel($version_equip) && Functions::checkQuantityEquipment($quantite_equip)) {

                if ($this->_equipment->howMuchAvailable() != $quantite_equip) {
                    $currentUser = new UserAdmin();
                    $currentUser->loadUser();
                    $currentUser->updateDeviceCount($this->_equipment->getRefEquip(), $quantite_equip);
                }

                $currentUser->modifyEquipment($this->_equipment->getRefEquip(), $ref_equip, $type_equip, $marque_equip, $nom_equip, $version_equip);


            }
        } catch (Exception | PDOException $e) {
            throw new Exception($e->getMessage());

        }
    }

    public function createNewEquipment($currentUser)
    {
        $currentUser = new UserAdmin();
        $currentUser->loadUser();
        $currentUser->createEquipment($this->ref, $this->type, $this->brand, $this->name, $this->version, $this->quantity);
    }

    public function isRefEquipUsed($ref): bool
    {
        if ($ref != $this->_equipment->getRefEquip()) {
            $bdd = new DataBase();
            $con = $bdd->getCon();
            $query = "select count(*) as 'somme' from equipment where ref_equip like ? ;";
            $stmt = $con->prepare($query);
            $stmt->execute([$ref]);
            $result = $stmt->fetch();
            $bdd->closeCon();

            if ($result['somme'] >= 1) {
                throw new Exception("Ref equipment is already used");
            } else {
                return false;
            }

        }

        return false;
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