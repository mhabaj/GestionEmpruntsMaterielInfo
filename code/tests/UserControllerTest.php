<?php

require_once(__DIR__ ."/../Controller/UserController.php");
require_once(__DIR__ ."/../ControllerDAO/UserDAO.php");
require_once(__DIR__ ."/../Model/User.php");
require_once(__DIR__ ."/../Controller/DataBase.php");



use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEquals;
use function PHPUnit\Framework\assertSame;

class UserControllerTest extends TestCase
{

    public static $idUser;
    public static $idBorrow;

    /**
     * @covers EquipmentController::createNewEquipment
     * @dataProvider providerValidModifyPassword
     * @param $passwordToChange
     * @param $passwordRepeatToChange
     * @throws Exception
     */
    public function testValidModifyPassword($passwordToChange, $passwordRepeatToChange)
    {
        $userController = new UserController();
        $userToTest = new User("1","test@gmail.com","test123","test","testFirstName","testLastName","0000000000","1");

        $dbMock = $this->createMock(UserDAO::class);
        $dbMock->method('changeUserPassword')
            ->willReturn(true);

        $userController->setUserDAO($dbMock);
        $userController->setUser($userToTest);

        $userController->modifyPassword($passwordToChange,$passwordRepeatToChange);
        $hashedNewPassword = sha1($passwordToChange);

        assertSame($hashedNewPassword,$userToTest->getPassword());
    }

    /**
     * @covers       EquipmentController::createNewEquipment
     * @dataProvider providerBadValuesModifyPassword
     * @param $passwordToChange
     * @param $passwordRepeatToChange
     * @throws Exception
     */
    public function testBadValuesModifyPassword($passwordToChange, $passwordRepeatToChange)
    {


        $userController = new UserController();
        $userToTest = new User("1","test@gmail.com","test123","test","testFirstName","testLastName","0000000000","1");

        $dbMock = $this->createMock(UserDAO::class);
        $dbMock->method('changeUserPassword')
            ->willReturn(true);

        $userController->setUserDAO($dbMock);
        $userController->setUser($userToTest);

        $userController->modifyPassword($passwordToChange,$passwordRepeatToChange);
        $hashedNewPassword = sha1($passwordToChange);

        assertNotEquals($hashedNewPassword,$userToTest->getPassword());
    }

    /**
     * @covers       EquipmentController::ModifyUser
     * @dataProvider providerValidModifyUser
     * @param $id
     * @param $matricule
     * @param $email
     * @param $lastName
     * @param $firstName
     * @param $phone
     * @param $isAdmin
     * @throws Exception
     */
    public function testModifyUser($id, $matricule, $email, $lastName, $firstName, $phone, $isAdmin)
    {
        $userController = new UserController();
        $userToTest = new User("1","test@gmail.com","test123","test","testFirstName","testLastName","0000000000","1");

        $dbMock = $this->createMock(UserDAO::class);
        $dbMock->method('modifyUser')
            ->willReturn(true);

        $userController->setUser($userToTest);
        $userController->setUserDAO($dbMock);
        $userController->modifyUser($id, $matricule, $email, $lastName, $firstName, $phone, $isAdmin);

        assertSame($matricule,$userController->getUser()->getMatriculeUser());
        assertSame($email,$userController->getUser()->getEmail());
        assertSame($lastName,$userController->getUser()->getLastName());
        assertSame($firstName,$userController->getUser()->getFirstName());
        assertSame($phone,$userController->getUser()->getPhone());
        assertSame($isAdmin,$userController->getUser()->getIsAdmin());
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
    /****************************************************************************TEST INTEGRATION****************************************************************************************/
    /***********************************************************************************************************************************************************************************/

    /**
     * @return User|null
     */
    public static function getLastInsertedBorrowId(): int
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $query = "SELECT MAX(id_borrow) as 'id'  FROM borrow;";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['id'];

    }

