<?php

include "../Controller/DataBase.php";
include "Borrow.php";
class User
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
     * @param mixed $borrowList
     */
    public function addBorrowToList($BorrowItem)
    {
        //array_push($this->_borrowList,$ref_equip_toBorrow);
        $this->_borrowList[] = $BorrowItem;
    }

    /**
     * @param $ref_equip_toBorrow
     * @param $dateFin
     * @return false
     */
    public function borrowEquipement($ref_equip_toBorrow, $dateFin){
        try {
            $newBorrow = new Borrow($ref_equip_toBorrow, $dateFin);
        } catch (Exception $e) {
            return False;
        }

    }

    /**
     * @param $id_borrow
     */
    public function endborrow($id_borrow){
        $cpt_array = 0;
        foreach($this->_borrowList as $borrow):
            if($borrow->getIdBorrow() == $id_borrow ){
                $borrow->endBorrow();
                unset($this->_borrowList[$cpt_array]);
                break;
            }
            $cpt_array+=1;
        endforeach;

    }

    public function __construct(){
        //$id = connect();
        $this->setIdUser(1);

        $bdd = new DataBase();
        $con = $bdd->getCon();
        $query = "SELECT * FROM users WHERE id_user = ?";
        $stmt = $con->prepare($query);
        $stmt->execute([$this->_idUser]);
        $result = $stmt->fetch();
        $this->setEmail($result['email_user']);
        $this->setMatriculeUser($result['matricule_user']);
        $this->setPassword($result['password_user']);
        $this->setName($result['name_user']);
        $this->setLastName($result['lastname_user']);
        $this->setPhone($result['phone_user']);
        $this->_borrowList->
        $bdd->closeCon();
    }

    public function connect() {

        $bdd = new DataBase();
        $con = $bdd->getCon();

        //Hashage du mdp
        $hash_mdp = sha1($this->_password);

        //Inserer valeurs
        $requete = "SELECT * FROM users WHERE matricule_user = ? AND password_user= ?";
        $stmt = $con->prepare($requete);
        $stmt->execute([$this->_matriculeUser, $hash_mdp]);
        $result = $stmt->rowCount();

        if($result == 1) {
            session_start();
            $infoUser = $stmt->fetch();
            $_SESSION['id_user'] = $infoUser['id_user'];
            $this->_idUser = $infoUser;
            $bdd->closeCon();
            return TRUE;
            //redirect('training.php'); A METTRE DANS LE CONTROLLER
        } else {
            $bdd->closeCon();
            return FALSE;
        }
    }
    public function disconnect() {
        session_unset();
        session_destroy();
        return TRUE;
    }

    public function update(){
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $query = "UPDATE users SET email_user = ?, matricule_user = ?, password_user = ?, name_user = ?, lastname_user = ?, phone_user = ? where users.id_user = ?";
        try {
            $con->beginTransaction();
            $stmt = $con->prepare($query);
            $stmt->execute([$this->getEmail(), $this->getMatriculeUser(), $this->getPassword(), $this->getName(), $this->getLastName(), $this->getPhone(), $this->_idUser]);
            $con->commit();
        } catch(PDOException $e) {
            $con->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
        $bdd->closeCon();
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