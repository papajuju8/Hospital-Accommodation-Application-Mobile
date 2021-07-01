<?php

include('../config_pdo.php');
include('movie_records.php');

if (isset($_POST["movie_id"])) {
    $statement = $connection->prepare("DELETE FROM movies WHERE MOVIE_ID = :id");
    $result = $statement->execute(
        array(':id'    =>    $_POST["movie_id"])
    );
    if ($result) {
        echo "Movie Delete Success.";
    } else {
        echo "Movie Delete Failed.";
    }
} else {
    echo "Movie Delete Error.";
}
