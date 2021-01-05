<?php
require_once "Controller/DataBase.php";

/**
 * Class BorrowDAO
 */
class BorrowDAO
{
    /**
     * @param $refEquip
     * @param $endDate
     * @return bool
     */
    public static function startBorrow($refEquip, $endDate): bool
    {
        try {

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
            $myStatement->execute([$_SESSION['id_user'], $device_id, $id_borrow]);


            $con->commit();
            return TRUE;
        } catch (PDOException $e) {
            $con->rollback();
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * @param $idBorrow
     * @param $device_id
     * @return bool
     * @throws Exception
     */
    public static function stopBorrow($idBorrow, $device_id): bool
    {
        date_default_timezone_set('Europe/Paris');
        $currentDateTime = date('Y/m/d');
        $end_date = $currentDateTime;

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
