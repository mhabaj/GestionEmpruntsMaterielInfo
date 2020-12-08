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

    /* PRECONDITION ON NE PEUT PAS DELETE DES DEVICES DONT LE CHAMP isAVAILABLE EST FALSE, $desiredQuantity ne peut pas etre < 0, */
    public function updateDeviceCount($_ref_equip,$desiredQuantity)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $requestCount = "SELECT COUNT(*) FROM DEVICE WHERE ref_equip = '$_ref_equip';";
        $answerCount = $con->query($requestCount);
        $resultCount = $answerCount->fetch();
        $numberOfDevices = $resultCount['COUNT(*)'];

        if ($numberOfDevices > $desiredQuantity)
        {
            $indexOf = 0;
            echo $numberOfDevices;
            echo $desiredQuantity;
            echo "avant";
            while($indexOf < ($numberOfDevices - $desiredQuantity))
            {
                echo $indexOf;
                $con->beginTransaction();
                try
                {
                    $requestDelete = "DELETE FROM device WHERE ref_equip = ? AND isAvailable = 1 LIMIT 1;";
                    $myStatement = $con->prepare($requestDelete);
                    $myStatement->execute([$_ref_equip]);
                    $con->commit();
                }
                catch(PDOException $e)
                {
                    $con->rollback();
                    throw new PDOException('Erreur update device count');
                }
                $indexOf++;
            }

        }
        elseif ($numberOfDevices < $desiredQuantity)
        {
            $indexOf = 0;
            while($indexOf < ($desiredQuantity - $numberOfDevices))
            {
                $con->beginTransaction();
                try
                {
                    $requestDelete = "INSERT INTO device(isAvailable,ref_equip) VALUES (1, ? ); ";
                    $myStatement = $con->prepare($requestDelete);
                    $myStatement->execute([$_ref_equip]);
                    $con->commit();
                }
                catch(PDOException $e)
                {
                    $con->rollback();
                    throw new PDOException('Erreur update device count');
                }
                $indexOf++;
            }

        }
        else
        {
            //rien à changer
        }
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











