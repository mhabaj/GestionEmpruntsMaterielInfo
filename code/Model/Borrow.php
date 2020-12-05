<?php

class Borrow
{
    private $_id_borrow;
    private $_ref_equip;
    private $_device_id;
    private $_start_date;
    private $_end_date;


    /**
     * @return mixed
     */
    public function getIdBorrow()
    {
        return $this->_id_borrow;
    }

    /**
     * @param mixed $id_borrow
     */
    public function setIdBorrow($id_borrow): void
    {
        $this->_id_borrow = $id_borrow;
    }
    /**
     * Borrow constructor.
     * @param $_ref_equip
     * @throws Exception
     */

    public function __construct($_ref_equip,$_end_date)
    {
        $this->_ref_equip = $_ref_equip;
        $this->_end_date = $_end_date;
        $date =  date("d/m/Y");
        $this->_start_date = $date;

        $bdd = new DataBase();
        $con = $bdd->getCon();

        $requestSelect = "SELECT id_device FROM DEVICE WHERE isAvailable = TRUE AND ref_equip = '$this->_ref_equip';";
        $answerSelect = $con->query($requestSelect);
        $resultSelect = $answerSelect->fetch();

        $this->_device_id = $resultSelect['id_device'];

        if ($this->startBorrow($this->_end_date) == False)
            throw new Exception('Erreur Création Borrow');

    }

    public function startBorrow($_end_date)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $con->beginTransaction();
        try
        {
            $requestUpdate = "UPDATE DEVICE SET isAvailable = FALSE WHERE id_device = '$this->_device_id';";
            $con->query($requestUpdate);

            $requestInsert = "INSERT INTO borrow_info (startdate_borrow, enddate_borrow, isActive) VALUES ('$this->_start_date', ? , TRUE); ";
            $myStatement = $con->prepare($requestInsert);
            $myStatement->execute([$_end_date]);
            $this->_id_borrow = $con->lastInsertId("id_borrow");

            $requestInsert1 = "INSERT INTO borrow (id_user, id_device, id_borrow) VALUES ('$_SESSION[id_user]', '$this->_device_id' , '$this->_id_borrow');";
            $con->query($requestInsert1);

            $con->commit();
            return TRUE;
        }
        catch(PDOException $e)
        {
            $con->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
            return FALSE;
        }
    }

    public function endBorrow()
    {
        $date =  date("d/m/Y");
        $this->_end_date = $date;

        $bdd = new DataBase();
        $con = $bdd->getCon();

        $con->beginTransaction();
        try
        {
            $requestUpdate = "UPDATE DEVICE SET isAvailable = 1 WHERE id_device = '$this->_device_id';";
            $con->query($requestUpdate);

            $requestUpdate2 = "UPDATE borrow_info SET enddate_borrow = '$this->_end_date',isActive = 0 WHERE id_borrow = '$this->_id_borrow';";
            $con->query($requestUpdate);
            return TRUE;
        }
        catch(PDOException $e)
        {
            $con->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
            return FALSE;
        }
    }


}

