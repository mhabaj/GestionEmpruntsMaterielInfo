<?php

require_once "Controller/DataBase.php";
require_once "Model/Borrow.php";
require_once "Controller/MainDAO.php";

abstract class User
{
    protected $_idUser;
    protected $_matriculeUser;
    protected $_email;
    protected $_password;
    protected $_name;
    protected $_lastName;
    protected $_phone;
    protected $_privilege;
    protected $_borrowList = array();

    /**
     * User constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param $BorrowItem
     */
    public function addBorrowToList($BorrowItem)
    {
        array_push($this->_borrowList, $BorrowItem);
    }

    public function delBorrowToList($idToDel)
    {
        unset($this->_borrowList[$idToDel]);
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
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->_name = $name;
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
    /**
     * @return mixed
     */
    public function getPrivilege()
    {
        return $this->_privilege;
    }

    /**
     * @param mixed $privilege
     */
    public function setPrivilege($privilege): void
    {
        $this->_privilege = $privilege;
    }


}
/*
$user = new User();

echo $user->getName() ." ";
echo $user->getLastName() ." ";
echo $user->getEmail() ."</br>";

$user->setName("tom");
$user->update();

echo $user->getName() ." ";
echo $user->getLastName() ." ";
echo $user->getEmail();
*/