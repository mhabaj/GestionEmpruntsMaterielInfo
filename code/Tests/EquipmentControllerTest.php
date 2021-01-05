<?php

require_once(__DIR__ ."/../Controller/EquipmentController.php");
require_once(__DIR__ ."/../Controller/DataBase.php");
require_once(__DIR__ ."/../Model/Equipment.php");

use PHPUnit\Framework\TestCase;

/**
 * Class EquipmentControllerTest
 * @covers EquipmentController
 */
final class EquipmentControllerTest extends TestCase
{
    /**
     * @covers EquipmentController::initEquipmentController
     * @dataProvider providerInvalidRef
     * @param String $refEquip
     * @throws Exception
     */
    public function testInitInvalid($refEquip): void
    {
        $ec = new EquipmentController();

        $this->expectException(Exception::class);

        $ec->initEquipmentController($refEquip);
    }

    /**
     * @covers EquipmentController::initEquipmentController
     * @throws Exception
     */
    public function testInitValid(): void
    {
        $ec = new EquipmentController();

        $ec->initEquipmentController("XX000");

        $e = $ec->getEquipment();

        $this->assertEquals("XX000", $e->getRefEquip(), "Erreur ref");
        $this->assertEquals("TypeTest", $e->getTypeEquip(), "Erreur type");
        $this->assertEquals("BrandTest", $e->getBrandEquip(), "Erreur marque");
        $this->assertEquals("NameTest", $e->getNameEquip(), "Erreur nom");
        $this->assertEquals("VersionTest", $e->getVersionEquip(), "Erreur version");
    }

    /**
     * @covers EquipmentController::modifyEquipment
     * @depends testInitValid
     * @dataProvider providerInvalidEquipmentNR
     * @param $refEquip
     * @param $type_equip
     * @param $marque_equip
     * @param $nom_equip
     * @param $version_equip
     * @param $quantite_equip
     * @throws Exception
     */
    public function testModifyEquipmentInvalid($type_equip, $marque_equip, $nom_equip, $version_equip, $quantite_equip): void
    {
        $ec = new EquipmentController();

        $ec->initEquipmentController("XX000");

        $this->expectException(Exception::class);

        $ec->modifyEquipment("XX000", $type_equip, $nom_equip, $marque_equip, $version_equip, $quantite_equip);
    }

    /**
     * @covers  EquipmentController::modifyEquipment
     * @depends testInitValid
     * @throws Exception
     */
    public function testModifyEquipmentValid(): void
    {
        $_SESSION["id_user"]=3;

        $ec = new EquipmentController();

        $ec->initEquipmentController("XX001");

        $ec->modifyEquipment("XX001", "TypeTest1", "NameTest1", "BrandTest1", "VersionTest1", 1);

        $ec->initEquipmentController("XX001");

        $e = $ec->getEquipment();

        $this->assertEquals("XX001", $e->getRefEquip(), "Erreur ref");
        $this->assertEquals("TypeTest1", $e->getTypeEquip(), "Erreur type");
        $this->assertEquals("BrandTest1", $e->getBrandEquip(), "Erreur marque");
        $this->assertEquals("NameTest1", $e->getNameEquip(), "Erreur nom");
        $this->assertEquals("VersionTest1", $e->getVersionEquip(), "Erreur version");

        $ec->modifyEquipment("XX001", "TypeTest", "NameTest", "BrandTest", "VersionTest", 1);
    }

    /**
     * @covers EquipmentController::isRefEquipUsed
     * @dataProvider providerInvalidRef
     * @param $ref
     */
    public function testIsRefEquipInvalid($ref): void
    {
        $ec = new EquipmentController();
        $ec->initEquipmentController("XX000");

        $this->assertFalse($ec->isRefEquipUsed($ref));
    }

    /**
     * @covers EquipmentController::isNewRefEquipUsed
     * @dataProvider providerInvalidRef
     * @param $ref
     */
    public function testIsNewRefEquipInvalid($ref): void
    {
        $ec = new EquipmentController();

        $this->assertFalse($ec->isNewRefEquipUsed($ref));
    }

    /**
     * @covers EquipmentController::createNewEquipment
     * @dataProvider providerInvalidEquipmentR
     * @param $ref_equip
     * @param $type_equip
     * @param $marque_equip
     * @param $nom_equip
     * @param $version_equip
     * @param $quantite_equip
     * @throws Exception
     */
    public function testCreateNewEquipmentInvalid($ref_equip, $type_equip, $marque_equip, $nom_equip, $version_equip, $quantite_equip): void
    {
        $ec = new EquipmentController();

        $this->expectException(Exception::class);

        $ec->createNewEquipment($ref_equip, $type_equip, $nom_equip, $marque_equip, $version_equip, $quantite_equip);
    }

    /**
     * @covers EquipmentController::reserveEquipment
     * @dataProvider providerReserve
     * @param $dateFinBorrow
     * @param $quantite_equip
     * @throws Exception
     */
    public function testReserveEquipmentInvalid($dateFinBorrow, $quantite_equip): void
    {
        $ec = new EquipmentController();
        $ec->initEquipmentController("XX000");

        $this->expectException(Exception::class);

        $ec->reserveEquipment($dateFinBorrow, $quantite_equip);
    }

    /////////////////////////////////////////////////////////////////////////////////////
    /// PROVIDER ////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////

    public function providerReserve(): array
    {
        $_SESSION["id_user"]=3;

        return[
            ["2100-01-01","0"],
            [0,1],
            ["00000",1],
            ["2000-01-01",1],
            ["2100-20-01",1],
            ["2100-01-40",1],
            ["2100-01-01",-1],
        ];

    }

    public function providerInvalidEquipmentR(): array
    {
        $_SESSION["id_user"]=3;

        return[
            ["A0", "A", "A", "A", "A", 1],
            ["AAAAA", "A", "A", "A", "A", 1],
            ["00000", "A", "A", "A", "A", 1],
            [0, "A", "A", "A", "A", 1],
            [0.111, "A", "A", "A", "A", 1],
            [1000000, "A", "A", "A", "A", 1],
            ["XX002", "A", "A", "A", "A", -1],
            ["XX002", "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA", "A", "A", "A", 1],
            ["XX002", 1, "A", "A", "A", 1],
            ["XX002", "A", "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA", "A", "A", 1],
            ["XX002", "A", 1, "A", "A", 1],
            ["XX002", "A", "A", "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA", "A", 1],
            ["XX002", "A", "A", 1, "A", 1],
            ["XX002", "A", "A", "A", "AAAAAAAAAAAAAAAA", 1],
            ["XX002", "A", "A", "A", 1, 1]
        ];
    }

    public function providerInvalidEquipmentNR(): array
    {
        $_SESSION["id_user"]=3;

        return[
            ["A", "A", "A", "A", -1],
            ["AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA", "A", "A", "A", 1],
            [1, "A", "A", "A", 1],
            ["A", "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA", "A", "A", 1],
            ["A", 1, "A", "A", 1],
            ["A", "A", "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA", "A", 1],
            ["A", "A", 1, "A", 1],
            ["A", "A", "A", "AAAAAAAAAAAAAAAA", 1],
            ["A", "A", "A", 1, 1]
        ];
    }

    public function providerInvalidRef(): array
    {
        return [
            ["A0"],
            ["AAAAA"],
            ["00000"],
            [0],
            [0.111],
            [1000000]
        ];
    }

}
