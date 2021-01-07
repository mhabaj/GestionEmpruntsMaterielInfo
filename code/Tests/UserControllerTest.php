<?php

require_once(__DIR__ ."/../Controller/EquipmentController.php");
require_once(__DIR__ ."/../Model/Equipment.php");
require_once (__DIR__."/../ControllerDAO/EquipmentDAO.php");
require_once(__DIR__ ."/../Controller/UserController.php");
require_once(__DIR__ ."/../Controller/BorrowController.php");

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;

/**
 * Class UserControllerTest
 * @covers UserController
 */
final class UserControllerTest extends TestCase
{
    /**
     * @covers UserController::startBorrow
     * @dataProvider providerValidStartBorrow
     * @param $ref_equip_toBorrow
     * @param $dateFin
     * @param $quantity
     * @throws Exception
     */
    public function testStartBorrow($ref_equip_toBorrow, $dateFin, $quantity)
    {
        $EquipmentController = new EquipmentController();
        $borrowController = new BorrowController();
        $UserController = new UserController();
        $userToTest = new User("1","test@gmail.com","test123","test","testFirstName","testLastName","0000000000","1");
        $borrow = new Borrow($ref_equip_toBorrow, $dateFin);

        $dbMockEquip = $this->createMock(EquipmentDAO::class);
        $dbMockBorrow = $this->createMock(BorrowDAO::class);

        $dbMockEquip->method('howMuchAvailable')->willReturn(10);
        $dbMockBorrow->method('startBorrow')->willReturn($borrow);

        $UserController->setUser($userToTest);
        $borrowController->setBorrowDAO($dbMockBorrow);
        $EquipmentController->setEquipmentDAO($dbMockEquip);

        $UserController->startBorrow($EquipmentController, $ref_equip_toBorrow, $dateFin, $quantity);

        assertEquals($quantity, $UserController->getUser()->getBorrowList()->size());

        for($i = 0; $i <= $UserController->getUser()->getBorrowList()->size(); $i++)
        {
            echo $UserController->getUser()->getBorrowList()[$i]->getEndDate();
            assertSame($dateFin, $UserController->getUser()->getBorrowList()[$i]->getEndDate());
        }
    }

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
    public function testCreateUser($matricule, $password, $passwordRepeat, $email, $lastname, $name, $phone, $isAdmin)
    {
        $userController = new UserController();
        $userToTest = new User("1","test@gmail.com","test123","test","testFirstName","testLastName","0000000000","1");

        $dbMockUser = $this->createMock(UserDAO::class);

        $dbMockUser->method('createUser')
            ->willReturn(true);

        $userController->setUser($userToTest);
        $userController->setUserDAO($dbMockUser);


        self::assertTrue($userController->createUser($matricule, $password, $passwordRepeat, $email, $lastname, $name, $phone, $isAdmin));
    }


    public function providerValidStartBorrow(): array
    {
        return [
            ["AP154", "2021/10/12", "3"]
        ];
    }

    public function providerValidCreateUser(): array
    {
        return [
            ["identif", "testpassword", "testpassword", "test@gmail.com", "testLastName", "testName","0611121314","1"]
        ];
    }
}
