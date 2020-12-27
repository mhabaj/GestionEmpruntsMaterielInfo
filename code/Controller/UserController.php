<?php

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
            $currentUser = new UserRegular();
            $currentUser->loadingUser($id_userDisplay);
            $this->_user = $currentUser;
            if($this->_user->getIdUser() == null)
            {
                throw new Exception('Mauvais ID Utilisateur');
            }
        }
        catch (PDOException $e)
        {
            throw new Exception("Error!: " . $e->getMessage());
        }
    }

    public function returnBorrow($id_userDisplay,$idBorrow)
    {
        $currentUserAdmin = new UserAdmin();
        $currentUserAdmin->loadingUser($id_userDisplay);
        $currentUserAdmin->endborrow($idBorrow);
    }

    public function modifyPassword($password,$passwordRepeat)
    {
        try
        {
            if ($password == $passwordRepeat)
            {
                $currentUser = new UserRegular();
                $currentUser->loadingUser($_GET['id_user_toDisplay']);
                $currentUser->changePassword($password);
                header('Location: DetailUser.php?id_user_toDisplay='.$currentUser->getIdUser());
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

    public function modifyUser($id,$matricule,$email,$lastname,$name,$phone,$isAdmin)
    {
        try
        {
            if ($isAdmin == 'ok')
                $isAdmin = 1;
            else
                $isAdmin = 0;

            $currentUserAdmin = new UserAdmin();
            $currentUserAdmin->loadUser();
            $currentUserAdmin->modifyAnyProfile($id,$matricule,$email,$name, $lastname,$phone,$isAdmin);
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

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->_user = $user;
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

}