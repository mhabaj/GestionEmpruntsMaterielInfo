<?php

include("Database.php");

class Equipment
{
    private $_ref_equip;
    private $_type_equip;
    private $_name_equip;
    private $_brand_equip;
    private $_version_equip;
    private $_img_equip;

    /**
     * @return mixed
     */
    public function getImgEquip()
    {
        return $this->_img_equip;
    }

    /**
     * @param mixed $img_equip
     */
    public function setImgEquip($img_equip)
    {
        $this->_img_equip = $img_equip;
    }

    /**
     * @return string
     */
    public function getDescEquip()
    {
        return $this->_desc_equip;
    }

    /**
     * @param string $desc_equip
     */
    public function setDescEquip($desc_equip)
    {
        $this->_desc_equip = $desc_equip;
    }
    private $_desc_equip;

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

    public function __construct($_ref_equip, $_name_equip, $_brand_equip, $_img_equip)
    {
        $this->setRefEquip($_ref_equip);
        $this->setNameEquip($_name_equip);
        $this->setBrandEquip($_brand_equip);
        $this->setImgEquip($_img_equip);
    }

    public function maximise(){
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $query = "SELECT * FROM equipment WHERE ref_equip = ?";
        $stmt = $con->prepare($query);
        $stmt->execute([$this->_ref_equip]);
        $result = $stmt->fetch();

        $this->setEmail($result['email_user']);
        $this->setTypeEquip($result['type_equip']);
        $this->setVersionEquip($result['version_equip']);
        //$this->setDescEquip($result['desc_equip']);
        closeCon();
    }

    public function borrowDevice($_enddate)
    {
        $date =  date("Y/m/d");

        // Connection à la base de donnees
        $bdd = new DataBase();
        $con = $bdd->getCon();


        $requestSelect = "SELECT id_device FROM DEVICE WHERE isAvailable = TRUE AND ref_equip = '$this->_ref_equip';";
        $answerSelect = $con->query($requestSelect);
        $resultSelect = $answerSelect->fetch();

        $id_device_tmp = $resultSelect['id_device'];

        $con->beginTransaction();
        try
        {
            $requestUpdate = "UPDATE DEVICE SET isAvailable = FALSE WHERE id_device = '$id_device_tmp';";
            $con->query($requestUpdate);
            $con->commit();
        }
        catch( PDOExecption $e )
        {
            $con->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }

        $con->beginTransaction();
        try
        {
            $requestInsert = "INSERT INTO borrow_info (startdate_borrow, enddate_borrow, isActive) VALUES ('$date', ? , TRUE); ";
            $myStatement = $con->prepare($requestInsert);
            $myStatement->execute([$_enddate]);
            $id_borrow_tmp = $con->lastInsertId("id_borrow");

            $requestInsert1 = "INSERT INTO borrow (id_user, id_device, id_borrow) VALUES ('$_SESSION[id_user]', '$id_device_tmp' , '$id_borrow_tmp');";
            $con->query($requestInsert1);

            $con->commit();
        }
        catch(PDOExecption $e)
        {
            $con->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
    }

}

$idUser = 1;
$mat = new Equipment('AX330','Tele','TV5042155','LG','10.4');
$mat->borrowDevice('21/07/2020');










