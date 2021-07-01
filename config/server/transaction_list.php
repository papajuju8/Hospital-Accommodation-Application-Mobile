<?php

include('../config_pdo.php');
include('transaction_records.php');

// Fetch
$query = '';
$output = array();
$query .= "SELECT * FROM transaction ";

if (isset($_POST["search"]["value"])) {
    $query .= 'WHERE TRANS_ID LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR ACCOUNT_ID LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR MOVIE_ID LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR BRANCH_ID LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR DATE LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR TIME LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR SEATS LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR PRICE LIKE "%' . $_POST["search"]["value"] . '%" ';
}

if (isset($_POST["order"])) {
    $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY TRANS_ID DESC ';
}

if ($_POST["length"] != -1) {
    $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach ($result as $row) {
    $sub_array = array();
    $sub_array[] = $row["TRANS_ID"];
    $date = date_create($row["CREATED_ON"]);
    $sub_array[] = date_format($date, "(D) M j, Y, g:i a");
    if ($row["ACCOUNT_ID"] != 0) {
        $acc_id = $row["ACCOUNT_ID"];
        require_once '../config.php';
        $sql2 = "SELECT * FROM users_account WHERE ACCOUNT_ID = '$acc_id' LIMIT 1";
        $res2 = mysqli_query($link,  $sql2);
        if (mysqli_num_rows($res2) > 0) {
            while ($row2 = mysqli_fetch_assoc($res2)) {
                $sub_array[] = '(' . $row["ACCOUNT_ID"] . ') ' . $row2["USERNAME"];
            }
        } else {
            $sub_array[] = "";
        }
    } else {
        $sub_array[] = $row["ACCOUNT_ID"];
    }
    if ($row["MOVIE_ID"] != 0) {
        $movie_id = $row["MOVIE_ID"];
        require_once '../config.php';
        $sql2 = "SELECT * FROM movies WHERE MOVIE_ID = '$movie_id' LIMIT 1";
        $res2 = mysqli_query($link,  $sql2);
        if (mysqli_num_rows($res2) > 0) {
            while ($row2 = mysqli_fetch_assoc($res2)) {
                $sub_array[] = '(' . $row["MOVIE_ID"] . ') ' . $row2["MOVIE_TITLE"];
            }
        } else {
            $sub_array[] = "";
        }
    } else {
        $sub_array[] = $row["MOVIE_ID"];
    }
    if ($row["BRANCH_ID"] == 1) {
        $sub_array[] = '<span class="text-primary">(1) Manila</span>';
    } else if ($row["BRANCH_ID"] == 2) {
        $sub_array[] = '<span class="text-danger">(2) Marikina</span>';
    } else if ($row["BRANCH_ID"] == 3) {
        $sub_array[] = '<span class="text-success">(3) North Edsa</span>';
    } else {
        $sub_array[] = '<span class="text-secondary">(4) Bacoor</span>';
    }
    $date2 = date_create($row["DATE"]);
    $sub_array[] = date_format($date2, "(D) M j, Y");
    if ($row["TIME"] == 1) {
        $sub_array[] = '<span class="text-primary">(1) 9:30 am</span>';
    } else if ($row["TIME"] == 2) {
        $sub_array[] = '<span class="text-danger">(2) 1:00 pm</span>';
    } else {
        $sub_array[] = '<span class="text-success">(3) 4:30 pm</span>';
    }
    $sub_array[] = $row["SEATS"];
    $sub_array[] = '₱ ' . $row["PRICE"] . '.00';

    $data[] = $sub_array;
}
$output = array(
    "draw"              =>  intval($_POST["draw"]),
    "recordsTotal"      =>  $filtered_rows,
    "recordsFiltered"   =>  get_total_all_records(),
    "data"              =>  $data
);
echo json_encode($output);
