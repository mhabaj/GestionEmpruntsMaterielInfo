<?php

require("../Controller/Database.php");

class Equipment
{
    private $_ref_equip;
    private $_type_equip;
    private $_name_equip;
    private $_brand_equip;
    private $_version_equip;

    /**
     * Equipment constructor.
     * @param $_ref_equip
     * @param $_type_equip
     * @param $_name_equip
     * @param $_brand_equip
     * @param $_version_equip
     */
    public function __construct($_ref_equip, $_type_equip, $_name_equip, $_brand_equip, $_version_equip)
    {
        $this->_ref_equip = $_ref_equip;
        $this->_type_equip = $_type_equip;
        $this->_name_equip = $_name_equip;
        $this->_brand_equip = $_brand_equip;
        $this->_version_equip = $_version_equip;
    }


    /**
     * @return String RefEquip
     */
    public function getRefEquip()
    {
        return $this->_ref_equip;
    }

    /**
     * @param $ref_equip
     */
    public function setRefEquip($ref_equip)
    {
        $this->_ref_equip = $ref_equip;
    }

    /**
     * @return String type_equip
     */
    public function getTypeEquip()
    {
        return $this->_type_equip;
    }

    /**
     * @param $type_equip
     */
    public function setTypeEquip($type_equip)
    {
        $this->_type_equip = $type_equip;
    }

    /**
     * @return String NameEquip
     */
    public function getNameEquip()
    {
        return $this->_name_equip;
    }

    /**
     * @param $name_equip
     */
    public function setNameEquip($name_equip)
    {
        $this->_name_equip = $name_equip;
    }

    /**
     * @return String BrandEquip
     */
    public function getBrandEquip()
    {
        return $this->_brand_equip;
    }

    /**
     * @param $brand_equip
     */
    public function setBrandEquip($brand_equip)
    {
        $this->_brand_equip = $brand_equip;
    }

    /**
     * @return String VersionEquip
     */
    public function getVersionEquip()
    {
        return $this->_version_equip;
    }

    /**
     * @param $version_equip
     */
    public function setVersionEquip($version_equip)
    {
        $this->_version_equip = $version_equip;
    }

}

$idUser = 1;
$mat = new Equipment('AX330','Tele','TV5042155','LG','10.4');
$mat->borrowDevice('21/07/2020');










