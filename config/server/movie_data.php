<?php
include('../config_pdo.php');
include('movie_records.php');

if (isset($_POST["movie_id"])) {
    $output = array();

    $statement = $connection->prepare("SELECT * FROM movies WHERE MOVIE_ID = '" . $_POST["movie_id"] . "' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["movie_id"] = $row["MOVIE_ID"];
        $output["movie"] = $row["MOVIE_TITLE"];
        $output["description"] = $row["MOVIE_DESC"];
        $output["duration"] = $row["MOVIE_DURATION"];
        $output["rated"] = $row["RATED"];
        $output["rating_user"] = $row["RATING_USER"];
        $output["rating_title"] = $row["RATING_TITLE"];
        $output["poster"] = $row["POSTER"];
        $output["poster_bg"] = $row["POSTER_BG"];
        $output["trailer"] = $row["TRAILER"];
        $output["premiereDate"] = $row["PREMIERE_DATE"];
        $output["price"] = $row["PRICE"];
        $output["movie_active"] = $row["ACTIVE"];
    }

    $statement = $connection->prepare("SELECT * FROM genre WHERE MOVIE_ID = '" . $_POST["movie_id"] . "' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["action"] = $row["ACTION"];
        $output["adventure"] = $row["ADVENTURE"];
        $output["animation"] = $row["ANIMATION"];
        $output["comedy"] = $row["COMEDY"];
        $output["drama"] = $row["DRAMA"];
        $output["family"] = $row["FAMILY"];
        $output["fantasy"] = $row["FANTASY"];
        $output["horror"] = $row["HORROR"];
        $output["musical"] = $row["MUSICAL"];
        $output["mystery"] = $row["MYSTERY"];
        $output["romance"] = $row["ROMANCE"];
        $output["sci"] = $row["SCI_FI"];
        $output["thriller"] = $row["THRILLER"];
    }

    $statement = $connection->prepare("SELECT * FROM now_showing WHERE MOVIE_ID = '" . $_POST["movie_id"] . "' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["Manila"] = $row["B_MANILA"];
        $output["Marikina"] = $row["B_MARIKINA"];
        $output["North"] = $row["B_NORTH"];
        $output["Bacoor"] = $row["B_BACOOR"];
        $output["cinema_manila"] = $row["C_MANILA"];
        $output["cinema_marikina"] = $row["C_MARIKINA"];
        $output["cinema_north"] = $row["C_NORTH"];
        $output["cinema_bacoor"] = $row["C_BACOOR"];
    }

    echo json_encode($output);
}

if (isset($_POST["movie_active"])) {
    $output = array();

    // 1
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '1' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_1"] = $row["CINEMA_ID"];
        $output["act_1"] = $row["ACTIVE"];
    }

    // 2
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '2' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_2"] = $row["CINEMA_ID"];
        $output["act_2"] = $row["ACTIVE"];
    }

    // 3
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '3' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_3"] = $row["CINEMA_ID"];
        $output["act_3"] = $row["ACTIVE"];
    }

    // 4
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '4' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_4"] = $row["CINEMA_ID"];
        $output["act_4"] = $row["ACTIVE"];
    }

    // 5
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '5' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_5"] = $row["CINEMA_ID"];
        $output["act_5"] = $row["ACTIVE"];
    }

    // 6
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '6' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_6"] = $row["CINEMA_ID"];
        $output["act_6"] = $row["ACTIVE"];
    }

    // 7
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '7' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_7"] = $row["CINEMA_ID"];
        $output["act_7"] = $row["ACTIVE"];
    }

    // 8
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '8' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_8"] = $row["CINEMA_ID"];
        $output["act_8"] = $row["ACTIVE"];
    }

    // 9
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '9' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_9"] = $row["CINEMA_ID"];
        $output["act_9"] = $row["ACTIVE"];
    }

    // 10
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '10' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_10"] = $row["CINEMA_ID"];
        $output["act_10"] = $row["ACTIVE"];
    }

    // 11
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '11' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_11"] = $row["CINEMA_ID"];
        $output["act_11"] = $row["ACTIVE"];
    }

    // 12
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '12' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_12"] = $row["CINEMA_ID"];
        $output["act_12"] = $row["ACTIVE"];
    }

    // 13
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '13' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_13"] = $row["CINEMA_ID"];
        $output["act_13"] = $row["ACTIVE"];
    }

    // 14
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '14' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_14"] = $row["CINEMA_ID"];
        $output["act_14"] = $row["ACTIVE"];
    }

    // 15
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '15' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_15"] = $row["CINEMA_ID"];
        $output["act_15"] = $row["ACTIVE"];
    }

    // 16
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '16' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_16"] = $row["CINEMA_ID"];
        $output["act_16"] = $row["ACTIVE"];
    }

    // 17
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '17' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_17"] = $row["CINEMA_ID"];
        $output["act_17"] = $row["ACTIVE"];
    }

    // 18
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '18' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_18"] = $row["CINEMA_ID"];
        $output["act_18"] = $row["ACTIVE"];
    }

    // 19
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '19' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_19"] = $row["CINEMA_ID"];
        $output["act_19"] = $row["ACTIVE"];
    }

    // 20
    $statement = $connection->prepare("SELECT * FROM cinema WHERE CINEMA_ID = '20' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["id_20"] = $row["CINEMA_ID"];
        $output["act_20"] = $row["ACTIVE"];
    }

    echo json_encode($output);
}
