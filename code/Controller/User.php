<?php

include "DataBase.php";

class User
{
    protected $_idUser;
    protected $_matriculeUser;
    protected $_email;
    protected $_password;
    protected $_name;
    protected $_lastName;
    protected $_phone;
    protected $_idRole;

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
    public function getIdRole()
    {
        return $this->_idRole;
    }

    /**
     * @param mixed $idRole
     */
    public function setIdRole($idRole)
    {
        $this->_idRole = $idRole;
    }

    /**
     * @return mixed
     */
    public function getProfile()
    {
        return $this->_profile;
    }

    /**
     * @param mixed $profile
     */
    public function setProfile($profile)
    {
        $this->_profile = $profile;
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
        $this->setIdRole($result['id_role']);
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

    public function update(){
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $query = "UPDATE users SET email_user = ?,matricule_user = ?, password_user = ?, name_user = ?, lastname_user = ?, phone_user = ?, id_role = ?";
        try {
            $con->beginTransaction();
            $stmt = $con->prepare($query);
            $stmt->execute([$this->getEmail(), $this->getMatriculeUser(), $this->getPassword(), $this->getName(), $this->getLastName(), $this->getPhone(), $this->getIdRole()]);
            $con->commit();
        } catch(PDOExecption $e) {
            $con->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
    }
}

$user = new User();

echo $user->getName() ." ";
echo $user->getLastName() ." ";
echo $user->getEmail() ."<br>";
echo "Change nom -> Bob<br>";
$user->setName("tom");
$user->update();
echo $user->getName() ." ";
echo $user->getLastName() ." ";
echo $user->getEmail();