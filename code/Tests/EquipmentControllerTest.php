<?php

require_once("D:/wamp64/www/GestionEmpruntsMaterielInfo/code/Controller/EquipmentController.php");
require_once("D:/wamp64/www/GestionEmpruntsMaterielInfo/code/ControllerDAO/EquipmentDAO.php");
require_once("D:/wamp64/www/GestionEmpruntsMaterielInfo/code/Model/Equipment.php");
require_once("D:/wamp64/www/GestionEmpruntsMaterielInfo/code/Controller/Functions.php");

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

/**
 * Class EquipmentControllerTest
 * @covers EquipmentController
 */
final class EquipmentControllerTest extends TestCase
{
    /**
     * @covers       EquipmentController::modifyEquipment
     * @dataProvider providerValidModifyEquipment
     * @param $ref_equip
     * @param $type_equip
     * @param $name_equip
     * @param $brand_equip
     * @param $version_equip
     * @param $quantity_equip
     * @throws Exception
     */
    public function testModifyEquipmentValid($ref_equip, $type_equip, $name_equip, $brand_equip, $version_equip, $quantity_equip): void
    {
        $equipmentController = new EquipmentController();
        $equipmentToTest = new Equipment("XX000","testType","testName","testBrand","0.0");

        $dbMock = $this->createMock(EquipmentDAO::class);

        $dbMock->method('isRefEquipUsed')
            ->willReturn(false);
        $dbMock->method('howMuchAvailable')
            ->willReturn(10);
        $dbMock->method('updateDeviceCount')
            ->willReturn(true);
        $dbMock->method('modifyEquipment')
            ->willReturn(true);

        $equipmentController->setEquipment($equipmentToTest);
        $equipmentController->setEquipmentDAO($dbMock);

        $equipmentController->modifyEquipment($ref_equip, $type_equip, $name_equip, $brand_equip, $version_equip, $quantity_equip);

        assertSame($ref_equip,$equipmentController->getEquipment()->getRefEquip());
        assertSame($type_equip,$equipmentController->getEquipment()->getTypeEquip());
        assertSame($name_equip,$equipmentController->getEquipment()->getNameEquip());
        assertSame($brand_equip,$equipmentController->getEquipment()->getBrandEquip());
        assertSame($version_equip,$equipmentController->getEquipment()->getVersionEquip());
    }

    /**
     * @covers       EquipmentController::modifyEquipment
     * @dataProvider providerInvalidModifyEquipment
     * @param $ref_equip
     * @param $type_equip
     * @param $name_equip
     * @param $brand_equip
     * @param $version_equip
     * @param $quantity_equip
     * @throws Exception
     */
    public function testModifyEquipmentInvalid($ref_equip, $type_equip, $name_equip, $brand_equip, $version_equip, $quantity_equip): void
    {

        $equipmentController = new EquipmentController();
        $equipmentToTest = new Equipment("XX000","testType","testName","testBrand","0.0");

        $dbMock = $this->createMock(EquipmentDAO::class);

        $dbMock->method('isRefEquipUsed')
            ->willReturn(false);
        $dbMock->method('howMuchAvailable')
            ->willReturn(10);
        $dbMock->method('updateDeviceCount')
            ->willReturn(true);
        $dbMock->method('modifyEquipment')
            ->willReturn(true);

        $equipmentController->setEquipment($equipmentToTest);
        $equipmentController->setEquipmentDAO($dbMock);

        $this->expectException(Exception::class);
        $equipmentController->modifyEquipment($ref_equip, $type_equip, $name_equip, $brand_equip, $version_equip, $quantity_equip);

        assertSame("XX000",$equipmentController->getEquipment()->getRefEquip());
        assertSame("testType",$equipmentController->getEquipment()->getTypeEquip());
        assertSame("testName",$equipmentController->getEquipment()->getNameEquip());
        assertSame("testBrand",$equipmentController->getEquipment()->getBrandEquip());
        assertSame("0.0",$equipmentController->getEquipment()->getVersionEquip());
    }


    /////////////////////////////////////////////////////////////////////////////////////
    /// PROVIDER ////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////

    public function providerValidModifyEquipment(): array
    {
        return [
            ["AN999","Smartphone","Iphone9","apple","12.0",5],
            ["XX150","Tablette","Galaxy_Note_Pad_2","Samsung","9.0",10],
            ["AP490","Smartphone","SamsungS10","Samsung","1.0",14],
            ["XX640","Television","Crystal_UHD_75TU8075_SMART_TV","SAMSUNG","1.0",1]
        ];
    }

    public function providerInvalidModifyEquipment(): array
    {
        return [
            ["","Smartphone","Iphone9","Apple","12.0",5],
            ["XX150","Täblette","Galaxy,NotePad2","Samsung","9.0",10],
            ["AQ490","Smartphone","BlackBerry","","1.0",14],
            ["XX6400","Television","Crystal_UHD_75TU8075_SMART_TV","SAMSUNG","1.0",1],
            ["XX550","Televisionnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn","Mapple","Philips","1.0",8],
            ["XX860","testType","","Philips","17.0",1],
            ["XX220","Television","LG415485","6+59+","1",1]
        ];
    }

}
