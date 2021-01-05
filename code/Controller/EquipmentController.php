<?php
require_once("ControllerDAO/EquipmentDAO.php");
require_once("Model/Equipment.php");

/**
 * Class EquipmentController
 */
class EquipmentController
{

    /**
     * @var Equipment
     */
    private $_equipment;

    /**
     * @var array
     */
    private $_photosArray = array();

    /**
     * EquipmentController constructor.
     * @param $refEquipment
     * @throws Exception
     */
    public function __construct(){}

    public function loadEquipmentFromDDB(int $refEquipment)
    {
        $this->_equipment = EquipmentDAO::initEquipmentController($refEquipment);
    }

    public function loadEquipmentFromObject(Equipment $equipment)
    {
        $this->_equipment = $equipment;
    }
    
    /**
     * @param $ref_equip
     * @param $type_equip
     * @param $nom_equip
     * @param $marque_equip
     * @param $version_equip
     * @param $quantite_equip
     * @param $currentUser
     * @throws Exception
     */
    public function modifyEquipment($ref_equip, $type_equip, $nom_equip, $marque_equip, $version_equip, $quantite_equip, $currentUser)
    {

        try {
            if (Functions::checkRefEquip($ref_equip) && EquipmentDAO::isRefEquipUsed($ref_equip, $this->_equipment) == false && Functions::checkNameMateriel($nom_equip)
                && Functions::checkBrandEquip($marque_equip) && Functions::checkTypeEquip($type_equip)
                && Functions::checkVersionMateriel($version_equip) && Functions::checkQuantityEquipment($quantite_equip)) {
                if (EquipmentDAO::howMuchAvailable($this->_equipment->getRefEquip()) != $quantite_equip) {
                    EquipmentDAO::updateDeviceCount($this->_equipment->getRefEquip(), $quantite_equip);
                }
                EquipmentDAO::modifyEquipment($this->_equipment->getRefEquip(), $ref_equip, $type_equip, $marque_equip, $nom_equip, $version_equip);
            }
        } catch (Exception | PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param $ref_equip
     * @param $type_equip
     * @param $marque_equip
     * @param $nom_equip
     * @param $version_equip
     * @param $quantity_equip
     * @throws Exception
     */
    public function createNewEquipment($Quantity)
    {
        try {
            if (Functions::checkRefEquip($this->_equipment->getRefEquip()) && EquipmentDAO::isNewRefEquipUsed($this->_equipment->getRefEquip()) == false && Functions::checkNameMateriel($this->_equipment->getNameEquip())
                && Functions::checkBrandEquip($this->_equipment->getBrandEquip()) && Functions::checkTypeEquip($this->_equipment->getTypeEquip())
                && Functions::checkVersionMateriel($this->_equipment->getVersionEquip()) && Functions::checkQuantityEquipment($Quantity)) {
                EquipmentDAO::createEquipment($this->_equipment->getRefEquip(), $this->_equipment->getTypeEquip(), $this->_equipment->getBrandEquip(), $this->_equipment->getNameEquip(), $this->_equipment->getVersionEquip(), $Quantity);
            }
        } catch (Exception | PDOException $e) {
            throw new Exception($e->getMessage());
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
        return $this->_photosArray;
    }

    /**
     * @param mixed $equipment
     */
    public function setEquipment($equipment): void
    {
        $this->_equipment = $equipment;
    }

    /**
     * @param array $_photosArray
     */
    public function setPhotosArray(array $_photosArray): void
    {
        $this->_photosArray = $_photosArray;
    }
}