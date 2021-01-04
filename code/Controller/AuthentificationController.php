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

    public function identification()
    {
        try
        {
            $hashed_pwd = sha1($this->_password);

            $idCurrentUser = MainDAO::connection($this->_matriculeUser,$hashed_pwd);
            session_start();
            $_SESSION['id_user'] = $idCurrentUser;

            if(MainDAO::isUserAdmin(MainDAO::getUser($_SESSION['id_user'])) == true)
            {
                $_SESSION['isAdmin_user'] = 1;
            }
            else
            {
                $_SESSION['isAdmin_user'] = 0;
            }
            return true;

        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            return false;
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
