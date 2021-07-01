<?php

include('../config_pdo.php');
include('sales_records.php');

// Fetch
$query = '';
$output = array();
$query .= "SELECT * FROM sales ";

if (isset($_POST["search"]["value"])) {
    $query .= 'WHERE MOVIE_ID LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR TOTAL_EARNINGS LIKE "%' . $_POST["search"]["value"] . '%" ';
}

$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach ($result as $row) {
    $sub_array = array();
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
    $sub_array[] = '₱ ' . $row["TOTAL_EARNINGS"] . '.00';
    $date = date_create($row["MODIFIED_ON"]);
    $sub_array[] = date_format($date, "(D) M j, Y, g:i a");

    $data[] = $sub_array;
}
$output = array(
    "draw"              =>  intval($_POST["draw"]),
    "recordsTotal"      =>  $filtered_rows,
    "recordsFiltered"   =>  get_total_all_records(),
    "data"              =>  $data
);
echo json_encode($output);
