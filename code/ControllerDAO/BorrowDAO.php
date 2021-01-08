<?php
require_once(__DIR__ ."/../Controller/DataBase.php");

/**
 * Class BorrowDAO
 */
class BorrowDAO
{
    public function __construct()
    {


    }

    /**
     * @param $refEquip
     * @param $endDate
     * @param $idUser
     * @return Borrow
     */
    public function startBorrow($refEquip, $endDate, $idUser): Borrow
    {


        date_default_timezone_set('Europe/Paris');
        $currentDateTime = date('Y/m/d');

        $start_date = $currentDateTime;

        $bdd = new DataBase();
        $con = $bdd->getCon();
        $con->beginTransaction();

        $requestSelect = "SELECT id_device FROM DEVICE WHERE isAvailable = TRUE AND ref_equip = '$refEquip';";
        $answerSelect = $con->query($requestSelect);
        $resultSelect = $answerSelect->fetch();

        $device_id = $resultSelect['id_device'];

        $requestUpdate = "UPDATE DEVICE SET isAvailable = FALSE WHERE id_device = '$device_id';";
        $con->query($requestUpdate);

        $requestInsert = "INSERT INTO borrow_info (startdate_borrow, enddate_borrow, isActive) VALUES (?, ? , TRUE); ";
        $myStatement = $con->prepare($requestInsert);
        $myStatement->execute([$start_date, $endDate]);
        $id_borrow = $con->lastInsertId("id_borrow");

        $requestInsert1 = "INSERT INTO borrow (id_user, id_device, id_borrow) VALUES (?, ? , ?);";
        $myStatement = $con->prepare($requestInsert1);
        $myStatement->execute([$idUser, $device_id, $id_borrow]);


        $con->commit();
        return new Borrow($refEquip, $endDate);

    }

    /**
     * @param $idBorrow
     * @param $device_id
     * @param $end_date
     * @return bool
     * @throws Exception
     */
    public function stopBorrow($idBorrow, $device_id, $end_date): bool
    {


        $bdd = new DataBase();
        $con = $bdd->getCon();

        $con->beginTransaction();
        try {
            $requestUpdate = "UPDATE DEVICE SET isAvailable = 1 WHERE id_device = '$device_id';";
            $con->query($requestUpdate);

            $requestUpdate2 = "UPDATE borrow_info SET enddate_borrow = '$end_date',isActive = 0 WHERE id_borrow = '$idBorrow';";
            $con->query($requestUpdate2);
            $con->commit();
            return TRUE;
        } catch (Exception $e) {
            $con->rollback();
            throw new Exception($e->getMessage());
        }
    }
}
