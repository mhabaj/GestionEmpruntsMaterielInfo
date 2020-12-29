<?php
require_once("Functions.php");

class InscriptionController
{

    public function __construct()
    {

    }

    public function initInscriptionController()
    {

    }

    public function createUserController($matricule,$password,$passwordRepeat,$email,$lastname,$name,$phone,$isAdmin)
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

                $UserAdmin = new UserAdmin();
                $UserAdmin->createUser($matricule,$email,$password,$name,$lastname,$phone,$isAdmin);
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
}