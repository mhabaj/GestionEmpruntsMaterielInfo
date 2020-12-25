<?php

class Functions
{
    public static function checkRefEquip($inputRefEquip)
    {
        if (preg_match('/^(AN|AP|XX)[0-9]{3}$/', $inputRefEquip))
        {
            return true;
        }
        else
        {
            throw new Exception("La reference que vous avez entré est invalide");
        }
    }

    public static function checkMail($mail)
    {
        if (preg_match('/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/igm', $mail))
        {
            return true;
        }
        else
        {
            throw new Exception("Le mail que vous avez entré est invalide");
        }
    }

    public static function checkPhoneNumber($phoneNumber)
    {
        if (preg_match('/((\+)33|0|0033)[1-9](\d{2}){4}/igm', $phoneNumber))
        {
            return true;
        }
        else
        {
            throw new Exception("Le numéro de telephone que vous avez entré est invalide");
        }
    }

    public static function checkMatricule($matricule)
    {
        if (preg_match('/^([A-Z]|[a-z]|[0-9]){7}$/', $matricule))
        {
            return true;
        }
        else
        {
            throw new Exception("Votre identifiant de connexion est invalide");
        }
    }

    public static function checkNameMateriel($nom)
    {
        if (preg_match('/[A-Za-z0-9]{1,30}/', $nom))
        {
            return true;
        }
        else
        {
            throw new Exception("Le nom du matériel que vous avez entré est invalide");
        }
    }

    public static function checkVersionMateriel($version)
    {
        if (preg_match('/^[0-9.-_,;:#"]{3,15}$/', $version))
        {
            return true;
        }
        else
        {
            throw new Exception("La version du matériel que vous avez entré est invalide");
        }
    }

    public static function checkNameUser($nom)
    {
        if (preg_match('/^([A-Z]|[a-z]){1,30}$/', $nom))
        {
            return true;
        }
        else
        {
            throw new Exception("Le Nom que vous avez entré est invalide");
        }
    }

    public static function checkFirstNameUser($nom)
    {
        if (preg_match('/^([A-Z]|[a-z]){1,30}$/', $nom))
        {
            return true;
        }
        else
        {
            throw new Exception("Le prénom que vous avez entré est invalide");
        }
    }

    public static function checkBrandName($brand)
    {
        if (preg_match('/^([A-Za-z0-9-_, ]){1,30}$/', $brand))
        {
            return true;
        }
        else
        {
            throw new Exception("Le nom de la marque que vous avez entré est invalide");
        }
    }

    public static function checkTypeName($type)
    {
        if (preg_match('/^([A-Za-z0-9-_, ]){1,30}$/', $type))
        {
            return true;
        }
        else
        {
            throw new Exception("Le type de la marque que vous avez entré est invalide");
        }
    }
}

Functions::checkBrandName('caudàlie');