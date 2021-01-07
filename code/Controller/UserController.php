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
     * @param $idUser
     * @return bool Object, else null
     * PREC : quantity > 0 && reservation date after current server date
     * @throws Exception
     */
    public function startBorrow(EquipmentController $equipmentController, $ref_equip_toBorrow, $dateFin, $quantity, $idUser): bool
    {
        if (Functions::checkReservationDate($dateFin) && Functions::checkQuantityEquipment($quantity)) {
            if ($equipmentController->getEquipmentDAO()->howMuchAvailable($ref_equip_toBorrow) >= $quantity && $quantity > 0) {

                $indexOf = 0;
                while ($indexOf < $quantity) {
                    $tmpBorrowController = new BorrowController();
                    $newBorrow = $tmpBorrowController->getBorrowDAO()->startBorrow($ref_equip_toBorrow, $dateFin, $idUser);
                    $newBorrow->setEndDate($dateFin);
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
    public function endBorrow($id_borrow_toDel)
    {
        date_default_timezone_set('Europe/Paris');
        $currentDateTime = date('Y/m/d');
        $end_date = $currentDateTime;
        $cpt_array = 0;
        foreach ($this->_user->getBorrowList() as $borrow):
            if ($borrow->getIdBorrow() == $id_borrow_toDel) {
                $tmpBorrowController = new BorrowController();
                $tmpBorrowController->getBorrowDAO()->stopBorrow($borrow->getIdBorrow(), $borrow->getDeviceId(), $end_date);
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

            $this->_user = new User();

            $this->_userDAO->createUser($matricule, $email, $password, $name, $lastname, $phone, $isAdmin);
            $this->_user->setMatriculeUser($matricule);
            $this->_user->setEmail($email);
            $this->_user->setLastName($lastname);
            $this->_user->setFirstName($name);
            $this->_user->setPhone($phone);
            $this->_user->setIsAdmin($isAdmin);

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

        if (Functions::checkMatricule($matricule) == true
            && Functions::checkMail($email) == true
            && Functions::checkPhoneNumber($phone) == true
            && Functions::checkNameUser($lastname) == true
            && Functions::checkFirstNameUser($name) == true) {

            $this->_userDAO->modifyUser($id, $matricule, $email, $name, $lastname, $phone, $isAdmin);
            $this->_user->setMatriculeUser($matricule);
            $this->_user->setEmail($email);
            $this->_user->setLastName($lastname);
            $this->_user->setFirstName($name);
            $this->_user->setPhone($phone);
            $this->_user->setIsAdmin($isAdmin);
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
    public function modifyPassword($password, $passwordRepeat): bool
    {
        if ($password == '' || $password == null) {
            return false;
        }
        if ($password == $passwordRepeat) {
            $hashedNewPassword = sha1($password);
            $this->_userDAO->changeUserPassword($this->_user, $password);
            $this->_user->setPassword($hashedNewPassword);
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

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->_user = $user;

    }
}