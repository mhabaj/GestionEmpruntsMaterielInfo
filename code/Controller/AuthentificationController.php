<?php


class AuthentificationController
{

    private $_matriculeUser;
    private $_password;

    public function __construct($matriculeUser, $password)
    {
        $this->_matriculeUser = $matriculeUser;
        $this->_password = $password;
    }

    public function isAdmin()
    {

        $bdd = new DataBase();
        $con = $bdd->getCon();

        //Inserer valeurs
        $requete = "SELECT * FROM users WHERE matricule_user = ? ;";
        $stmt = $con->prepare($requete);
        $stmt->execute([$this->_matriculeUser]);
        $result = $stmt->rowCount();

        if ($result == 1) {
            $infoUser = $stmt->fetch();
            $bdd->closeCon();
            return $infoUser['isAdmin_user'];
        } else {
            $bdd->closeCon();
            throw new Exception("User not found");
        }
    }

    public function identification()
    {

        try {
            if ($this->isAdmin() == 1) {
                $newUserAdmin = new UserAdmin();
                $newUserAdmin->setMatriculeUser($this->_matriculeUser);
                $newUserAdmin->setPassword($this->_password);
                if ($newUserAdmin->connect() == true) {
                    $newUserAdmin->loadUser();
                    $_SESSION['User'] = $newUserAdmin;
                    $_SESSION['isAdmin_user'] = 1;
                    header('Location: Catalogue.php');
                }
            } else {
                $newUserRegular = new UserRegular();
                $newUserRegular->setMatriculeUser($this->_matriculeUser);
                $newUserRegular->setPassword($this->_password);
                if ($newUserRegular->connect() == true) {
                    $newUserRegular->loadUser();
                    $_SESSION['User'] = $newUserRegular;
                    $_SESSION['isAdmin_user'] = 0;
                    header('Location: Catalogue.php');
                }
            }

        } catch (Exception $e) {
            echo("<p>Invalide User credentials</p>");
        }
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
    public function setPassword($password): void
    {
        $this->_password = $password;
    }
}
