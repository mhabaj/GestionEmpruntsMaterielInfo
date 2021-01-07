<?php

require_once("D:/wamp64/www/GestionEmpruntsMaterielInfo/code/Controller/UserController.php");
require_once("D:/wamp64/www/GestionEmpruntsMaterielInfo/code/ControllerDAO/UserDAO.php");
require_once("D:/wamp64/www/GestionEmpruntsMaterielInfo/code/Model/User.php");
require_once("D:/wamp64/www/GestionEmpruntsMaterielInfo/code/Controller/Functions.php");
require_once("D:/wamp64/www/GestionEmpruntsMaterielInfo/code/Model/Borrow.php");

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
         $this->expectException(Exception::class);

         $userController = new userController();
         $userController->createUser($matricule, $password, $passwordRepeat, $email, $lastname, $name, $phone, $isAdmin);
         $user = $userController->getUserDAO()->getLastInsertedUser();

         assertEquals("TestMat", $user->getMatriculeUser());
         assertEquals("TestPassword", $user->getPassword());
         assertEquals("TestEmail@gmail.com", $user->getEmail());
         assertEquals("TestLastname", $user->getLastName());
         assertEquals("TestFirstName", $user->getFirstName());
         assertEquals("0123456789", $user->getPhone());
         assertEquals(0, $user->getIsAdmin());
    }

    /**
     * @covers UserController::modifyUser
     * @dataProvider providerValidModifyUser
     * @param $id
     * @param $matricule
     * @param $email
     * @param $lastname
     * @param $name
     * @param $phone
     * @param $isAdmin
     */
    public function testModifyUserValid($id, $matricule, $email, $lastname, $name, $phone, $isAdmin)
    {
        $userController=new userController();
        $userController->modifyUser($id, $matricule, $email, $lastname, $name, $phone, $isAdmin);
        $userController->setUser($userController->getUserDAO()->getUserByID($id));


        assertEquals($id,$userController->getUser()->getIdUser());
        assertEquals($matricule,$userController->getUser()->getMatriculeUser());
        assertEquals($email,$userController->getUser()->getEmail());
        assertEquals($lastname,$userController->getUser()->getLastName());
        assertEquals($name,$userController->getUser()->getFirstName());
        assertEquals($phone,$userController->getUser()->getPhone());
        assertEquals($isAdmin,$userController->getUser()->getIsAdmin());
    }

    /**
     * @covers UserController::modifyUser
     * @dataProvider providerInvalidModifyUser
     * @param $id
     * @param $matricule
     * @param $email
     * @param $lastname
     * @param $name
     * @param $phone
     * @param $isAdmin
     */
    public function testModifyUserInvalid($id, $matricule, $email, $lastname, $name, $phone, $isAdmin)
    {
        $this->expectException(Exception::class);
        $userController=new userController();
        $userController->modifyUser($id, $matricule, $email, $lastname, $name, $phone, $isAdmin);
        $userController->setUser($userController->getUserDAO()->getUserByID($id));

        assertEquals("TestMat",$userController->getUser()->getMatriculeUser());
        assertEquals("TestEmail@gmail.com",$userController->getUser()->getEmail());
        assertEquals("TestLastName",$userController->getUser()->getLastName());
        assertEquals("TestFirstName",$userController->getUser()->getFirstName());
        assertEquals("0123456789",$userController->getUser()->getPhone());
        assertEquals(0,$userController->getUser()->getIsAdmin());
    }

    /**
     * @covers UserController::modifyPassword
     * @dataProvider providerValidModifyPassword
     * @param $password
     * @param $passwordRepeat
     */
    public function testModifyPasswordValid($password, $passwordRepeat)
    {
        $userController=new UserController();
        $userController->createUser("TestMat","azerty","azerty","TestEmail@email.com","TestLastName","TestFirstName","0123456789",0);
        $userController->setUser($userController->getUserDAO()->getLastInsertedUser());
        $userController->modifyPassword($password,$passwordRepeat);

        assertEquals(sha1($password),$userController->getUser()->getPassword());
    }

    /**
     * @covers UserController::modifyPassword
     * @dataProvider providerInvalidModifyPassword
     * @param $password
     * @param $passwordRepeat
     * @throws Exception
     */
    public function testModifyPasswordInvalid($password, $passwordRepeat)
    {
        $userController=new UserController();
        $userController->createUser("TestMat","azerty","azerty","TestEmail@email.com","TestLastName","TestFirstName","0123456789",0);
        $userController->setUser($userController->getUserDAO()->getLastInsertedUser());
        $userController->modifyPassword($password,$passwordRepeat);

        assertNotEquals(true, $userController->modifyPassword($password,$passwordRepeat));
    }

    /**
     * @covers UserController::startBorrow
     * @dataProvider providerValidStartBorrow
     * @param $ref_equip_toBorrow
     * @param $dateFin
     * @param $quantity
     */
    public function testStartBorrowValid($ref_equip_toBorrow, $dateFin, $quantity)
    {
        /*
        $equipmentController=new EquipmentController();
        $UserController = new UserController();
        $userToTest = new User("1","test@gmail.com","test123","test","testFirstName","testLastName","0123456789","1");
        $UserController->setUser($userToTest);
        $UserController->startBorrow($equipmentController, $ref_equip_toBorrow, $dateFin, $quantity,$userToTest->getIdUser());

        assertEquals($quantity, $UserController->getUser()->getBorrowList()->size());
        for($i = 0; $i <= $UserController->getUser()->getBorrowList()->size(); $i++)
        {
            assertEquals($dateFin, $UserController->getUser()->getBorrowList()[$i]->getEndDate());
        }*/
    }

    /**
     * @covers UserController::endBorrow
     * @dataProvider providerValidEndBorrow
     * @param $ref_equip_toBorrow
     * @param $dateFin
     * @param $quantity
     */
    public function testEndBorrowValid($ref_equip_toBorrow,$dateFin,$quantity)
    {

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
            ["","azerty","azerty","jeandupont@gmail.com","Dupont","Jean","0644559980",1],
            ["tylerr4","alpha","alpha","tyler1@gmail.com","One","Tyler","0623456789774",1],
            ["DEVIENS","kakaka","kaka","kaaris@gmail.com","Gnakouri","Armand","0342424242",1],
            ["ayayaya","lalala","lalala","aya@@@@@@aya","Nakamura","Aya","0123456789",1]
        ];
    }

    public function providerValidModifyUser(): array
    {
        return[
            [3,"aled569","jeandupont@gmail.com","Dupont","Jean","0644559980",0],
            [4,"aaaaaaa","marcdupont@gmail.com","Dupont","Marc","0644559770",1],
            [5,"tylerr1","tyler1@gmail.com","One","Tyler","0722222222",0],
            [6,"DEVIENS","kaaris@gmail.com","Gnakouri","Armand","0342424242",0],
            [7,"FOUUUUU","booba@gmail.com","Yaffa","Elie","0923232323",1]
        ];
    }

    public function providerInvalidModifyUser(): array
    {
        return[
            [3,"","jeandupont@gmail.com","Dupont","Jean","0644559980",1],
            [4,"aaaaaaa","marcdupont@gmail.com","Dupont","Marc","064455977014141",1],
            [5,"tylerr1","tyler1@@@@gmail.com","One","Tyler","0722222222",1],

        ];
    }

    public function providerValidModifyPassword(): array
    {
        return[
            ["qwerty","qwerty"],
            ["AZERTYYYYYY","AZERTYYYYYY"]
        ];
    }

    public function providerInvalidModifyPassword(): array
    {
        return[
            ["",""],
            ["azerty","paspareil"],
            ["paspareil","azerty"],
        ];
    }

    public function providerValidStartBorrow(): array
    {
        return[
            ["AP154", "2021/10/12", "3"]
        ];
    }

    public function providerValidEndBorrow(): array
    {
        return[

        ];
    }
}
