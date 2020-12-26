<?php

class Functions
{
    public static function checkRefEquip($inputRefEquip): bool
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
    public static function checkTypeEquip($typeEquip): bool
    {

        if($typeEquip != null && strlen($typeEquip) <= 30){
            return true;
        }else{
            throw new Exception("Incorrect TypeEquip input");
        }


    }
    public static function checkBrandEquip($brandEquip): bool
    {

        if($brandEquip != null && strlen($brandEquip) <= 30){
            return true;
        }else{
            throw new Exception("Incorrect brandEquip input");
        }


    }

    public static function checkMail($mail): bool
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

    public static function checkPhoneNumber($phoneNumber): bool
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

    public static function checkMatricule($matricule): bool
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

    public static function checkNameMateriel($nom): bool
    {
        /*
        if (preg_match('/^([A-Z]|[a-z]|[0-9]){1,30}$/', $nom))
        {
            return true;
        }
        else
        {
            throw new Exception("Incorrect nom materiel input");
        }
        */

        if($nom != null && strlen($nom) <= 30){
            return true;
        }else{
            throw new Exception("Incorrect Nom Equipement input");
        }
    }

    public static function checkVersionMateriel($version): bool
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

    public static function checkNameUser($nom): bool
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

    public static function checkFirstNameUser($nom): bool
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

//Functions::checkNameUser('david');