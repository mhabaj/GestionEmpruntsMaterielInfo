<?php

require_once(__DIR__ ."/../Controller/EquipmentController.php");
require_once(__DIR__ ."/../Model/Equipment.php");

use PHPUnit\Framework\TestCase;

/**
 * Class UserControllerTest
 * @covers UserController
 */
class UserControllerTest extends TestCase
{
    /**
     * @covers UserController::startBorrow
     * @dataProvider providerInvalidRef
     * @param String $refEquip
     * @throws Exception
     */
    public function startBorrow($equipmentController, $ref_equip_toBorrow, $dateFin, $quantity)
    {

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
