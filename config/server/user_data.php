<?php
include('../config_pdo.php');
include('user_records.php');

if (isset($_POST["account_id"])) {
    $output = array();

    $statement = $connection->prepare("SELECT * FROM users_account WHERE ACCOUNT_ID = '" . $_POST["account_id"] . "' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["account_id"] = $row["ACCOUNT_ID"];
        $output["username"] = $row["USERNAME"];
        $output["email"] = $row["EMAIL"];
        $output["password"] = $row["ACCOUNT_PASSWORD"];
        $output["type"] = $row["ADMIN"];
        $output["code"] = $row["VERIFY_CODE"];
        $output["active"] = $row["ACTIVE"];
    }

    $statement = $connection->prepare("SELECT * FROM users_profile WHERE ACCOUNT_ID = '" . $_POST["account_id"] . "' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["user_id"] = $row["USERS_ID"];
        $output["name"] = $row["FIRST_NAME"] . ' ' . $row["MI"] . ' ' . $row["LAST_NAME"];
        $output["contact"] = $row["CONTACT_NO"];
        $output["address"] = $row["ADDRESS"];
        $output["gender"] = $row["GENDER_ID"];
        $output["age"] = $row["AGE"];
        $output["birthdate"] = $row["BIRTHDATE"];
    }

    $statement = $connection->prepare("SELECT * FROM transaction WHERE ACCOUNT_ID = '" . $_POST["account_id"] . "' ORDER BY TRANS_ID DESC");
    $statement->execute();
    $result = $statement->fetchAll();
    $count = 0;
    foreach ($result as $row) {
        $trans_tDate = 'transac_tDate' . $count;
        $date = date_create($row["CREATED_ON"]);
        $output["$trans_tDate"] = date_format($date, "(D) M j, Y, g:i a");

        $trans_movie = 'transac_movie' . $count;
        if ($row["MOVIE_ID"] != 0) {
            $movie_id = $row["MOVIE_ID"];
            require_once '../config.php';
            $sql2 = "SELECT * FROM movies WHERE MOVIE_ID = '$movie_id' LIMIT 1";
            $res2 = mysqli_query($link,  $sql2);
            if (mysqli_num_rows($res2) > 0) {
                while ($row2 = mysqli_fetch_assoc($res2)) {
                    $output["$trans_movie"] = '(' . $row["MOVIE_ID"] . ') ' . $row2["MOVIE_TITLE"];
                }
            } else {
                $output["$trans_movie"] = "";
            }
        } else {
            $output["$trans_movie"] = $row["MOVIE_ID"];
        }

        $trans_branch = 'transac_branch' . $count;
        if ($row["BRANCH_ID"] == 1) {
            $output["$trans_branch"] = '<span class="text-primary">(1) Manila</span>';
        } else if ($row["BRANCH_ID"] == 2) {
            $output["$trans_branch"] = '<span class="text-danger">(2) Marikina</span>';
        } else if ($row["BRANCH_ID"] == 3) {
            $output["$trans_branch"] = '<span class="text-success">(3) North Edsa</span>';
        } else {
            $output["$trans_branch"] = '<span class="text-secondary">(4) Bacoor</span>';
        }

        $trans_cDate = 'transac_cDate' . $count;
        $date2 = date_create($row["DATE"]);
        $output["$trans_cDate"] = date_format($date2, "(D) M j, Y");

        $trans_time = 'transac_time' . $count;
        if ($row["TIME"] == 1) {
            $output["$trans_time"] = '<span class="text-primary">(1) 9:30 am</span>';
        } else if ($row["TIME"] == 2) {
            $output["$trans_time"] = '<span class="text-danger">(2) 1:00 pm</span>';
        } else {
            $output["$trans_time"] = '<span class="text-success">(3) 4:30 pm</span>';
        }

        $trans_seats = 'transac_seats' . $count;
        $output["$trans_seats"] = $row["SEATS"];

        $trans_price = 'transac_price' . $count;
        $output["$trans_price"] = '₱ ' . $row["PRICE"] . '.00';

        $count++;
    }
    $output["count"] = $count;
    if ($count == 0) {
        $output["count"] = "empty";
    }

    echo json_encode($output);
}
