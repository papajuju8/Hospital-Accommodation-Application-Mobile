<?php

include('../config_pdo.php');
include('user_records.php');

// Fetch
$query = '';
$output = array();
$query .= "SELECT * FROM users_account ";

if (isset($_POST["search"]["value"])) {
    $query .= 'WHERE USERNAME LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR EMAIL LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR ADMIN LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR ACTIVE LIKE "%' . $_POST["search"]["value"] . '%" ';
}

$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach ($result as $row) {
    $sub_array = array();
    $sub_array[] = $row["ACCOUNT_ID"];
    $sub_array[] = $row["USERNAME"];
    $sub_array[] = $row["EMAIL"];
    if ($row["ADMIN"] == 'ADMIN') {
        $sub_array[] = '<span class="text-danger">ADMIN</span>';
    } else {
        $sub_array[] = '<span class="text-primary">USER</span>';
    }
    if ($row["ACTIVE"] == 0) {
        $sub_array[] = '<span class="text-danger">(0) Inactive</span>';
    } else {
        $sub_array[] = '<span class="text-success">(1) Active</span>';
    }
    $sub_array[] = '<button style="width: 100%" type="button" id="' . $row["ACCOUNT_ID"] . '" class="btn btn-sm edit-user">Edit</button>';

    $data[] = $sub_array;
}
$output = array(
    "draw"              =>  intval($_POST["draw"]),
    "recordsTotal"      =>  $filtered_rows,
    "recordsFiltered"   =>  get_total_all_records(),
    "data"              =>  $data
);
echo json_encode($output);
