<?php

require_once "Controller/DataBase.php";
require_once "Model/Borrow.php";

abstract class User
{
    protected $_idUser;
    protected $_matriculeUser;
    protected $_email;
    protected $_password;
    protected $_name;
    protected $_lastName;
    protected $_phone;
    protected $_borrowList = array();

    /**
     * User constructor.
     */
    public function __construct()
    {

    }


    /**
     * @param array $borrowList
     */
    public function addBorrowToList($BorrowItem)
    {
        array_push($this->_borrowList, $BorrowItem);
    }

    /**
     * @param $ref_equip_toBorrow
     * @param $dateFin
     * @param $quantity
     * @return bool Object, else null
     * PREC : quantity > 0
     */
    public function borrowEquipement($ref_equip_toBorrow, $dateFin, $quantity)
    {
        try {
            $indexOf = 0;
            while ($indexOf < $quantity) {
                $newBorrow = new Borrow($ref_equip_toBorrow, $dateFin);
                $newBorrow->startBorrow();
                $this->addBorrowToList($newBorrow);
                $indexOf += 1;
            }
            return true;
        } catch (Exception $e) {
            throw new Exception("Exception User: couldn't borrow Equipment\n");
        }
    }


    public function loadUser()
    {
        //$id = connect();
        //$this->setIdUser(1);
        $this->_idUser = $_SESSION['id_user'];

        $bdd = new DataBase();
        $con = $bdd->getCon();
        $query = "SELECT * FROM users WHERE id_user = ? ;";
        $stmt = $con->prepare($query);
        $stmt->execute([$this->_idUser]);
        $result = $stmt->fetch();
        $this->setEmail($result['email_user']);
        $this->setMatriculeUser($result['matricule_user']);
        $this->setPassword($result['password_user']);
        $this->setName($result['name_user']);
        $this->setLastName($result['lastname_user']);
        $this->setPhone($result['phone_user']);

        $myQuery = "SELECT borrow_info.id_borrow,startdate_borrow,enddate_borrow,isActive, borrow.id_device, device.ref_equip FROM borrow_info 
                    INNER JOIN borrow INNER JOIN device ON borrow.id_borrow= borrow_info.id_borrow AND borrow.id_device= device.id_device
                    WHERE borrow.id_user = '$this->_idUser';";
        $myStatement = $con->query($myQuery);
        $result = $myStatement->rowCount();
        $borrowLignes = $myStatement->fetchAll();

        if ($result == 0)
            $this->_borrowList = array();
        else {
            foreach ($borrowLignes as $borrow) {
                $BorrowItem = new Borrow($borrow['ref_equip'], $borrow['enddate_borrow']);
                $BorrowItem->setStartDate($borrow['startdate_borrow']);
                $BorrowItem->setDeviceId($borrow['id_device']);
                $BorrowItem->setIdBorrow($borrow['id_borrow']);
                array_push($this->_borrowList, $BorrowItem);
            }
        }
        $bdd->closeCon();
    }

    public function connect()
    {

        $bdd = new DataBase();
        $con = $bdd->getCon();

        //Hashage du mdp
        $hash_mdp = sha1($this->_password);

        //Inserer valeurs
        $requete = "SELECT * FROM users WHERE matricule_user = ? AND password_user= ? ;";
        $stmt = $con->prepare($requete);
        $stmt->execute([$this->_matriculeUser, $hash_mdp]);
        $result = $stmt->rowCount();

        if ($result == 1) {
            session_start();
            $infoUser = $stmt->fetch();
            $_SESSION['id_user'] = $infoUser['id_user'];
            $this->_idUser = $infoUser['id_user'];
            $this->loadUser();
            $bdd->closeCon();
            return TRUE;
        } else {
            $bdd->closeCon();
            return FALSE;
        }
    }

    public function disconnect()
    {
        session_unset();
        session_destroy();
        return TRUE;
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