<?php
require_once("Functions.php");
require_once("ControllerDAO/BorrowDAO.php");
require_once ("ControllerDAO/UserDAO.php");

/**
 * Class UserController
 */
class UserController
{
    /**
     * @var User|null
     */
    private $_user;

    /**
     * UserController constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->_user = UserDAO::getUserByID($id);
    }

    /**
     * @return bool
     */
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

    /**
     * @param $id_borrow_toDel
     * @throws Exception
     */
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
     * @param $matricule
     * @param $password
     * @param $passwordRepeat
     * @param $email
     * @param $lastname
     * @param $name
     * @param $phone
     * @param $isAdmin
     * @return bool
     * @throws Exception
     */
    public function createUser($matricule, $password, $passwordRepeat, $email, $lastname, $name, $phone, $isAdmin)
    {
        if ($passwordRepeat != $password) {
            throw new Exception("Les deux mots de passe ne correspondent pas !");
        }

        try {
            if (Functions::checkMatricule($matricule) == true && Functions::checkMail($email) == true && Functions::checkPhoneNumber($phone) == true && Functions::checkNameUser($lastname) == true && Functions::checkFirstNameUser($name) == true) {
                if ($isAdmin == 'ok')
                    $isAdmin = 1;
                else
                    $isAdmin = 0;

                UserDAO::createUser($matricule, $email, $password, $name, $lastname, $phone, $isAdmin);
                return true;
            } else
                return false;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }


    /**
     * @param $id
     * @param $matricule
     * @param $email
     * @param $lastname
     * @param $name
     * @param $phone
     * @param $isAdmin
     * @return bool
     * @throws Exception
     */
    public function modifyUser($id, $matricule, $email, $lastname, $name, $phone, $isAdmin): bool
    {

        if (Functions::checkMatricule($matricule) == true && Functions::checkMail($email) == true && Functions::checkPhoneNumber($phone) == true && Functions::checkNameUser($lastname) == true && Functions::checkFirstNameUser($name) == true) {

            if ($isAdmin == 'ok')
                $isAdmin = 1;
            else
                $isAdmin = 0;

            UserDAO::modifyUser($id, $matricule, $email, $name, $lastname, $phone, $isAdmin);
            return true;
        } else
            return false;

    }

    /**
     * @param $password
     * @param $passwordRepeat
     * @return bool
     */
    public function modifyPassword($password, $passwordRepeat)
    {
        if ($password == '' || $password == null) {
            return false;
        }
        try {
            if ($password == $passwordRepeat) {
                UserDAO::changeUserPassword($this->_user, $password);

                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
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