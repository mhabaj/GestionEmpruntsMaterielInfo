<?php

require_once("Controller/Database.php");

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

    public function howMuchAvailable()
    {
        $bdd= new DataBase();
        $con= $bdd->getCon();
        $query = "select count(*) as 'somme' from device INNER JOIN equipment on device.ref_equip Like equipment.ref_equip where device.ref_equip like ? and isAvailable = 1; ";
        $stmt=$con->prepare($query);
        $stmt->execute([$this->_ref_equip]);
        $result=$stmt->fetch();
        $bdd->closeCon();
        return $result['somme'];
    }


    /**
     * @return String RefEquip
     */
    public function getRefEquip()
    {
        return $this->_ref_equip;
    }

    /**
     * @param String $ref_equip
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

    public function isRefEquipValid()
    {
        if (strlen($this->_ref_equip)) {
            $bdd = new DataBase();
            $con = $bdd->getCon();
            $query = ("select count(*) as 'somme' from equipment where ref_equip like ? ;");
            $stmt=$con->prepare($query);
            $stmt->execute([$this->_ref_equip]);
            $result=$stmt->fetch();
            $bdd->closeCon();
            if($result['somme'] > 0){
                return true;
            }

        }
        return false;
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











