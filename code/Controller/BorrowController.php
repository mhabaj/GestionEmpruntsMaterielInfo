<?php
require_once(__DIR__ ."/../ControllerDAO/BorrowDAO.php");

/**
 * Class BorrowController
 *
 * @author Alhabaj Mahmod, Anica Sean, Belda Tom, Ingarao Adrien, Maggouh Naoufal, Ung Alexandre
 */
class BorrowController
{


    /**
     * @var BorrowDAO
     */
    private $_borrowDAO;


    /**
     * BorrowController constructor.
     */
    public function __construct()
    {
        $this->_borrowDAO = new BorrowDAO();

    }


    /**
     * @return BorrowDAO
     */
    public function getBorrowDAO(): BorrowDAO
    {
        return $this->_borrowDAO;
    }

    /**
     * @param BorrowDAO $borrowDAO
     */
    public function setBorrowDAO(BorrowDAO $borrowDAO): void
    {
        $this->_borrowDAO = $borrowDAO;
    }


}