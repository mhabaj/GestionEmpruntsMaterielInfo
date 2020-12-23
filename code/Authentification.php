<?php
require_once("Controller/DataBase.php");
require_once("Model/User.php");
require_once("Model/UserRegular.php");
require_once("Model/UserAdmin.php");

if(!isset($_SESSION['id_user']))
{
    Class AuthentificationController
{

    private $_matriculeUser;
    private $_password;

    public function  __construct($matriculeUser, $password)
    {
        $this->_matriculeUser = $matriculeUser;
        $this->_password = $password;
    }

    public function isAdmin(){

        $bdd = new DataBase();
        $con = $bdd->getCon();

        //Inserer valeurs
        $requete = "SELECT * FROM users WHERE matricule_user = ? ;";
        $stmt = $con->prepare($requete);
        $stmt->execute([$this->_matriculeUser]);
        $result = $stmt->rowCount();

        if($result == 1) {
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
                $newUserAdmin->setPassword( $this->_password);
                if($newUserAdmin->connect() == true){
                    $newUserAdmin->loadUser();
                    $_SESSION['User'] = $newUserAdmin;
                    $_SESSION['isAdmin_user'] = 1;
                    header('Location: Catalogue.php');
                }
             }else{
                 $newUserRegular = new UserRegular();
                 $newUserRegular->setMatriculeUser($this->_matriculeUser);
                 $newUserRegular->setPassword( $this->_password);
                 if($newUserRegular->connect() == true){
                     $newUserRegular->loadUser();
                     $_SESSION['User'] = $newUserRegular;
                     $_SESSION['isAdmin_user'] = 0;
                     header('Location: Catalogue.php');
                 }
             }

         }catch (Exception $e){
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

?>
<html>


    <body>

        <form method="POST" enctype="multipart/form-data">
            <h1>Connexion</h1>

            <label><b>Nom d'utilisateur</b></label>
            <input type="text" placeholder="Entrer le nom d'utilisateur" name="matricule" required>

            <label><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrer le mot de passe" name="password" required>


            <button type="submit" name="submitLogin">Connexion</button>


        </form>



    </body>


</html>


<?php


    if(isset($_POST['submitLogin'])){

     if(!isset($_SESSION['id_user'])) {
           $matricule = $_POST['matricule'];
           $password = $_POST['password'];

           if(strlen($matricule) == 7){
             $authCont = new AuthentificationController($matricule, $password);
              $authCont->identification();
           }

       }else{
            header('Location: Catalogue.php');
        }
    }
}else{
    header('Location: Catalogue.php');
}

?>