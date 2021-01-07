<?php
require_once("Functions.php");
require_once("ControllerDAO/BorrowDAO.php");
require_once("ControllerDAO/UserDAO.php");
require_once("EquipmentController.php");
require_once("BorrowController.php");

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
     * @var UserDAO
     */
    private $_userDAO;


    /**
     * UserController constructor.
     * @param int|null $id for userID or "void" for empty object
     */
    public function __construct(int $id = null)
    {
        if ($id == null) {
            $this->_userDAO = new UserDAO();
        } else {
            if (is_int($id)) {
                $this->_userDAO = new UserDAO();
                $this->_user = $this->_userDAO->getUserByID($id);
            }
        }
    }

    /**
     * @return bool
     */
    public function disconnect(): bool
    {
        session_unset();
        session_destroy();
        return TRUE;
    }

    /**
     * @param EquipmentController $equipmentController
     * @param $ref_equip_toBorrow
     * @param $dateFin
     * @param $quantity
     * @return bool Object, else null
     * PREC : quantity > 0 && reservation date after current server date
     * @throws Exception
     */
    public function startBorrow(EquipmentController $equipmentController, $ref_equip_toBorrow, $dateFin, $quantity): bool
    {
        if (Functions::checkReservationDate($dateFin) && Functions::checkQuantityEquipment($quantity)) {
            if ($equipmentController->getEquipmentDAO()->howMuchAvailable($ref_equip_toBorrow) >= $quantity && $quantity > 0) {

                $indexOf = 0;
                while ($indexOf < $quantity) {
                    $tmpBorrowController = new BorrowController();
                    $newBorrow = $tmpBorrowController->getBorrowDAO()->startBorrow($ref_equip_toBorrow, $dateFin);
                    $this->_user->addBorrowToList($newBorrow);
                    $indexOf += 1;
                }
                return true;

            }
        }
        return false;
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
                $tmpBorrowController = new BorrowController();
                $tmpBorrowController->getBorrowDAO()->stopBorrow($borrow->getIdBorrow(), $borrow->getDeviceId());
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
    public function createUser($matricule, $password, $passwordRepeat, $email, $lastname, $name, $phone, $isAdmin): bool
    {
        if ($passwordRepeat != $password) {
            throw new Exception("Les deux mots de passe ne correspondent pas !");
        }

        if ($this->_userDAO->matriculeUserExists($matricule) == false
            && Functions::checkMatricule($matricule) == true
            && Functions::checkMail($email) == true
            && Functions::checkPhoneNumber($phone) == true
            && Functions::checkNameUser($lastname) == true
            && Functions::checkFirstNameUser($name) == true) {


            $this->_userDAO->createUser($matricule, $email, $password, $name, $lastname, $phone, $isAdmin);
            return true;
        } else
            return false;


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
    public
    function modifyUser($id, $matricule, $email, $lastname, $name, $phone, $isAdmin): bool
    {

        if (Functions::checkMatricule($matricule) == true && Functions::checkMail($email) == true && Functions::checkPhoneNumber($phone) == true && Functions::checkNameUser($lastname) == true && Functions::checkFirstNameUser($name) == true) {

            if ($isAdmin == 'ok')
                $isAdmin = 1;
            else
                $isAdmin = 0;

            $this->_userDAO->modifyUser($id, $matricule, $email, $name, $lastname, $phone, $isAdmin);
            return true;
        } else
            return false;

    }

    /**
     * @param $password
     * @param $passwordRepeat
     * @return bool
     * @throws Exception
     */
    public
    function modifyPassword($password, $passwordRepeat): bool
    {
        if ($password == '' || $password == null) {
            return false;
        }

        if ($password == $passwordRepeat) {
            $this->_userDAO->changeUserPassword($this->_user, $password);

            return true;
        } else {
            return false;
        }


    }


    /**
     * @return mixed
     */
    public
    function getUser(): ?User
    {
        return $this->_user;
    }

    /**
     * @return UserDAO
     */
    public function getUserDAO(): UserDAO
    {
        return $this->_userDAO;
    }


    /**
     * @param UserDAO $userDAO
     */
    public function setUserDAO(UserDAO $userDAO): void
    {
        $this->_userDAO = $userDAO;
    }
}