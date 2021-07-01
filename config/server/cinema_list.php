<?php

include('../config_pdo.php');
include('cinema_records.php');

// Fetch
$query = '';
$output = array();
$query .= "SELECT * FROM cinema ";

if (isset($_POST["search"]["value"])) {
    $query .= 'WHERE CINEMA_NO LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR NO_SEATS LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR MOVIE_ID LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR ACTIVE LIKE "%' . $_POST["search"]["value"] . '%" ';
}

$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach ($result as $row) {
    $sub_array = array();
    if ($row["BRANCH_ID"] == 1) {
        $sub_array[] = '<span class="text-primary">(1) Manila</span>';
    } else if ($row["BRANCH_ID"] == 2) {
        $sub_array[] = '<span class="text-danger">(2) Marikina</span>';
    } else if ($row["BRANCH_ID"] == 3) {
        $sub_array[] = '<span class="text-success">(3) North Edsa</span>';
    } else {
        $sub_array[] = '<span class="text-secondary">(4) Bacoor</span>';
    }
    $sub_array[] = $row["CINEMA_NO"];
    $sub_array[] = $row["NO_SEATS"];
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

    if ($row["ACTIVE"] == 0) {
        $sub_array[] = '<span class="text-danger">(0) Inactive</span>';
    } else {
        $sub_array[] = '<span class="text-success">(1) Active</span>';
    }

    $data[] = $sub_array;
}
$output = array(
    "draw"              =>  intval($_POST["draw"]),
    "recordsTotal"      =>  $filtered_rows,
    "recordsFiltered"   =>  get_total_all_records(),
    "data"              =>  $data
);
echo json_encode($output);
