<?php


/**
 * Class User
 */
class User
{
    /**
     * @var
     */
    private $_idUser;
    /**
     * @var
     */
    private $_matriculeUser;
    /**
     * @var
     */
    private $_email;
    /**
     * @var
     */
    private $_password;
    /**
     * @var
     */
    private $_firstName;
    /**
     * @var
     */
    private $_lastName;
    /**
     * @var
     */
    private $_phone;
    /**
     * @var array
     */
    private $_borrowList = array();
    /**
     * @var
     */
    private $_isAdmin;


    /**
     * User constructor.
     * @param $id
     * @param $email
     * @param $matricule
     * @param $password
     * @param $firstName
     * @param $lastName
     * @param $phone
     * @param $isAdmin
     */
    public function __construct(int $id =null, $email=null, $matricule=null, $password=null, $firstName=null, $lastName=null, $phone=null, $isAdmin=null)
    {
        if ($id == null && $email == null && $matricule == null && $password == null && $firstName== null && $lastName== null && $phone== null && $isAdmin== null)
        {
            $this->_idUser =null;
        }
        else {
            $this->setIdUser($id);
            $this->setEmail($email);
            $this->setMatriculeUser($matricule);
            $this->setPassword($password);
            $this->setFirstName($firstName);
            $this->setLastName($lastName);
            $this->setPhone($phone);
            $this->_isAdmin = $isAdmin;
        }
    }

    /**
     * @param $BorrowItem
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
    public function getBorrowList(): array
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
    public function getIsAdmin()
    {
        return $this->_isAdmin;
    }

    /**
     * @param mixed $isAdmin
     */
    public function setIsAdmin($isAdmin): void
    {
        $this->_isAdmin = $isAdmin;
    }


}