<?php

function get_total_all_records()
{
    include('../config_pdo.php');
    $statement = $connection->prepare("SELECT * FROM reservation");
    $statement->execute();
    $result = $statement->fetchAll();
    return $statement->rowCount();
}
