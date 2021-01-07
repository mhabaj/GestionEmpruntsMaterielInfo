<?php

require_once(__DIR__ ."/../Controller/EquipmentController.php");
require_once(__DIR__ ."/../Controller/DataBase.php");
require_once(__DIR__ ."/../Model/Equipment.php");
require_once(__DIR__ ."/../ControllerDAO/EquipmentDAO.php");

use PHPUnit\Framework\TestCase;

/**
 * Class EquipmentControllerTest
 * @covers EquipmentController
 */
final class EquipmentControllerTest extends TestCase
{

    public static function deleteEquipment($ref){
        $bdd = new DataBase();
        $con = $bdd->getCon();

        $queryEquipments = "DELETE FROM stock_photo WHERE stock_photo.ref_equip LIKE ?;";
        $myStatement = $con->prepare($queryEquipments);
        $myStatement->execute([$ref]);

        $queryEquipments = "DELETE FROM device WHERE device.ref_equip LIKE ?;";
        $myStatement = $con->prepare($queryEquipments);
        $myStatement->execute([$ref]);

        $queryEquipments = "DELETE FROM equipment WHERE equipment.ref_equip LIKE ?;";
        $myStatement = $con->prepare($queryEquipments);
        $myStatement->execute([$ref]);

        $myStatement->closeCursor();
        $bdd->closeCon();
    }

    public static function setUpBeforeClass(): void
    {
        $edao = new EquipmentDAO();

        $edao->createEquipment("XX001", "TypeEquip", "BrandEquip", "NameEquip", "VersionEquip", 1);
    }

    public static function tearDownAfterClass(): void
    {
        EquipmentControllerTest::deleteEquipment("XX000");
        EquipmentControllerTest::deleteEquipment("XX001");
        EquipmentControllerTest::deleteEquipment("XX002");
        EquipmentControllerTest::deleteEquipment("XX003");
        EquipmentControllerTest::deleteEquipment("XX004");
    }

    public function testCreateEquipment(): void
    {
        $equipment1 = new Equipment("XX000", "TypeTest", "NameTest", "BrandTest", "VersionTest");

        $ec = new EquipmentController();

        $ec->loadEquipmentFromObject($equipment1);

        $ec->createNewEquipment(3);

        $ec->loadEquipmentFromDDB("XX000");

        $this->assertEquals(3, $ec->getEquipmentDAO()->howMuchTotal("XX000"));

        $equipment2 = $ec->getEquipment();

        $this->assertEquals($equipment1->getRefEquip(), $equipment2->getRefEquip());
        $this->assertEquals($equipment1->getBrandEquip(), $equipment2->getBrandEquip());
        $this->assertEquals($equipment1->getVersionEquip(), $equipment2->getVersionEquip());
        $this->assertEquals($equipment1->getTypeEquip(), $equipment2->getTypeEquip());
        $this->assertEquals($equipment1->getNameEquip(), $equipment2->getNameEquip());

        $this->deleteEquipment("XX000");
    }

    public function testCreateEquipmentDoublon(): void
    {
        $equipment = new Equipment("XX000", "TypeTest", "NameTest", "BrandTest", "VersionTest");

        $ec = new EquipmentController();

        $ec->loadEquipmentFromObject($equipment);

        $ec->createNewEquipment(3);

        $this->expectException(Exception::class);

        $ec->createNewEquipment(1);

        $this->deleteEquipment("XX000");
    }

    public function testModifyEquipment(): void
    {
        $ec = new EquipmentController();

        $ec->loadEquipmentFromDDB("XX001");

        $ec->modifyEquipment("XX001", "TypeTest1", "NameTest1", "BrandTest1", "VersionTest1", 1);

        $ec->loadEquipmentFromDDB("XX001");

        $equipment = $ec->getEquipment();

        $this->assertEquals($equipment->getRefEquip(), "XX001");
        $this->assertEquals($equipment->getBrandEquip(), "BrandTest1");
        $this->assertEquals($equipment->getVersionEquip(), "VersionTest1");
        $this->assertEquals($equipment->getTypeEquip(), "TypeTest1");
        $this->assertEquals($equipment->getNameEquip(), "NameTest1");

    }

    public function testModifyEquipmentDoublon(): void
    {
        $ec = new EquipmentController();

        $equipment1 = new Equipment("XX002", "TypeTest", "NameTest", "BrandTest", "VersionTest");

        $ec->loadEquipmentFromObject($equipment1);

        $ec->createNewEquipment(1);

        $equipment2 = new Equipment("XX003", "TypeTest", "NameTest", "BrandTest", "VersionTest");

        $ec->loadEquipmentFromObject($equipment2);

        $ec->createNewEquipment(1);

        $this->expectException(Exception::class);

        $ec->modifyEquipment("XX002", "TypeTest1", "NameTest1", "BrandTest1", "VersionTest1", 1);

    }

    public function testModifyEquipmentDeviceNumber(): void
    {
        $ec = new EquipmentController();

        $equipment = new Equipment("XX004", "TypeTest", "NameTest", "BrandTest", "VersionTest");

        $ec->loadEquipmentFromObject($equipment);

        $ec->createNewEquipment(3);

        $this->assertEquals(3, $ec->getEquipmentDAO()->howMuchTotal("XX004"));

        $ec->modifyEquipment("XX004", "TypeTest", "NameTest", "BrandTest", "VersionTest", 5);

        $this->assertEquals(5, $ec->getEquipmentDAO()->howMuchTotal("XX004"));

        $ec->modifyEquipment("XX004", "TypeTest", "NameTest", "BrandTest", "VersionTest", 1);

        $this->assertEquals(1, $ec->getEquipmentDAO()->howMuchTotal("XX004"));

        $this->expectException(Exception::class);

        $ec->modifyEquipment("XX004", "TypeTest", "NameTest", "BrandTest", "VersionTest", -1);
    }

}
