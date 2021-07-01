<?php
include('../config_pdo.php');
include('transaction_records.php');
session_start();

if (isset($_POST)) {
    date_default_timezone_set('Asia/Manila');
    $dt = new DateTime();
    $today = $dt->format('Y-m-d H:i:s');

    $stmt = $connection->query("SELECT * FROM sales WHERE MOVIE_ID = '" . $_POST["movie_id"] . "'");
    while ($row = $stmt->fetch()) {
        $curr_price = $row["TOTAL_EARNINGS"];
    }

    // SALES
    $statement = $connection->prepare("UPDATE sales SET TOTAL_EARNINGS = :price, MODIFIED_ON = :today WHERE MOVIE_ID = :id");
    $result = $statement->execute(
        array(
            ':price'   =>  $curr_price + $_POST["price"],
            ':today' =>  $today,
            ':id' => $_POST["movie_id"]
        )
    );

    // TRANSACTION
    $statement = $connection->prepare("INSERT INTO transaction (ACCOUNT_ID, MOVIE_ID, BRANCH_ID, DATE, TIME, SEATS, PRICE) VALUES (:id, :movie_id, :branch, :date, :time, :seats, :price)");
    $result = $statement->execute(
        array(
            ':id'   =>  $_SESSION["id"],
            ':movie_id' =>  $_POST["movie_id"],
            ':branch' =>  $_POST["theater"],
            ':date' =>  $_POST["date"],
            ':time' =>  $_POST["time"],
            ':seats' =>  $_POST["quantity"],
            ':price' =>  $_POST["price"]
        )
    );

    $stmt = $connection->query("SELECT * FROM now_showing WHERE MOVIE_ID = '" . $_POST["movie_id"] . "'");
    while ($row = $stmt->fetch()) {
        if ($row["B_MANILA"] == 1) {
            $cinema = $row["C_MANILA"];
        }
        if ($row["B_MARIKINA"] == 2) {
            $cinema = $row["C_MARIKINA"];
        }
        if ($row["B_NORTH"] == 3) {
            $cinema = $row["C_NORTH"];
        }
        if ($row["B_BACOOR"] == 4) {
            $cinema = $row["C_BACOOR"];
        }
    }

    // RESERVATION
    // A
    if ($_POST["seat_a1"]) {
        $statement = $connection->prepare("UPDATE reservation SET A1 = :a1, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':a1'   =>  $_POST["seat_a1"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_a2"]) {
        $statement = $connection->prepare("UPDATE reservation SET A2 = :a2, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':a2'   =>  $_POST["seat_a2"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_a3"]) {
        $statement = $connection->prepare("UPDATE reservation SET A3 = :a3, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':a3'   =>  $_POST["seat_a3"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_a4"]) {
        $statement = $connection->prepare("UPDATE reservation SET A4 = :a4, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':a4'   =>  $_POST["seat_a4"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_a5"]) {
        $statement = $connection->prepare("UPDATE reservation SET A5 = :a5, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':a5'   =>  $_POST["seat_a5"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_a6"]) {
        $statement = $connection->prepare("UPDATE reservation SET A6 = :a6, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':a6'   =>  $_POST["seat_a6"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_a7"]) {
        $statement = $connection->prepare("UPDATE reservation SET A7 = :a7, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':a7'   =>  $_POST["seat_a7"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_a8"]) {
        $statement = $connection->prepare("UPDATE reservation SET A8 = :a8, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':a8'   =>  $_POST["seat_a8"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    // B
    if ($_POST["seat_b1"]) {
        $statement = $connection->prepare("UPDATE reservation SET B1 = :b1, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':b1'   =>  $_POST["seat_b1"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_b2"]) {
        $statement = $connection->prepare("UPDATE reservation SET B2 = :b2, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':b2'   =>  $_POST["seat_b2"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_b3"]) {
        $statement = $connection->prepare("UPDATE reservation SET B3 = :b3, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':b3'   =>  $_POST["seat_b3"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_b4"]) {
        $statement = $connection->prepare("UPDATE reservation SET B4 = :b4, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':b4'   =>  $_POST["seat_b4"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_b5"]) {
        $statement = $connection->prepare("UPDATE reservation SET B5 = :b5, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':b5'   =>  $_POST["seat_b5"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_b6"]) {
        $statement = $connection->prepare("UPDATE reservation SET B6 = :b6, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':b6'   =>  $_POST["seat_b6"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_b7"]) {
        $statement = $connection->prepare("UPDATE reservation SET B7 = :b7, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':b7'   =>  $_POST["seat_b7"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_b8"]) {
        $statement = $connection->prepare("UPDATE reservation SET B8 = :b8, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':b8'   =>  $_POST["seat_b8"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_b9"]) {
        $statement = $connection->prepare("UPDATE reservation SET B9 = :b9, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':b9'   =>  $_POST["seat_b9"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_b10"]) {
        $statement = $connection->prepare("UPDATE reservation SET B10 = :b10, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':b10'   =>  $_POST["seat_b10"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    // C
    if ($_POST["seat_c1"]) {
        $statement = $connection->prepare("UPDATE reservation SET C1 = :c1, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':c1'   =>  $_POST["seat_c1"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_c2"]) {
        $statement = $connection->prepare("UPDATE reservation SET C2 = :c2, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':c2'   =>  $_POST["seat_c2"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_c3"]) {
        $statement = $connection->prepare("UPDATE reservation SET C3 = :c3, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':c3'   =>  $_POST["seat_c3"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_c4"]) {
        $statement = $connection->prepare("UPDATE reservation SET C4 = :c4, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':c4'   =>  $_POST["seat_c4"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_c5"]) {
        $statement = $connection->prepare("UPDATE reservation SET C5 = :c5, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':c5'   =>  $_POST["seat_c5"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_c6"]) {
        $statement = $connection->prepare("UPDATE reservation SET C6 = :c6, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':c6'   =>  $_POST["seat_c6"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_c7"]) {
        $statement = $connection->prepare("UPDATE reservation SET C7 = :c7, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':c7'   =>  $_POST["seat_c7"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_c8"]) {
        $statement = $connection->prepare("UPDATE reservation SET C8 = :c8, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':c8'   =>  $_POST["seat_c8"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_c9"]) {
        $statement = $connection->prepare("UPDATE reservation SET C9 = :c9, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':c9'   =>  $_POST["seat_c9"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_c10"]) {
        $statement = $connection->prepare("UPDATE reservation SET C10 = :c10, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':c10'   =>  $_POST["seat_c10"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    // D
    if ($_POST["seat_d1"]) {
        $statement = $connection->prepare("UPDATE reservation SET D1 = :d1, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':d1'   =>  $_POST["seat_d1"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_d2"]) {
        $statement = $connection->prepare("UPDATE reservation SET D2 = :d2, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':d2'   =>  $_POST["seat_d2"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_d3"]) {
        $statement = $connection->prepare("UPDATE reservation SET D3 = :d3, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':d3'   =>  $_POST["seat_d3"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_d4"]) {
        $statement = $connection->prepare("UPDATE reservation SET D4 = :d4, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':d4'   =>  $_POST["seat_d4"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_d5"]) {
        $statement = $connection->prepare("UPDATE reservation SET D5 = :d5, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':d5'   =>  $_POST["seat_d5"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_d6"]) {
        $statement = $connection->prepare("UPDATE reservation SET D6 = :d6, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':d6'   =>  $_POST["seat_d6"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_d7"]) {
        $statement = $connection->prepare("UPDATE reservation SET D7 = :d7, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':d7'   =>  $_POST["seat_d7"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_d8"]) {
        $statement = $connection->prepare("UPDATE reservation SET D8 = :d8, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':d8'   =>  $_POST["seat_d8"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    // E
    if ($_POST["seat_e1"]) {
        $statement = $connection->prepare("UPDATE reservation SET E1 = :e1, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':e1'   =>  $_POST["seat_e1"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_e2"]) {
        $statement = $connection->prepare("UPDATE reservation SET E2 = :e2, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':e2'   =>  $_POST["seat_e2"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_e3"]) {
        $statement = $connection->prepare("UPDATE reservation SET E3 = :e3, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':e3'   =>  $_POST["seat_e3"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_e4"]) {
        $statement = $connection->prepare("UPDATE reservation SET E4 = :e4, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':e4'   =>  $_POST["seat_e4"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_e5"]) {
        $statement = $connection->prepare("UPDATE reservation SET E5 = :e5, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':e5'   =>  $_POST["seat_e5"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_e6"]) {
        $statement = $connection->prepare("UPDATE reservation SET E6 = :e6, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':e6'   =>  $_POST["seat_e6"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_e7"]) {
        $statement = $connection->prepare("UPDATE reservation SET E7 = :e7, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':e7'   =>  $_POST["seat_e7"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_e8"]) {
        $statement = $connection->prepare("UPDATE reservation SET E8 = :e8, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':e8'   =>  $_POST["seat_e8"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    // F
    if ($_POST["seat_f1"]) {
        $statement = $connection->prepare("UPDATE reservation SET F1 = :f1, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':f1'   =>  $_POST["seat_f1"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_f2"]) {
        $statement = $connection->prepare("UPDATE reservation SET F2 = :f2, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':f2'   =>  $_POST["seat_f2"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_f3"]) {
        $statement = $connection->prepare("UPDATE reservation SET F3 = :f3, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':f3'   =>  $_POST["seat_f3"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_f4"]) {
        $statement = $connection->prepare("UPDATE reservation SET F4 = :f4, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':f4'   =>  $_POST["seat_f4"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_f5"]) {
        $statement = $connection->prepare("UPDATE reservation SET F5 = :f5, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':f5'   =>  $_POST["seat_f5"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_f6"]) {
        $statement = $connection->prepare("UPDATE reservation SET F6 = :f6, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':f6'   =>  $_POST["seat_f6"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_f7"]) {
        $statement = $connection->prepare("UPDATE reservation SET F7 = :f7, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':f7'   =>  $_POST["seat_f7"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_f8"]) {
        $statement = $connection->prepare("UPDATE reservation SET F8 = :f8, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':f8'   =>  $_POST["seat_f8"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_f9"]) {
        $statement = $connection->prepare("UPDATE reservation SET F9 = :f9, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':f9'   =>  $_POST["seat_f9"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_f10"]) {
        $statement = $connection->prepare("UPDATE reservation SET F10 = :f10, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':f10'   =>  $_POST["seat_f10"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    // G
    if ($_POST["seat_g1"]) {
        $statement = $connection->prepare("UPDATE reservation SET G1 = :g1, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':g1'   =>  $_POST["seat_g1"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_g2"]) {
        $statement = $connection->prepare("UPDATE reservation SET G2 = :g2, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':g2'   =>  $_POST["seat_g2"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_g3"]) {
        $statement = $connection->prepare("UPDATE reservation SET G3 = :g3, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':g3'   =>  $_POST["seat_g3"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_g4"]) {
        $statement = $connection->prepare("UPDATE reservation SET G4 = :g4, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':g4'   =>  $_POST["seat_g4"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_g5"]) {
        $statement = $connection->prepare("UPDATE reservation SET G5 = :g5, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':g5'   =>  $_POST["seat_g5"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_g6"]) {
        $statement = $connection->prepare("UPDATE reservation SET G6 = :g6, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':g6'   =>  $_POST["seat_g6"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_g7"]) {
        $statement = $connection->prepare("UPDATE reservation SET G7 = :g7, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':g7'   =>  $_POST["seat_g7"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_g8"]) {
        $statement = $connection->prepare("UPDATE reservation SET G8 = :g8, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':g8'   =>  $_POST["seat_g8"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_g9"]) {
        $statement = $connection->prepare("UPDATE reservation SET G9 = :g9, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':g9'   =>  $_POST["seat_g9"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_g10"]) {
        $statement = $connection->prepare("UPDATE reservation SET G10 = :g10, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':g10'   =>  $_POST["seat_g10"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    // H
    if ($_POST["seat_h1"]) {
        $statement = $connection->prepare("UPDATE reservation SET H1 = :h1, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':h1'   =>  $_POST["seat_h1"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_h2"]) {
        $statement = $connection->prepare("UPDATE reservation SET H2 = :h2, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':h2'   =>  $_POST["seat_h2"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_h3"]) {
        $statement = $connection->prepare("UPDATE reservation SET H3 = :h3, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':h3'   =>  $_POST["seat_h3"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_h4"]) {
        $statement = $connection->prepare("UPDATE reservation SET H4 = :h4, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':h4'   =>  $_POST["seat_h4"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_h5"]) {
        $statement = $connection->prepare("UPDATE reservation SET H5 = :h5, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':h5'   =>  $_POST["seat_h5"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_h6"]) {
        $statement = $connection->prepare("UPDATE reservation SET H6 = :h6, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':h6'   =>  $_POST["seat_h6"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_h7"]) {
        $statement = $connection->prepare("UPDATE reservation SET H7 = :h7, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':h7'   =>  $_POST["seat_h7"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_h8"]) {
        $statement = $connection->prepare("UPDATE reservation SET H8 = :h8, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':h8'   =>  $_POST["seat_h8"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_h9"]) {
        $statement = $connection->prepare("UPDATE reservation SET H9 = :h9, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':h9'   =>  $_POST["seat_h9"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }
    if ($_POST["seat_h10"]) {
        $statement = $connection->prepare("UPDATE reservation SET H10 = :h10, MODIFIED_ON = :today WHERE MOVIE_ID = :id AND BRANCH_ID = :branch AND CINEMA_NO = '$cinema' AND DAY = :day AND TIME = :time");
        $result = $statement->execute(
            array(
                ':h10'   =>  $_POST["seat_h10"],
                ':today' =>  $today,
                ':id' => $_POST["movie_id"],
                ':branch' => $_POST["theater"],
                ':day' => $_POST["day"],
                ':time' => $_POST["time"]
            )
        );
    }

    // EMAIL
    $stmt = $connection->query("SELECT * FROM users_account WHERE ACCOUNT_ID = '" . $_SESSION["id"] . "'");
    while ($row = $stmt->fetch()) {
        $_SESSION["send_email"] = $row["EMAIL"];
    }
    $stmt = $connection->query("SELECT * FROM movies WHERE MOVIE_ID = '" . $_POST["movie_id"] . "'");
    while ($row = $stmt->fetch()) {
        $_SESSION["send_movie"] = $row["MOVIE_TITLE"];
    }
    if ($_POST["theater"] == 1) {
        $_SESSION["send_branch"] = "SM Manila";
    } else if ($_POST["theater"] == 2) {
        $_SESSION["send_branch"] = "SM Marikina";
    } else if ($_POST["theater"] == 3) {
        $_SESSION["send_branch"] = "SM North Edsa";
    } else {
        $_SESSION["send_branch"] = "SM Bacoor";
    }
    $date = date_create($_POST["date"]);
    $_SESSION["send_date"] = date_format($date, "F d, Y");
    if ($_POST["time"] == 1) {
        $_SESSION["send_time"] = "9:30 am";
    } else if ($_POST["time"] == 2) {
        $_SESSION["send_time"] = "1:00 pm";
    } else {
        $_SESSION["send_time"] = "4:30 pm";
    }
    $_SESSION["send_quantity"] = $_POST["quantity"];
    $_SESSION["send_seats"] = $_POST["seats"];
    $_SESSION["send_price"] = $_POST["price"];
    $_SESSION["send"] = "send";
}
