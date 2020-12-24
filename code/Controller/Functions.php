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
            throw new Exception("Incorrect refEquip input");
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
            throw new Exception("Incorrect mail input");
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
            throw new Exception("Incorrect number input");
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
            throw new Exception("Incorrect matricule input");
        }
    }

    public static function checkNameMateriel($nom)
    {
        if (preg_match('/^([A-Z]|[a-z]|[0-9]){1,30}$/', $nom))
        {
            return true;
        }
        else
        {
            throw new Exception("Incorrect nom materiel input");
        }
    }

    public static function checkVersionMateriel($version)
    {
        if (preg_match('/([A-Z]|[a-z]|[0-9.-]|[,;:#"]){3,15}/', $version))
        {
            return true;
        }
        else
        {
            throw new Exception("Incorrect nom materiel input");
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
            throw new Exception("Incorrect nom utilisateur input");
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
            throw new Exception("Incorrect nom utilisateur input");
        }
    }
}

Functions::checkNameUser('david');