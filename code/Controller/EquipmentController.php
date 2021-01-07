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
     * @var EquipmentDAO
     */
    private $_equipmentDAO;


    /**
     * EquipmentController constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->_equipmentDAO = new EquipmentDAO();
    }

    /**
     * @param string $refEquipment
     * @throws Exception
     */
    public function loadEquipmentFromDDB(string $refEquipment)
    {
        $this->_equipment = $this->_equipmentDAO->initEquipmentController($refEquipment);
    }

    /**
     * @param Equipment $equipment
     */
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
     * @param $quantity_equip
     * @throws Exception
     */
    public function modifyEquipment($ref_equip, $type_equip, $nom_equip, $marque_equip, $version_equip, $quantity_equip)
    {

        try {
            if (Functions::checkRefEquip($ref_equip) && $this->_equipmentDAO->isRefEquipUsed($ref_equip, $this->_equipment) == false && Functions::checkNameMateriel($nom_equip)
                && Functions::checkBrandEquip($marque_equip) && Functions::checkTypeEquip($type_equip)
                && Functions::checkVersionMateriel($version_equip) && Functions::checkQuantityEquipment($quantity_equip)) {
                if ($this->_equipmentDAO->howMuchAvailable($this->_equipment->getRefEquip()) != $quantity_equip) {
                    $this->_equipmentDAO->updateDeviceCount($this->_equipment->getRefEquip(), $quantity_equip);

                }
                $this->_equipmentDAO->modifyEquipment($this->_equipment->getRefEquip(), $ref_equip, $type_equip, $marque_equip, $nom_equip, $version_equip);

                $this->_equipment->setRefEquip($ref_equip);
                $this->_equipment->setTypeEquip($type_equip);
                $this->_equipment->setNameEquip($nom_equip);
                $this->_equipment->setBrandEquip($marque_equip);
                $this->_equipment->setVersionEquip($version_equip);


            }
        } catch (Exception | PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param $Quantity
     * @throws Exception
     */
    public function createNewEquipment(int $Quantity)
    {
        try {
            if (Functions::checkRefEquip($this->_equipment->getRefEquip()) && $this->_equipmentDAO->isNewRefEquipUsed($this->_equipment->getRefEquip()) == false && Functions::checkNameMateriel($this->_equipment->getNameEquip())
                && Functions::checkBrandEquip($this->_equipment->getBrandEquip()) && Functions::checkTypeEquip($this->_equipment->getTypeEquip())
                && Functions::checkVersionMateriel($this->_equipment->getVersionEquip()) && Functions::checkQuantityEquipment($Quantity)) {
                $this->_equipmentDAO->createEquipment($this->_equipment->getRefEquip(), $this->_equipment->getTypeEquip(), $this->_equipment->getBrandEquip(), $this->_equipment->getNameEquip(), $this->_equipment->getVersionEquip(), $Quantity);
                return true;
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

    /**
     * @return EquipmentDAO
     */
    public function getEquipmentDAO(): EquipmentDAO
    {
        return $this->_equipmentDAO;
    }

    /**
     * @param EquipmentDAO $equipmentDAO
     */
    public function setEquipmentDAO(EquipmentDAO $equipmentDAO): void
    {
        $this->_equipmentDAO = $equipmentDAO;
    }

}