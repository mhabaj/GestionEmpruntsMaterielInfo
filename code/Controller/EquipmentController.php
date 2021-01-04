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

        if ($donnees['ref_equip'] != null)
        {
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
        try
        {
            if (Functions::checkReservationDate($dateFinBorrow) && Functions::checkQuantityEquipment($quantite_equip))
            {
                $currentUser = MainDAO::getUser($_SESSION['id_user']);
                if (MainDAO::howMuchAvailable($this->_equipment->getRefEquip()) >= $quantite_equip && $quantite_equip > 0)
                {
                    date_default_timezone_set('Europe/Paris');
                    $currentDateTime = date('Y/m/d');
                    $start_date = $currentDateTime;

                    $indexOf = 0;
                    while ($indexOf < $quantite_equip)
                    {
                        $newBorrow = new Borrow($this->_equipment->getRefEquip(), $dateFinBorrow);
                        MainDAO::startBorrow($this->_equipment->getRefEquip(),$start_date,$dateFinBorrow);

                        $currentUser->addBorrowToList($newBorrow);
                        $indexOf += 1;
                    }
                    echo "<p> Reservation effectuée </p>";
                    header("Refresh:1");
                    return true;
                }
                else
                {
                    echo "<p> Quantité demandée indisponible ou invalide </p>";
                    return false;
                }
            }
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            return false;
        }
    }

    public function modifyEquipment($ref_equip, $type_equip, $nom_equip, $marque_equip, $version_equip, $quantite_equip)
    {

        try {
            if (Functions::checkRefEquip($ref_equip) && $this->isRefEquipUsed($ref_equip) == false && Functions::checkNameMateriel($nom_equip)
                && Functions::checkBrandEquip($marque_equip) && Functions::checkTypeEquip($type_equip)
                && Functions::checkVersionMateriel($version_equip) && Functions::checkQuantityEquipment($quantite_equip)) {

                if (MainDAO::howMuchAvailable($this->_equipment->getRefEquip()) != $quantite_equip) {

                    MainDAO::updateDeviceCount($this->_equipment->getRefEquip(), $quantite_equip);
                }

                MainDAO::modifyEquipment($this->_equipment->getRefEquip(), $ref_equip, $type_equip, $marque_equip, $nom_equip, $version_equip);
            }
        } catch (Exception | PDOException $e) {
            throw new Exception($e->getMessage());

        }
    }

    public function createNewEquipment($ref_equip, $type_equip, $marque_equip, $nom_equip, $version_equip, $quantite_equip)
    {

        try {
            if (Functions::checkRefEquip($ref_equip) && $this->isNewRefEquipUsed($ref_equip) == false && Functions::checkNameMateriel($nom_equip)
                && Functions::checkBrandEquip($marque_equip) && Functions::checkTypeEquip($type_equip)
                && Functions::checkVersionMateriel($version_equip) && Functions::checkQuantityEquipment($quantite_equip)) {

                MainDAO::createEquipment($ref_equip, $type_equip, $marque_equip, $nom_equip, $version_equip, $quantite_equip);
            }
        } catch (Exception | PDOException $e) {
            throw new Exception($e->getMessage());

        }


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
            } else
            {
                return false;
            }

        }
        return false;
    }

    public function isNewRefEquipUsed($ref): bool
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $query = "select count(*) as 'somme' from equipment where ref_equip like ? ;";
        $stmt = $con->prepare($query);
        $stmt->execute([$ref]);
        $result = $stmt->fetch();
        $bdd->closeCon();

        if ($result['somme'] >= 1) {
            throw new Exception("Ref equipment is already used");
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

    /**
     * @param mixed $equipment
     */
    public function setEquipment($equipment): void
    {
        $this->_equipment = $equipment;
    }

    /**
     * @param array $photosArray
     */
    public function setPhotosArray(array $photosArray): void
    {
        $this->photosArray = $photosArray;
    }
}