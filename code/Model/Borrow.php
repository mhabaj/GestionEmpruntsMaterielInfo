<?php

class Borrow
{
    private $_id_borrow;
    private $_ref_equip;
    private $_device_id;
    private $_start_date;
    private $_end_date;


    /**
     * Borrow constructor.
     * @param $_ref_equip
     * @param $_end_date
     */
    public function __construct($_ref_equip,$_end_date)
    {

        $this->_ref_equip = $_ref_equip;
        $this->_end_date = $_end_date;
    }


    public function startBorrow()
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $con->beginTransaction();
        try
        {
            date_default_timezone_set('Europe/Paris');
            $currentDateTime = date('Y/m/d');
            $this->_start_date = $currentDateTime;

            $bdd = new DataBase();
            $con = $bdd->getCon();

            $requestSelect = "SELECT id_device FROM DEVICE WHERE isAvailable = TRUE AND ref_equip = '$this->_ref_equip';";
            $answerSelect = $con->query($requestSelect);
            $resultSelect = $answerSelect->fetch();
            $this->_device_id = $resultSelect['id_device'];

            $requestUpdate = "UPDATE DEVICE SET isAvailable = FALSE WHERE id_device = '$this->_device_id';";
            $con->query($requestUpdate);

            $requestInsert = "INSERT INTO borrow_info (startdate_borrow, enddate_borrow, isActive) VALUES ('$this->_start_date', ? , TRUE); ";
            $myStatement = $con->prepare($requestInsert);
            $myStatement->execute([$this->_end_date]);
            $this->_id_borrow = $con->lastInsertId("id_borrow");

            $requestInsert1 = "INSERT INTO borrow (id_user, id_device, id_borrow) VALUES (?, '$this->_device_id' , '$this->_id_borrow');";
            $myStatement = $con->prepare($requestInsert1);
            $myStatement->execute([$_SESSION['id_user']]);


            $con->commit();
            return TRUE;
        }
        catch(PDOException $e)
        {
            $con->rollback();
            throw new PDOException('Erreur start Borrow');
        }
    }

    public function stopBorrow()
    {
        echo 'END BORROW';
        date_default_timezone_set('Europe/Paris');
        $currentDateTime = date('Y/m/d');
        $this->_end_date = $currentDateTime;

        $bdd = new DataBase();
        $con = $bdd->getCon();

        $con->beginTransaction();
        try
        {
            $requestUpdate = "UPDATE DEVICE SET isAvailable = 1 WHERE id_device = '$this->_device_id';";
            $con->query($requestUpdate);

            $requestUpdate2 = "UPDATE borrow_info SET enddate_borrow = '$this->_end_date',isActive = 0 WHERE id_borrow = '$this->_id_borrow';";
            $con->query($requestUpdate2);
            $con->commit();
            return TRUE;
        }
        catch(Exception $e)
        {
            $con->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
            return FALSE;
        }
    }

    /**
     * @return mixed
     */
    public function getIdBorrow()
    {
        return $this->_id_borrow;
    }

    /**
     * @return mixed
     */
    public function getRefEquip()
    {
        return $this->_ref_equip;
    }

    /**
     * @param mixed $ref_equip
     */
    public function setRefEquip($ref_equip)
    {
        $this->_ref_equip = $ref_equip;
    }

    /**
     * @return mixed
     */
    public function getDeviceId()
    {
        return $this->_device_id;
    }

    /**
     * @param mixed $device_id
     */
    public function setDeviceId($device_id)
    {
        $this->_device_id = $device_id;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->_start_date;
    }

    /**
     * @param mixed $start_date
     */
    public function setStartDate($start_date)
    {
        $this->_start_date = $start_date;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->_end_date;
    }

    /**
     * @param mixed $end_date
     */
    public function setEndDate($end_date)
    {
        $this->_end_date = $end_date;
    }

    /**
     * @param mixed $id_borrow
     */
    public function setIdBorrow($id_borrow)
    {
        $this->_id_borrow = $id_borrow;
    }



}

