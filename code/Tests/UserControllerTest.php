<?php

require_once("D:/wamp64/www/GestionEmpruntsMaterielInfo/code/Controller/UserController.php");
require_once("D:/wamp64/www/GestionEmpruntsMaterielInfo/code/ControllerDAO/UserDAO.php");
require_once("D:/wamp64/www/GestionEmpruntsMaterielInfo/code/Model/User.php");
require_once("D:/wamp64/www/GestionEmpruntsMaterielInfo/code/Controller/Functions.php");

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNotEquals;
use function PHPUnit\Framework\assertSame;


final class UserControllerTest extends TestCase
{
    /**
     * @covers UserController::createUser
     * @dataProvider providerValidCreateUser
     * @param $matricule
     * @param $password
     * @param $passwordRepeat
     * @param $email
     * @param $lastname
     * @param $name
     * @param $phone
     * @param $isAdmin
     * @throws Exception
     */
    public function testCreateUserValid($matricule, $password, $passwordRepeat, $email, $lastname, $name, $phone, $isAdmin){
        $userController=new userController();
        $userController->createUser($matricule, $password, $passwordRepeat, $email, $lastname, $name, $phone, $isAdmin);
        $user=$userController->getUserDAO()->getLastInsertedUser();

        assertEquals($matricule,$user->getMatriculeUser());
        assertEquals($password,$user->getPassword());
        assertEquals($email,$user->getEmail());
        assertEquals($lastname,$user->getLastName());
        assertEquals($name,$user->getFirstName());
        assertEquals($phone,$user->getPhone());
        assertEquals($isAdmin,$user->getIsAdmin());

    }

    /**
     * @covers UserController::createUser
     * @dataProvider providerInvalidCreateUser
     * @param $matricule
     * @param $password
     * @param $passwordRepeat
     * @param $email
     * @param $lastname
     * @param $name
     * @param $phone
     * @param $isAdmin
     */
     public function testCreateUserInvalid($matricule, $password, $passwordRepeat, $email, $lastname, $name, $phone, $isAdmin)
     {
         $userController = new userController();
         $userController->createUser($matricule, $password, $passwordRepeat, $email, $lastname, $name, $phone, $isAdmin);
         $user = $userController->getUserDAO()->getLastInsertedUser();

         //$this->expectException(Exception::class);

         assertNotEquals("TestMat", $user->getMatriculeUser());
         assertNotEquals("TestPassword", $user->getPassword());
         assertNotEquals("TestEmail@gmail.com", $user->getEmail());
         assertNotEquals("TestLastname", $user->getLastName());
         assertNotEquals("TestFirstName", $user->getFirstName());
         assertNotEquals("0123456789", $user->getPhone());
         assertNotEquals(0, $user->getIsAdmin());
     }

    /////////////////////////////////////////////////////////////////////////////////////
    /// PROVIDER ////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////

    public function providerValidCreateUser(): array
    {
        return[
            ["userna1","azerty","azerty","jeandupont@gmail.com","Dupont","Jean","0644559980",1],
            ["userna2","qwerty","qwerty","marcdupont@gmail.com","Dupont","Marc","0644559770",0],
            ["tylerr1","alpha","alpha","tyler1@gmail.com","One","Tyler","0722222222",0],
            ["kaaris1","kaka","kaka","kaaris@gmail.com","Gnakouri","Armand","0342424242",0],
            ["booba12","boobi","boobi","booba@gmail.com","Yaffa","Elie","0923232323",1]

        ];
    }
    public function providerInvalidCreateUser(): array
    {
        return[
            ["aled619","azerty","azerty","jeandupont@gmail.com","Dupont","Jean","0644559980",1],
            ["aaaaaaa","qwerty","qwerty","marcdupont@gmail.com","Dupont","Marc","0644559770",1],
            ["tylerr1","alpha","alpha","tyler1@gmail.com","One","Tyler","0722222222",1],
            ["DEVIENS","kaka","kaka","kaaris@gmail.com","Gnakouri","Armand","0342424242",1],
            ["FOUUUUU","boobi","boobi","booba@gmail.com","Yaffa","Elie","0923232323",1]

        ];
    }

}
