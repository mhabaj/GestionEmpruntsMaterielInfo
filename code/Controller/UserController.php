<?php
require_once("Functions.php");

class UserController
{
    private $_user;

    public function __construct()
    {

    }

    public function initUserController($id_userDisplay)
    {
        try
        {
            $currentUser = MainDAO::getUser($id_userDisplay);
            $this->_user = $currentUser;

            if($this->_user->getIdUser() == null)
            {
                throw new Exception('Mauvais ID Utilisateur');
            }
        }
        catch (Exception $e)
        {
            throw new Exception("Error!: " . $e->getMessage());
        }
    }

    public function returnBorrow($id_userDisplay,$id_borrow_toDel,$id_device_toDel)
    {
        try
        {
            $userToDisplay = MainDAO::getUser($id_userDisplay);

            date_default_timezone_set('Europe/Paris');
            $currentDateTime = date('Y/m/d');
            $end_date = $currentDateTime;

            $cpt_array = 0;
            foreach ($userToDisplay->getBorrowList() as $borrow):
                if ($borrow->getIdBorrow() == $id_borrow_toDel)
                {
                    MainDAO::stopBorrow($id_borrow_toDel,$id_device_toDel,$end_date);
                    $userToDisplay->delBorrowToList($cpt_array);
                    break;
                }
                $cpt_array += 1;
            endforeach;
            return true;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            return false;
        }
    }

    public function modifyPassword($password,$passwordRepeat)
    {
        try
        {
            if ($password == $passwordRepeat)
            {
                MainDAO::changePassword(($_GET['id_user_toDisplay']),$password);
                return true;
            }
            else
            {
                return false;
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            return false;
        }
    }

    public function modifyUser($id,$matricule,$email,$lastname,$name,$phone,$isAdmin)
    {
        try
        {
            if (Functions::checkMatricule($matricule) == true && Functions::checkMail($email) == true && Functions::checkPhoneNumber($phone) == true && Functions::checkNameUser($lastname) == true && Functions::checkFirstNameUser($name) == true)
            {

                if ($isAdmin == 'ok')
                    $isAdmin = 1;
                else
                    $isAdmin = 0;

                MainDAO::modifyAnyProfile($id, $matricule, $email, $name, $lastname, $phone, $isAdmin);
                return true;
            }
            else
                return false;
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * renvoie un statement? de l'historique de l'utilisateur
     * @param $id_user_toDisplay
     */
    public function getHistory($id_user_toDisplay)
    {
        try
        {
            $bdd = new DataBase();
            $con = $bdd->getCon();
            $queryUser="SELECT * FROM borrow_info INNER JOIN borrow ON borrow_info.id_borrow=borrow.id_borrow WHERE borrow.id_user=? AND borrow_info.isActive=0";
            $myStatement = $con->prepare($queryUser);
            $myStatement->execute([$_GET['id_user_toDisplay']]);

            return $myStatement;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            return null;
        }
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->_user = $user;
    }

}