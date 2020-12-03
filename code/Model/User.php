<?php
include("DataBase.php");

abstract class User
{
    protected $_idUser;
    protected $_matriculeUser;
    protected $_email;
    protected $_password;
    protected $_name;
    protected $_lastName;
    protected $_phone;

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
    public function getMatriculeUser()
    {
        return $this->_matriculeUser;
    }

    /**
     * @param mixed $matriculeUser
     */
    public function setMatriculeUser($matriculeUser): void
    {
        $this->_matriculeUser = $matriculeUser;
    }



    public function __construct(){


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
                $_SESSION['ID'] = $infoUser['ID_USER'];
                $_SESSION['PSEUDO'] = $infoUser['PSEUDO'];
                $User_ID = $infoUser;

                redirect('training.php');
            } else {

            }

    }




}