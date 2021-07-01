<?php
include('../config_pdo.php');
include('user_records.php');

if (isset($_POST["user_operation"])) {
    date_default_timezone_set('Asia/Manila');
    $dt = new DateTime();
    $today = $dt->format('Y-m-d H:i:s');

    if ($_POST["user_operation"] == "Edit") {
        $statement = $connection->prepare("UPDATE users_account SET ADMIN = :type, ACTIVE = :active, MODIFIED_ON = :today WHERE ACCOUNT_ID = :id");
        $result = $statement->execute(
            array(
                ':type'   =>  $_POST["users_type"],
                ':active' =>  $_POST["users_active"],
                ':today'  =>  $today,
                ':id' => $_POST["account_id"]
            )
        );
    }
}
