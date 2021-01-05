<?php
require_once("Functions.php");

class UserController
{
    private $_user;

    public function __construct($id)
    {
        $this->_user = UserDAO::getUserByID($id);
    }

    public function disconnect()
    {
        session_unset();
        session_destroy();
        return TRUE;
    }

    /**
     * @param $ref_equip_toBorrow
     * @param $dateFin
     * @param $quantity
     * @return bool Object, else null
     * PREC : quantity > 0
     */
    public function startBorrow($ref_equip_toBorrow, $dateFin, $quantity)
    {
        try {
            $indexOf = 0;
            while ($indexOf < $quantity) {
                $newBorrow = BorrowDAO::startBorrow($ref_equip_toBorrow, $dateFin);
                $this->_user->addBorrowToList($newBorrow);
                $indexOf += 1;
            }
            return true;
        } catch (Exception $e) {
            throw new Exception("Exception User: couldn't borrow Equipment\n");
        }
    }

    public function endborrow($id_borrow_toDel)
    {
        $cpt_array = 0;
        foreach ($this->_user->getBorrowList() as $borrow):
            if ($borrow->getIdBorrow() == $id_borrow_toDel) {
                BorrowDAO::stopBorrow($borrow->getIdBorrow(), $borrow->getDeviceId());
                unset($this->_user->getBorrowList()[$cpt_array]);
                break;
            }
            $cpt_array += 1;
        endforeach;
    }

    /**
     * renvoie un statement? de l'historique de l'utilisateur
     * @param $id_user_toDisplay
     */
    public function getHistory($id_user_toDisplay)
    {
        try{
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
        }
    }

	public function createUser($matricule,$password,$passwordRepeat,$email,$lastname,$name,$phone,$isAdmin)
    {
        if ($passwordRepeat != $password)
        {
            throw new Exception("Les deux mots de passe ne correspondent pas !");
        }

        try
        {
            if (Functions::checkMatricule($matricule) == true && Functions::checkMail($email) == true && Functions::checkPhoneNumber($phone) == true && Functions::checkNameUser($lastname) == true && Functions::checkFirstNameUser($name) == true)
            {
                if ($isAdmin == 'ok')
                    $isAdmin = 1;
                else
                    $isAdmin = 0;

                UserDAO::createUser($matricule,$email,$password,$name,$lastname,$phone,$isAdmin);
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

                UserDAO::modifyUser($id, $matricule, $email, $name, $lastname, $phone, $isAdmin);
                return true;
            }
            else
                return false;
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
                UserDAO::changeUserPassword($this->_user, $password);
                header('Location: DetailUser.php?id_user_toDisplay='.$this->_user->getIdUser());
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
        }
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->_user;
    }

}