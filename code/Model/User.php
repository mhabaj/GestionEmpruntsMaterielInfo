<?php

require_once "Controller/DataBase.php";
require_once "Model/Borrow.php";

class User
{
    protected $_idUser;
    protected $_matriculeUser;
    protected $_email;
    protected $_password;
    protected $_firstName;
    protected $_lastName;
    protected $_phone;
    protected $_borrowList = array();

    /**
     * User constructor.
     */
    public function __construct($id, $email, $matricule, $password, $firstName, $lastName, $phone)
    {
        $this->setIdUser($id);
        $this->setEmail($email);
        $this->setMatriculeUser($matricule);
        $this->setPassword($password);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setPhone($phone);
    }

    /**
     * @param array $borrowList
     */
    public function addBorrowToList($BorrowItem)
    {
        array_push($this->_borrowList, $BorrowItem);
    }

    /**
     * @return mixed
     */
    public function getMatriculeUser()
    {
        return $this->_matriculeUser;
    }

    /**
     * @param mixed $matriculeUser
     */
    public function setMatriculeUser($matriculeUser)
    {
        $this->_matriculeUser = $matriculeUser;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * @param mixed $name
     */
    public function setFirstName($name)
    {
        $this->_firstName = $name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->_lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->_lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->_idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->_idUser = $idUser;
    }

    /**
     * @return mixed
     */
    public function getBorrowList()
    {
        return $this->_borrowList;
    }

    /**
     * @param mixed $borrowList
     */
    public function setBorrowList($borrowList)
    {
        $this->_borrowList = $borrowList;
    }

}