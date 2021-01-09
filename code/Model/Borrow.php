
<?php

/**
 * Class Borrow
 * Class representing a Borrow from a user
 *
 * @author Alhabaj Mahmod, Anica Sean, Belda Tom, Ingarao Adrien, Maggouh Naoufal, Ung Alexandre
 */
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
    public function __construct($_ref_equip, $_end_date)
    {
        $this->_ref_equip = $_ref_equip;
        $this->_end_date = $_end_date;
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

