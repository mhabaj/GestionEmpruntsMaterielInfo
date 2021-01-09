<?php

require_once(__DIR__ . "/../Model/User.php");
require_once(__DIR__ . "/../Controller/DataBase.php");
require_once(__DIR__ . "/../Model/Borrow.php");


/**
 * @Class UserDAO.php
 * @author Alhabaj Mahmod, Anica Sean, Belda Tom, Ingarao Adrien, Maggouh Naoufal, Ung Alexandre
 * Class that allows the interaction between database and the classes of the model.
 */
class UserDAO
{

    /**
     * UserDAO constructor.
     */
    public function __construct()
    {
    }


    /**
     * Method that returns true if a user exists in the database, or false if not.
     * The user is identified by his id.
     *
     * @param $id
     * @preC $id must be valid therefore > 0
     *
     * @return bool
     */
    public function userExists($id): bool
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $query = "SELECT * FROM users WHERE id_user = ? ;";
        $stmt = $con->prepare($query);
        $stmt->execute([$id]);

        $result = $stmt->rowCount();

        if ($result == 1)
            return true;
        else
            return false;
    }

    /**
     * Methods that returns an user object identified by his id.
     *
     * @param int $id
     * @preC $id must exist in the database.
     *
     * @return User|null
     */
    public function getUserByID(int $id): ?User
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $query = "SELECT * FROM users WHERE id_user = ? ;";
        $stmt = $con->prepare($query);
        $stmt->execute([$id]);

        $result = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count == 0)
            return null;

        $user = new User($id, $result['email_user'], $result['matricule_user'], $result['password_user'],
            $result['name_user'], $result['lastname_user'], $result['phone_user'], $result['isAdmin_user']);


        $myQuery = "SELECT borrow_info.id_borrow,startdate_borrow,enddate_borrow,isActive, borrow.id_device, device.ref_equip FROM borrow_info
                    INNER JOIN borrow INNER JOIN device ON borrow.id_borrow= borrow_info.id_borrow AND borrow.id_device= device.id_device
                    WHERE borrow.id_user = '$id' AND borrow_info.isActive=1;";

        $myStatement = $con->query($myQuery);
        $result = $myStatement->rowCount();
        $borrowLignes = $myStatement->fetchAll();

        if ($result > 0) {
            foreach ($borrowLignes as $borrow) {

                $BorrowItem = new Borrow($borrow['ref_equip'], $borrow['enddate_borrow']);
                $BorrowItem->setStartDate($borrow['startdate_borrow']);
                $BorrowItem->setDeviceId($borrow['id_device']);
                $BorrowItem->setIdBorrow($borrow['id_borrow']);

                $user->addBorrowToList($BorrowItem);
            }
        }

        $bdd->closeCon();

        return $user;
    }

    /**
     * Method that allows the change of the password of a certain user, where $user
     * is the user whose password is changedn and $hashedNewPassword is the new password.
     *
     * @param $user
     * @param $hashedNewPassword
     *
     * @return bool
     * @throws Exception
     */
    public function changeUserPassword($user, $hashedNewPassword): bool
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $con->beginTransaction();

        try {
            $requete = "UPDATE USERS SET password_user= ? WHERE id_user = ?;";
            $stmt = $con->prepare($requete);
            $stmt->execute([$hashedNewPassword, $user->getIdUser()]);
            $con->commit();
            return true;
        } catch (Exception $e) {
            $con->rollback();
            throw new Exception("Could not update password");
        }


    }

    /**
     * Methods that allows to modify all the attributes of a certain user,
     * the id, username(matricule_user), email, firstname(name), lastname, phone and the boolean isAdmin_user which specifies
     * if the user is an admin(true) or not(false).
     *
     * @param $_idUser
     * @param $_matricule_user
     * @param $_email_user
     * @param $_name_user
     * @param $_lastname_user
     * @param $_phone
     * @param $_isAdmin_user
     *
     * @return bool
     * @throws Exception
     */
    public function modifyUser($_idUser, $_matricule_user, $_email_user, $_name_user, $_lastname_user, $_phone, $_isAdmin_user): bool
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        try {

            $con->beginTransaction();

            $query = "UPDATE users SET matricule_user=?,email_user=?,name_user=?,lastname_user=?,phone_user=?,isAdmin_user=? where users.id_user = ?  ;";
            $stmt = $con->prepare($query);
            $stmt->execute([$_matricule_user, $_email_user, $_name_user, $_lastname_user, $_phone, $_isAdmin_user, $_idUser]);
            $con->commit();
            $bdd->closeCon();
            return true;

        } catch (PDOException $e) {
            $con->rollback();
            $bdd->closeCon();

            throw new Exception($e->getMessage());
        }
    }

    /**
     * methods that allows the user to connect to the website, using his username(matricule) and his password.
     *
     * @param $matricule
     * @param $mdp
     *
     * @return bool
     */
    public function connect($matricule, $mdp): bool
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        //Hashage du mdp
        $hash_mdp = sha1($mdp);

        //Inserer valeurs
        $requete = "SELECT * FROM users WHERE matricule_user = ? AND password_user= ? ;";
        $stmt = $con->prepare($requete);
        $stmt->execute([$matricule, $hash_mdp]);
        $result = $stmt->rowCount();

        if ($result == 1) {
            session_start();
            $infoUser = $stmt->fetch();
            $_SESSION['id_user'] = $infoUser['id_user'];
            $_SESSION['isAdmin_user'] = $infoUser['isAdmin_user'];
            $bdd->closeCon();
            return TRUE;
        } else {
            $bdd->closeCon();
            return FALSE;
        }
    }

    /**
     * Method that return true if a username(matricule) of a user exists or else false.
     *
     * @param $matricule
     *
     * @return bool
     */
    public function matriculeUserExists($matricule): bool
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();


        //insert of the id of the user
        $requete = "SELECT * FROM users WHERE matricule_user like ?;";
        $stmt = $con->prepare($requete);
        $stmt->execute([$matricule]);
        $resultcount = $stmt->rowCount();
        if ($resultcount > 0) {
            return true;
        }
        return false;
    }


    /**
     * Methods that returns a statement that allows to get the history of borrowed items of a certain user. (identified by his id).
     *
     * @param $id_user_toDisplay
     *
     * @return null
     */
    public
    function getHistory($id_user_toDisplay)
    {
        try {
            $bdd = new DataBase();
            $con = $bdd->getCon();
            $queryUser = "SELECT * FROM borrow_info INNER JOIN borrow ON borrow_info.id_borrow=borrow.id_borrow INNER JOIN device ON device.id_device=borrow.id_device INNER JOIN 
            equipment ON equipment.ref_equip=device.ref_equip WHERE borrow.id_user=? AND borrow_info.isActive=0";
            $myStatement = $con->prepare($queryUser);
            $myStatement->execute([$id_user_toDisplay]); //$_GET['id_user_toDisplay']

            return $myStatement;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return null;
    }

    /**
     * method that allows to create a user by specifying all the attributes of an user.
     *
     * @param $_matriculeUser
     * @param $_emailUser
     * @param $_passwordUser
     * @param $_firstNameUser
     * @param $_lastnameUser
     * @param $_phone
     * @param $_isAdminUser
     *
     * @return bool
     * @throws Exception
     */
    public function createUser($_matriculeUser, $_emailUser, $_passwordUser, $_firstNameUser, $_lastnameUser, $_phone, $_isAdminUser): bool
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        try {
            $con->beginTransaction();

            $query = "INSERT INTO users (matricule_user,email_user,password_user,name_user,lastname_user,phone_user,isAdmin_user) VALUES (?,?,?,?,?,?,?);";
            $stmt = $con->prepare($query);
            $stmt->execute([$_matriculeUser, $_emailUser, $_passwordUser, $_firstNameUser, $_lastnameUser, $_phone, $_isAdminUser]);
            $con->commit();
            $bdd->closeCon();
            return true;
        } catch (PDOException $e) {
            $con->rollback();
            $bdd->closeCon();
            throw new Exception("<p> Could not create the user, invalid user input </p> ");
        }
    }

    /**
     * method to get the last inserted id of the database, in order to update the id like.
     *
     * @return User|null
     */
    public
    function getLastInsertedUser(): ?User
    {

        $bdd = new DataBase();
        $con = $bdd->getCon();

        $query = "SELECT MAX(id_user) as 'id'  FROM users;";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $this->getUserByID($result['id']);

    }
}