    public static function getLastInsertedDeviceId(): int
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $query = "SELECT MAX(id_device) as 'id'  FROM device;";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['id'];
    }

    public static function setUpBeforeClass(): void
    {

        $edao = new EquipmentDAO();
        $bdao = new BorrowDAO();
        $udao = new UserDAO();

        $edao->createEquipment("XX100", "TypeTest", "BrandEquip", "NameTest", "VersionTest", 1);
        $udao->createUser("MatriculeTest", "EmailTest", "PasswordTest", "FirstNameTest", "LastNameUser", "PhoneUser", 1);

        UserControllerTest::$idUser = $udao->getLastInsertedUser()->getIdUser();

        $bdao->startBorrow("XX100", "2100/01/01",UserControllerTest::$idUser);

        UserControllerTest::$idBorrow = (UserControllerTest::getLastInsertedBorrowId());

    }

    public static function tearDownAfterClass(): void
    {
        $dataBase = new DataBase();
        $dataBase->purgeDatabase();
    }


    public function testEndBorrow(): void
    {

        $uc = new UserController(UserControllerTest::$idUser);

        $borrow = new Borrow("XX100", "2100/01/01");
        $borrow->setDeviceId(UserControllerTest::getLastInsertedDeviceId());
        $borrow->setIdBorrow(UserControllerTest::$idBorrow);

        $uc->getUser()->addBorrowToList($borrow);

        $uc->endborrow(UserControllerTest::$idBorrow);

        $bdd = new DataBase();
        $con = $bdd->getCon();

        $query = "SELECT * FROM borrow_info WHERE borrow_info.id_borrow = ?;";
        $stmt = $con->prepare($query);
        $stmt->execute([UserControllerTest::$idBorrow]);
        $result = $stmt->fetch();

        $this->assertEquals("0", $result['isActive']);

        $this->expectException(Exception::class);

        Functions::checkReservationDate($result['enddate_borrow']);

    }

    /**
     * @covers UserController::createUser
     * @dataProvider providerValidCreateUser2
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
    public function testCreateUserValid($matricule, $password, $passwordRepeat, $email, $lastname, $name, $phone, $isAdmin)
    {
        $userController=new userController();
        $userController->createUser($matricule, $password, $passwordRepeat, $email, $lastname, $name, $phone, $isAdmin);
        $user = $userController->getUserDAO()->getLastInsertedUser();

        $hashedPassword = sha1($password);
        assertEquals($matricule,$user->getMatriculeUser());
        assertEquals($hashedPassword,$user->getPassword());
        assertEquals($email,$user->getEmail());
        assertEquals($lastname,$user->getLastName());
        assertEquals($name,$user->getFirstName());
        assertEquals($phone,$user->getPhone());
        assertEquals($isAdmin,$user->getIsAdmin());
    }

    /**
     * @covers UserController::createUser
     * @dataProvider providerInvalidCreateUser2
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
     * @covers       UserController::modifyUser
     * @param $id
     * @param $matricule
     * @param $email
     * @param $lastname
     * @param $name
     * @param $phone
     * @param $isAdmin
     * @throws Exception
     */
    public function testModifyUserValid()
    {
        $userController = new userController();

        $userController->createUser("admin12","test","test","test@gmail.com","dupont","batiste","0781754712",1);
        $userToTest = $userController->getUserDAO()->getLastInsertedUser();

        $userController->modifyUser($userToTest->getIdUser(), "normie1", "normie@gmail.com", "Mahvengers", "Mahdrien", "0781754712", 0);

        $userController->setUser($userController->getUserDAO()->getUserByID($userToTest->getIdUser()));

        assertEquals("normie1",$userController->getUser()->getMatriculeUser());
        assertEquals("normie@gmail.com",$userController->getUser()->getEmail());
        assertEquals("Mahvengers",$userController->getUser()->getLastName());
        assertEquals("Mahdrien",$userController->getUser()->getFirstName());
        assertEquals("0781754712",$userController->getUser()->getPhone());
        assertEquals(0,$userController->getUser()->getIsAdmin());
    }

    /**
     * @covers UserController::modifyUser
     * @dataProvider providerInvalidModifyUser2
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
     * @covers       UserController::modifyPassword
     * @dataProvider providerValidModifyPassword
     * @param $password
     * @param $passwordRepeat
     * @throws Exception
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
     * @dataProvider providerInvalidModifyPassword2
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





    /////////////////////////////////////////////////////////////////////////////////////
    /// PROVIDER ////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////
    ///

    public function providerValidModifyPassword()
    {
        return [
            ["admin","admin"],
            ["dagoadjs3183","dagoadjs3183"],
            ["12345","12345"],
            ["@nQc_r2e!cjSwV","@nQc_r2e!cjSwV"],
        ];
    }

    public function providerBadValuesModifyPassword()
    {
        return [
            ["","admin"],
            ["dagoadjs3183",""],
            ["@nQc_r2e!cjSwV","@nQc_jSwV"],
        ];
    }

    public function providerValidModifyUser()
    {
        return [
            ["12","admin12","admin123@gmail.com","dupont","batiste","0781754712","1"],
            ["184","maxou12","hugo@yahoo.fr","JeDonnePasMonNom","maxou","","0"], // numero de telphone non obligatoire
            ["4","alice77","alice77@hotmaill.fr","Micouin","Alice","0145789234","0"],
        ];
    }

    public function providerValidCreateUser(): array
    {
        return [
            ["identif", "testpassword", "testpassword", "test@gmail.com", "testLastName", "testName","0611121314","1"]
        ];
    }

    /**************************************************************** PROVIDER INTEGRATION *****************************************************************************************/

    public function providerValidCreateUser2(): array
    {
        return[
            ["tylerr2","alpha","alpha","tyler1@gmail.com","One","Tyler","0722222222",0],
            ["kaaris2","kaka","kaka","kaaris@gmail.com","Gnakouri","Armand","0342424242",1],
        ];
    }


    public function providerInvalidCreateUser2(): array
    {
        return[
            ["","azerty","azerty","jeandupont@gmail.com","Dupont","Jean","0644559980",1],
            ["tylerr4","alpha","alpha","tyler1@gmail.com","One","Tyler","0623456789774",1],
            ["DEVIENS","kakaka","kaka","kaaris@gmail.com","Gnakouri","Armand","0342424242",1],
            ["ayayaya","lalala","lalala","aya@@@@@@aya","Nakamura","Aya","0123456789",1]
        ];
    }


    public function providerInvalidModifyUser2(): array
    {
        return[
            [3,"","jeandupont@gmail.com","Dupont","Jean","0644559980",1],
            [4,"aaaaaaa","marcdupont@gmail.com","Dupont","Marc","064455977014141",1],
            [5,"tylerr1","tyler1@@@@gmail.com","One","Tyler","0722222222",1],

        ];
    }

    public function providerValidModifyPassword2(): array
    {
        return[
            ["qwerty","qwerty"],
            ["AZERTYYYYYY","AZERTYYYYYY"]
        ];
    }

    public function providerInvalidModifyPassword2(): array
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
            ["AP154", "2021/10/12", "1"]
        ];
    }


}

