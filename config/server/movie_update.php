<?php
include('../config_pdo.php');
include('movie_records.php');

if (isset($_POST["operation"])) {
    date_default_timezone_set('Asia/Manila');
    $dt = new DateTime();
    $today = $dt->format('Y-m-d H:i:s');

    if ($_POST["operation"] == "Add") {
        if (isset($_FILES['movie_image']) && isset($_FILES['movie_image_bg'])) {
            $img_name = $_FILES['movie_image']['name'];
            $tmp_name = $_FILES['movie_image']['tmp_name'];

            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {

                // MOVIE
                $statement = $connection->prepare("INSERT INTO movies (MOVIE_TITLE, MOVIE_DESC, MOVIE_DURATION, RATED, RATING_USER, RATING_TITLE, TRAILER, PREMIERE_DATE, PRICE, ACTIVE) VALUES (:movie, :description, :duration, :rated, :rating_user, :rating_title, :trailer, :premiereDate, :price, :movie_active)");
                $result = $statement->execute(
                    array(
                        ':movie'   =>  $_POST["movie"],
                        ':description' =>  $_POST["description"],
                        ':duration' =>  $_POST["duration"],
                        ':rated' =>  $_POST["rated"],
                        ':rating_user' =>  $_POST["rating_user"],
                        ':rating_title' =>  $_POST["rating_title"],
                        ':trailer' =>  $_POST["trailer"],
                        ':premiereDate' =>  $_POST["premiereDate"],
                        ':price' =>  $_POST["price"],
                        ':movie_active' =>  $_POST["movie_active"]
                    )
                );

                $stmt = $connection->query("SELECT * FROM movies");
                while ($row = $stmt->fetch()) {
                    if ($row['MOVIE_TITLE'] == $_POST["movie"]) {
                        $curr_id = $row['MOVIE_ID'];
                        $active = $row["ACTIVE"];
                    }
                }

                // GENRE
                $statement = $connection->prepare("INSERT INTO genre (MOVIE_ID, ACTION, ADVENTURE, ANIMATION, COMEDY, DRAMA, FAMILY, FANTASY, HORROR, MUSICAL, MYSTERY, ROMANCE, SCI_FI, THRILLER) VALUES ('$curr_id', :action_, :adventure, :animation, :comedy, :drama, :family, :fantasy, :horror, :musical, :mystery, :romance, :sci, :thriller)");
                $result = $statement->execute(
                    array(
                        ':action_'   =>  $_POST["action_"],
                        ':adventure' =>  $_POST["adventure"],
                        ':animation' =>  $_POST["animation"],
                        ':comedy' =>  $_POST["comedy"],
                        ':drama' =>  $_POST["drama"],
                        ':family' =>  $_POST["family"],
                        ':fantasy' =>  $_POST["fantasy"],
                        ':horror' =>  $_POST["horror"],
                        ':musical' =>  $_POST["musical"],
                        ':mystery' =>  $_POST["mystery"],
                        ':romance' =>  $_POST["romance"],
                        ':sci' =>  $_POST["sci"],
                        ':thriller' =>  $_POST["thriller"]
                    )
                );

                // POSTER
                $new_img_name = uniqid("T1-", true) . '.' . $img_ex_lc;
                $img_upload_path = '../../images/movies/poster/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                $statement = $connection->prepare("UPDATE movies SET POSTER = ? WHERE MOVIE_ID = ?");
                $result = $statement->execute([$new_img_name, $curr_id]);

                // POSTER BG
                $img_name = $_FILES['movie_image_bg']['name'];
                $tmp_name = $_FILES['movie_image_bg']['tmp_name'];
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("T1-BG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = '../../images/movies/poster_bg/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
                    $statement = $connection->prepare("UPDATE movies SET POSTER_BG = ? WHERE MOVIE_ID = ?");
                    $result = $statement->execute([$new_img_name, $curr_id]);
                }

                // SALES
                $statement = $connection->prepare("INSERT INTO sales (MOVIE_ID) VALUES ('$curr_id')");
                $result = $statement->execute();

                // INACTIVE
                if ($active == 0) {
                    $statement = $connection->prepare("INSERT INTO coming_soon (MOVIE_ID, ACTIVE) VALUES ('$curr_id', '0')");
                    $result = $statement->execute();
                    $statement = $connection->prepare("INSERT INTO now_showing (MOVIE_ID, ACTIVE) VALUES ('$curr_id', '0')");
                    $result = $statement->execute();
                }

                // COMING SOON
                else if ($active == 1) {
                    $statement = $connection->prepare("INSERT INTO coming_soon (MOVIE_ID, ACTIVE) VALUES ('$curr_id', '1')");
                    $result = $statement->execute();
                    $statement = $connection->prepare("INSERT INTO now_showing (MOVIE_ID, ACTIVE) VALUES ('$curr_id', '0')");
                    $result = $statement->execute();
                }

                // NOW SHOWING
                else if ($active == 2) {
                    $statement = $connection->prepare("INSERT INTO coming_soon (MOVIE_ID, ACTIVE) VALUES ('$curr_id', '0')");
                    $result = $statement->execute();
                    $statement = $connection->prepare("INSERT INTO now_showing (MOVIE_ID, B_MANILA, B_MARIKINA, B_NORTH, B_BACOOR, C_MANILA, C_MARIKINA, C_NORTH, C_BACOOR, ACTIVE) VALUES ('$curr_id', :Manila, :Marikina, :North, :Bacoor, :cinema_manila, :cinema_marikina, :cinema_north, :cinema_bacoor, '1')");
                    $result = $statement->execute(
                        array(
                            ':Manila'   =>  $_POST["Manila"],
                            ':Marikina' =>  $_POST["Marikina"],
                            ':North' =>  $_POST["North"],
                            ':Bacoor' =>  $_POST["Bacoor"],
                            ':cinema_manila' =>  $_POST["cinema_manila"],
                            ':cinema_marikina' =>  $_POST["cinema_marikina"],
                            ':cinema_north' =>  $_POST["cinema_north"],
                            ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                        )
                    );

                    // CINEMA
                    $manila = $_POST["Manila"];
                    $marikina = $_POST["Marikina"];
                    $north = $_POST["North"];
                    $bacoor = $_POST["Bacoor"];

                    if ($manila == 1 && isset($_POST["Manila"])) {
                        $statement = $connection->prepare("UPDATE cinema SET MOVIE_ID = '$curr_id', ACTIVE = '1', MODIFIED_ON = '$today' WHERE BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                        $result = $statement->execute(
                            array(
                                ':cinema_manila' =>  $_POST["cinema_manila"]
                            )
                        );

                        // RESERVATION
                        $statement = $connection->prepare("UPDATE reservation SET MOVIE_ID = '$curr_id', MODIFIED_ON = '$today' WHERE BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                        $result = $statement->execute(
                            array(
                                ':cinema_manila' =>  $_POST["cinema_manila"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET A1 = :a1, A2 = :a2, A3 = :a3, A4 = :a4, A5 = :a5, A6 = :a6, A7 = :a7, A8 = :a8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                        $result = $statement->execute(
                            array(
                                ':a1' =>  $reset,
                                ':a2' =>  $reset,
                                ':a3' =>  $reset,
                                ':a4' =>  $reset,
                                ':a5' =>  $reset,
                                ':a6' =>  $reset,
                                ':a7' =>  $reset,
                                ':a8' =>  $reset,
                                ':cinema_manila' =>  $_POST["cinema_manila"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET B1 = :b1, B2 = :b2, B3 = :b3, B4 = :b4, B5 = :b5, B6 = :b6, B7 = :b7, B8 = :b8, B9 = :b9, B10 = :b10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                        $result = $statement->execute(
                            array(
                                ':b1' =>  $reset,
                                ':b2' =>  $reset,
                                ':b3' =>  $reset,
                                ':b4' =>  $reset,
                                ':b5' =>  $reset,
                                ':b6' =>  $reset,
                                ':b7' =>  $reset,
                                ':b8' =>  $reset,
                                ':b9' =>  $reset,
                                ':b10' =>  $reset,
                                ':cinema_manila' =>  $_POST["cinema_manila"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET C1 = :c1, C2 = :c2, C3 = :c3, C4 = :c4, C5 = :c5, C6 = :c6, C7 = :c7, C8 = :c8, C9 = :c9, C10 = :c10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                        $result = $statement->execute(
                            array(
                                ':c1' =>  $reset,
                                ':c2' =>  $reset,
                                ':c3' =>  $reset,
                                ':c4' =>  $reset,
                                ':c5' =>  $reset,
                                ':c6' =>  $reset,
                                ':c7' =>  $reset,
                                ':c8' =>  $reset,
                                ':c9' =>  $reset,
                                ':c10' =>  $reset,
                                ':cinema_manila' =>  $_POST["cinema_manila"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET D1 = :d1, D2 = :d2, D3 = :d3, D4 = :d4, D5 = :d5, D6 = :d6, D7 = :d7, D8 = :d8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                        $result = $statement->execute(
                            array(
                                ':d1' =>  $reset,
                                ':d2' =>  $reset,
                                ':d3' =>  $reset,
                                ':d4' =>  $reset,
                                ':d5' =>  $reset,
                                ':d6' =>  $reset,
                                ':d7' =>  $reset,
                                ':d8' =>  $reset,
                                ':cinema_manila' =>  $_POST["cinema_manila"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET E1 = :e1, E2 = :e2, E3 = :e3, E4 = :e4, E5 = :e5, E6 = :e6, E7 = :e7, E8 = :e8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                        $result = $statement->execute(
                            array(
                                ':e1' =>  $reset,
                                ':e2' =>  $reset,
                                ':e3' =>  $reset,
                                ':e4' =>  $reset,
                                ':e5' =>  $reset,
                                ':e6' =>  $reset,
                                ':e7' =>  $reset,
                                ':e8' =>  $reset,
                                ':cinema_manila' =>  $_POST["cinema_manila"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET F1 = :f1, F2 = :f2, F3 = :f3, F4 = :f4, F5 = :f5, F6 = :f6, F7 = :f7, F8 = :f8, F9 = :f9, F10 = :f10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                        $result = $statement->execute(
                            array(
                                ':f1' =>  $reset,
                                ':f2' =>  $reset,
                                ':f3' =>  $reset,
                                ':f4' =>  $reset,
                                ':f5' =>  $reset,
                                ':f6' =>  $reset,
                                ':f7' =>  $reset,
                                ':f8' =>  $reset,
                                ':f9' =>  $reset,
                                ':f10' =>  $reset,
                                ':cinema_manila' =>  $_POST["cinema_manila"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET G1 = :g1, G2 = :g2, G3 = :g3, G4 = :g4, G5 = :g5, G6 = :g6, G7 = :g7, G8 = :g8, G9 = :g9, G10 = :g10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                        $result = $statement->execute(
                            array(
                                ':g1' =>  $reset,
                                ':g2' =>  $reset,
                                ':g3' =>  $reset,
                                ':g4' =>  $reset,
                                ':g5' =>  $reset,
                                ':g6' =>  $reset,
                                ':g7' =>  $reset,
                                ':g8' =>  $reset,
                                ':g9' =>  $reset,
                                ':g10' =>  $reset,
                                ':cinema_manila' =>  $_POST["cinema_manila"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET H1 = :h1, H2 = :h2, H3 = :h3, H4 = :h4, H5 = :h5, H6 = :h6, H7 = :h7, H8 = :h8, H9 = :h9, H10 = :h10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                        $result = $statement->execute(
                            array(
                                ':h1' =>  $reset,
                                ':h2' =>  $reset,
                                ':h3' =>  $reset,
                                ':h4' =>  $reset,
                                ':h5' =>  $reset,
                                ':h6' =>  $reset,
                                ':h7' =>  $reset,
                                ':h8' =>  $reset,
                                ':h9' =>  $reset,
                                ':h10' =>  $reset,
                                ':cinema_manila' =>  $_POST["cinema_manila"]
                            )
                        );
                    }
                    if ($marikina == 2 && isset($_POST["Marikina"])) {
                        $statement = $connection->prepare("UPDATE cinema SET MOVIE_ID = '$curr_id', ACTIVE = '1', MODIFIED_ON = '$today' WHERE BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                        $result = $statement->execute(
                            array(
                                ':cinema_marikina' =>  $_POST["cinema_marikina"]
                            )
                        );

                        // RESERVATION
                        $statement = $connection->prepare("UPDATE reservation SET MOVIE_ID = '$curr_id', MODIFIED_ON = '$today' WHERE BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                        $result = $statement->execute(
                            array(
                                ':cinema_marikina' =>  $_POST["cinema_marikina"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET A1 = :a1, A2 = :a2, A3 = :a3, A4 = :a4, A5 = :a5, A6 = :a6, A7 = :a7, A8 = :a8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                        $result = $statement->execute(
                            array(
                                ':a1' =>  $reset,
                                ':a2' =>  $reset,
                                ':a3' =>  $reset,
                                ':a4' =>  $reset,
                                ':a5' =>  $reset,
                                ':a6' =>  $reset,
                                ':a7' =>  $reset,
                                ':a8' =>  $reset,
                                ':cinema_marikina' =>  $_POST["cinema_marikina"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET B1 = :b1, B2 = :b2, B3 = :b3, B4 = :b4, B5 = :b5, B6 = :b6, B7 = :b7, B8 = :b8, B9 = :b9, B10 = :b10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                        $result = $statement->execute(
                            array(
                                ':b1' =>  $reset,
                                ':b2' =>  $reset,
                                ':b3' =>  $reset,
                                ':b4' =>  $reset,
                                ':b5' =>  $reset,
                                ':b6' =>  $reset,
                                ':b7' =>  $reset,
                                ':b8' =>  $reset,
                                ':b9' =>  $reset,
                                ':b10' =>  $reset,
                                ':cinema_marikina' =>  $_POST["cinema_marikina"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET C1 = :c1, C2 = :c2, C3 = :c3, C4 = :c4, C5 = :c5, C6 = :c6, C7 = :c7, C8 = :c8, C9 = :c9, C10 = :c10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                        $result = $statement->execute(
                            array(
                                ':c1' =>  $reset,
                                ':c2' =>  $reset,
                                ':c3' =>  $reset,
                                ':c4' =>  $reset,
                                ':c5' =>  $reset,
                                ':c6' =>  $reset,
                                ':c7' =>  $reset,
                                ':c8' =>  $reset,
                                ':c9' =>  $reset,
                                ':c10' =>  $reset,
                                ':cinema_marikina' =>  $_POST["cinema_marikina"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET D1 = :d1, D2 = :d2, D3 = :d3, D4 = :d4, D5 = :d5, D6 = :d6, D7 = :d7, D8 = :d8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                        $result = $statement->execute(
                            array(
                                ':d1' =>  $reset,
                                ':d2' =>  $reset,
                                ':d3' =>  $reset,
                                ':d4' =>  $reset,
                                ':d5' =>  $reset,
                                ':d6' =>  $reset,
                                ':d7' =>  $reset,
                                ':d8' =>  $reset,
                                ':cinema_marikina' =>  $_POST["cinema_marikina"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET E1 = :e1, E2 = :e2, E3 = :e3, E4 = :e4, E5 = :e5, E6 = :e6, E7 = :e7, E8 = :e8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                        $result = $statement->execute(
                            array(
                                ':e1' =>  $reset,
                                ':e2' =>  $reset,
                                ':e3' =>  $reset,
                                ':e4' =>  $reset,
                                ':e5' =>  $reset,
                                ':e6' =>  $reset,
                                ':e7' =>  $reset,
                                ':e8' =>  $reset,
                                ':cinema_marikina' =>  $_POST["cinema_marikina"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET F1 = :f1, F2 = :f2, F3 = :f3, F4 = :f4, F5 = :f5, F6 = :f6, F7 = :f7, F8 = :f8, F9 = :f9, F10 = :f10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                        $result = $statement->execute(
                            array(
                                ':f1' =>  $reset,
                                ':f2' =>  $reset,
                                ':f3' =>  $reset,
                                ':f4' =>  $reset,
                                ':f5' =>  $reset,
                                ':f6' =>  $reset,
                                ':f7' =>  $reset,
                                ':f8' =>  $reset,
                                ':f9' =>  $reset,
                                ':f10' =>  $reset,
                                ':cinema_marikina' =>  $_POST["cinema_marikina"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET G1 = :g1, G2 = :g2, G3 = :g3, G4 = :g4, G5 = :g5, G6 = :g6, G7 = :g7, G8 = :g8, G9 = :g9, G10 = :g10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                        $result = $statement->execute(
                            array(
                                ':g1' =>  $reset,
                                ':g2' =>  $reset,
                                ':g3' =>  $reset,
                                ':g4' =>  $reset,
                                ':g5' =>  $reset,
                                ':g6' =>  $reset,
                                ':g7' =>  $reset,
                                ':g8' =>  $reset,
                                ':g9' =>  $reset,
                                ':g10' =>  $reset,
                                ':cinema_marikina' =>  $_POST["cinema_marikina"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET H1 = :h1, H2 = :h2, H3 = :h3, H4 = :h4, H5 = :h5, H6 = :h6, H7 = :h7, H8 = :h8, H9 = :h9, H10 = :h10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                        $result = $statement->execute(
                            array(
                                ':h1' =>  $reset,
                                ':h2' =>  $reset,
                                ':h3' =>  $reset,
                                ':h4' =>  $reset,
                                ':h5' =>  $reset,
                                ':h6' =>  $reset,
                                ':h7' =>  $reset,
                                ':h8' =>  $reset,
                                ':h9' =>  $reset,
                                ':h10' =>  $reset,
                                ':cinema_marikina' =>  $_POST["cinema_marikina"]
                            )
                        );
                    }
                    if ($north == 3 && isset($_POST["North"])) {
                        $statement = $connection->prepare("UPDATE cinema SET MOVIE_ID = '$curr_id', ACTIVE = '1', MODIFIED_ON = '$today' WHERE BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                        $result = $statement->execute(
                            array(
                                ':cinema_north' =>  $_POST["cinema_north"]
                            )
                        );

                        // RESERVATION
                        $statement = $connection->prepare("UPDATE reservation SET MOVIE_ID = '$curr_id', MODIFIED_ON = '$today' WHERE BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                        $result = $statement->execute(
                            array(
                                ':cinema_north' =>  $_POST["cinema_north"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET A1 = :a1, A2 = :a2, A3 = :a3, A4 = :a4, A5 = :a5, A6 = :a6, A7 = :a7, A8 = :a8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                        $result = $statement->execute(
                            array(
                                ':a1' =>  $reset,
                                ':a2' =>  $reset,
                                ':a3' =>  $reset,
                                ':a4' =>  $reset,
                                ':a5' =>  $reset,
                                ':a6' =>  $reset,
                                ':a7' =>  $reset,
                                ':a8' =>  $reset,
                                ':cinema_north' =>  $_POST["cinema_north"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET B1 = :b1, B2 = :b2, B3 = :b3, B4 = :b4, B5 = :b5, B6 = :b6, B7 = :b7, B8 = :b8, B9 = :b9, B10 = :b10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                        $result = $statement->execute(
                            array(
                                ':b1' =>  $reset,
                                ':b2' =>  $reset,
                                ':b3' =>  $reset,
                                ':b4' =>  $reset,
                                ':b5' =>  $reset,
                                ':b6' =>  $reset,
                                ':b7' =>  $reset,
                                ':b8' =>  $reset,
                                ':b9' =>  $reset,
                                ':b10' =>  $reset,
                                ':cinema_north' =>  $_POST["cinema_north"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET C1 = :c1, C2 = :c2, C3 = :c3, C4 = :c4, C5 = :c5, C6 = :c6, C7 = :c7, C8 = :c8, C9 = :c9, C10 = :c10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                        $result = $statement->execute(
                            array(
                                ':c1' =>  $reset,
                                ':c2' =>  $reset,
                                ':c3' =>  $reset,
                                ':c4' =>  $reset,
                                ':c5' =>  $reset,
                                ':c6' =>  $reset,
                                ':c7' =>  $reset,
                                ':c8' =>  $reset,
                                ':c9' =>  $reset,
                                ':c10' =>  $reset,
                                ':cinema_north' =>  $_POST["cinema_north"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET D1 = :d1, D2 = :d2, D3 = :d3, D4 = :d4, D5 = :d5, D6 = :d6, D7 = :d7, D8 = :d8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                        $result = $statement->execute(
                            array(
                                ':d1' =>  $reset,
                                ':d2' =>  $reset,
                                ':d3' =>  $reset,
                                ':d4' =>  $reset,
                                ':d5' =>  $reset,
                                ':d6' =>  $reset,
                                ':d7' =>  $reset,
                                ':d8' =>  $reset,
                                ':cinema_north' =>  $_POST["cinema_north"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET E1 = :e1, E2 = :e2, E3 = :e3, E4 = :e4, E5 = :e5, E6 = :e6, E7 = :e7, E8 = :e8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                        $result = $statement->execute(
                            array(
                                ':e1' =>  $reset,
                                ':e2' =>  $reset,
                                ':e3' =>  $reset,
                                ':e4' =>  $reset,
                                ':e5' =>  $reset,
                                ':e6' =>  $reset,
                                ':e7' =>  $reset,
                                ':e8' =>  $reset,
                                ':cinema_north' =>  $_POST["cinema_north"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET F1 = :f1, F2 = :f2, F3 = :f3, F4 = :f4, F5 = :f5, F6 = :f6, F7 = :f7, F8 = :f8, F9 = :f9, F10 = :f10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                        $result = $statement->execute(
                            array(
                                ':f1' =>  $reset,
                                ':f2' =>  $reset,
                                ':f3' =>  $reset,
                                ':f4' =>  $reset,
                                ':f5' =>  $reset,
                                ':f6' =>  $reset,
                                ':f7' =>  $reset,
                                ':f8' =>  $reset,
                                ':f9' =>  $reset,
                                ':f10' =>  $reset,
                                ':cinema_north' =>  $_POST["cinema_north"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET G1 = :g1, G2 = :g2, G3 = :g3, G4 = :g4, G5 = :g5, G6 = :g6, G7 = :g7, G8 = :g8, G9 = :g9, G10 = :g10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                        $result = $statement->execute(
                            array(
                                ':g1' =>  $reset,
                                ':g2' =>  $reset,
                                ':g3' =>  $reset,
                                ':g4' =>  $reset,
                                ':g5' =>  $reset,
                                ':g6' =>  $reset,
                                ':g7' =>  $reset,
                                ':g8' =>  $reset,
                                ':g9' =>  $reset,
                                ':g10' =>  $reset,
                                ':cinema_north' =>  $_POST["cinema_north"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET H1 = :h1, H2 = :h2, H3 = :h3, H4 = :h4, H5 = :h5, H6 = :h6, H7 = :h7, H8 = :h8, H9 = :h9, H10 = :h10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                        $result = $statement->execute(
                            array(
                                ':h1' =>  $reset,
                                ':h2' =>  $reset,
                                ':h3' =>  $reset,
                                ':h4' =>  $reset,
                                ':h5' =>  $reset,
                                ':h6' =>  $reset,
                                ':h7' =>  $reset,
                                ':h8' =>  $reset,
                                ':h9' =>  $reset,
                                ':h10' =>  $reset,
                                ':cinema_north' =>  $_POST["cinema_north"]
                            )
                        );
                    }
                    if ($bacoor == 4 && isset($_POST["Bacoor"])) {
                        $statement = $connection->prepare("UPDATE cinema SET MOVIE_ID = '$curr_id', ACTIVE = '1', MODIFIED_ON = '$today' WHERE BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                        $result = $statement->execute(
                            array(
                                ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                            )
                        );

                        // RESERVATION
                        $statement = $connection->prepare("UPDATE reservation SET MOVIE_ID = '$curr_id', MODIFIED_ON = '$today' WHERE BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                        $result = $statement->execute(
                            array(
                                ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET A1 = :a1, A2 = :a2, A3 = :a3, A4 = :a4, A5 = :a5, A6 = :a6, A7 = :a7, A8 = :a8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                        $result = $statement->execute(
                            array(
                                ':a1' =>  $reset,
                                ':a2' =>  $reset,
                                ':a3' =>  $reset,
                                ':a4' =>  $reset,
                                ':a5' =>  $reset,
                                ':a6' =>  $reset,
                                ':a7' =>  $reset,
                                ':a8' =>  $reset,
                                ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET B1 = :b1, B2 = :b2, B3 = :b3, B4 = :b4, B5 = :b5, B6 = :b6, B7 = :b7, B8 = :b8, B9 = :b9, B10 = :b10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                        $result = $statement->execute(
                            array(
                                ':b1' =>  $reset,
                                ':b2' =>  $reset,
                                ':b3' =>  $reset,
                                ':b4' =>  $reset,
                                ':b5' =>  $reset,
                                ':b6' =>  $reset,
                                ':b7' =>  $reset,
                                ':b8' =>  $reset,
                                ':b9' =>  $reset,
                                ':b10' =>  $reset,
                                ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET C1 = :c1, C2 = :c2, C3 = :c3, C4 = :c4, C5 = :c5, C6 = :c6, C7 = :c7, C8 = :c8, C9 = :c9, C10 = :c10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                        $result = $statement->execute(
                            array(
                                ':c1' =>  $reset,
                                ':c2' =>  $reset,
                                ':c3' =>  $reset,
                                ':c4' =>  $reset,
                                ':c5' =>  $reset,
                                ':c6' =>  $reset,
                                ':c7' =>  $reset,
                                ':c8' =>  $reset,
                                ':c9' =>  $reset,
                                ':c10' =>  $reset,
                                ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET D1 = :d1, D2 = :d2, D3 = :d3, D4 = :d4, D5 = :d5, D6 = :d6, D7 = :d7, D8 = :d8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                        $result = $statement->execute(
                            array(
                                ':d1' =>  $reset,
                                ':d2' =>  $reset,
                                ':d3' =>  $reset,
                                ':d4' =>  $reset,
                                ':d5' =>  $reset,
                                ':d6' =>  $reset,
                                ':d7' =>  $reset,
                                ':d8' =>  $reset,
                                ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET E1 = :e1, E2 = :e2, E3 = :e3, E4 = :e4, E5 = :e5, E6 = :e6, E7 = :e7, E8 = :e8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                        $result = $statement->execute(
                            array(
                                ':e1' =>  $reset,
                                ':e2' =>  $reset,
                                ':e3' =>  $reset,
                                ':e4' =>  $reset,
                                ':e5' =>  $reset,
                                ':e6' =>  $reset,
                                ':e7' =>  $reset,
                                ':e8' =>  $reset,
                                ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET F1 = :f1, F2 = :f2, F3 = :f3, F4 = :f4, F5 = :f5, F6 = :f6, F7 = :f7, F8 = :f8, F9 = :f9, F10 = :f10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                        $result = $statement->execute(
                            array(
                                ':f1' =>  $reset,
                                ':f2' =>  $reset,
                                ':f3' =>  $reset,
                                ':f4' =>  $reset,
                                ':f5' =>  $reset,
                                ':f6' =>  $reset,
                                ':f7' =>  $reset,
                                ':f8' =>  $reset,
                                ':f9' =>  $reset,
                                ':f10' =>  $reset,
                                ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET G1 = :g1, G2 = :g2, G3 = :g3, G4 = :g4, G5 = :g5, G6 = :g6, G7 = :g7, G8 = :g8, G9 = :g9, G10 = :g10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                        $result = $statement->execute(
                            array(
                                ':g1' =>  $reset,
                                ':g2' =>  $reset,
                                ':g3' =>  $reset,
                                ':g4' =>  $reset,
                                ':g5' =>  $reset,
                                ':g6' =>  $reset,
                                ':g7' =>  $reset,
                                ':g8' =>  $reset,
                                ':g9' =>  $reset,
                                ':g10' =>  $reset,
                                ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                            )
                        );
                        $statement = $connection->prepare("UPDATE reservation SET H1 = :h1, H2 = :h2, H3 = :h3, H4 = :h4, H5 = :h5, H6 = :h6, H7 = :h7, H8 = :h8, H9 = :h9, H10 = :h10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                        $result = $statement->execute(
                            array(
                                ':h1' =>  $reset,
                                ':h2' =>  $reset,
                                ':h3' =>  $reset,
                                ':h4' =>  $reset,
                                ':h5' =>  $reset,
                                ':h6' =>  $reset,
                                ':h7' =>  $reset,
                                ':h8' =>  $reset,
                                ':h9' =>  $reset,
                                ':h10' =>  $reset,
                                ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                            )
                        );
                    }
                }
            } else {
                echo 'invalid';
            }
        }
    }

    if ($_POST["operation"] == "Edit") {
        // Movies
        $statement = $connection->prepare("UPDATE movies SET MOVIE_TITLE = :movie, MOVIE_DESC = :description, MOVIE_DURATION = :duration, RATED = :rated, RATING_USER = :rating_user, RATING_TITLE = :rating_title, TRAILER = :trailer, PREMIERE_DATE = :premiereDate, PRICE = :price, ACTIVE = :movie_active, MODIFIED_ON = '$today' WHERE MOVIE_ID = :id");
        $result = $statement->execute(
            array(
                ':movie'   =>  $_POST["movie"],
                ':description' =>  $_POST["description"],
                ':duration' =>  $_POST["duration"],
                ':rated' =>  $_POST["rated"],
                ':rating_user' =>  $_POST["rating_user"],
                ':rating_title' =>  $_POST["rating_title"],
                ':trailer' =>  $_POST["trailer"],
                ':premiereDate' =>  $_POST["premiereDate"],
                ':price' =>  $_POST["price"],
                ':movie_active' =>  $_POST["movie_active"],
                ':id' => $_POST["movie_id"]
            )
        );

        // Genre
        $statement = $connection->prepare("UPDATE genre SET ACTION = :action_, ADVENTURE = :adventure, ANIMATION = :animation, COMEDY = :comedy, DRAMA = :drama, FAMILY = :family, FANTASY = :fantasy, HORROR = :horror, MUSICAL = :musical, MYSTERY = :mystery, ROMANCE = :romance, SCI_FI = :sci, THRILLER = :thriller, MODIFIED_ON = '$today' WHERE MOVIE_ID = :id");
        $result = $statement->execute(
            array(
                ':action_'   =>  $_POST["action_"],
                ':adventure' =>  $_POST["adventure"],
                ':animation' =>  $_POST["animation"],
                ':comedy' =>  $_POST["comedy"],
                ':drama' =>  $_POST["drama"],
                ':family' =>  $_POST["family"],
                ':fantasy' =>  $_POST["fantasy"],
                ':horror' =>  $_POST["horror"],
                ':musical' =>  $_POST["musical"],
                ':mystery' =>  $_POST["mystery"],
                ':romance' =>  $_POST["romance"],
                ':sci' =>  $_POST["sci"],
                ':thriller' =>  $_POST["thriller"],
                ':id' => $_POST["movie_id"]
            )
        );

        $stmt = $connection->query("SELECT * FROM movies");
        while ($row = $stmt->fetch()) {
            if ($row['MOVIE_TITLE'] == $_POST["movie"]) {
                $curr_id = $row['MOVIE_ID'];
            }
        }

        $allowed_exs = array("jpg", "jpeg", "png");

        // Poster
        if (isset($_FILES['movie_image'])) {
            $img_name = $_FILES['movie_image']['name'];
            $tmp_name = $_FILES['movie_image']['tmp_name'];
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("T1-", true) . '.' . $img_ex_lc;
                $img_upload_path = '../../images/movies/poster/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                $statement = $connection->prepare("UPDATE movies SET POSTER = ? WHERE MOVIE_ID = ?");
                $result = $statement->execute([$new_img_name, $curr_id]);
            }
        }

        // Poster BG
        if (isset($_FILES['movie_image_bg'])) {
            $img_name = $_FILES['movie_image_bg']['name'];
            $tmp_name = $_FILES['movie_image_bg']['tmp_name'];
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("T1-BG-", true) . '.' . $img_ex_lc;
                $img_upload_path = '../../images/movies/poster_bg/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                $statement = $connection->prepare("UPDATE movies SET POSTER_BG = ? WHERE MOVIE_ID = ?");
                $result = $statement->execute([$new_img_name, $curr_id]);
            }
        }

        $stmt = $connection->query("SELECT * FROM now_showing WHERE MOVIE_ID = '$curr_id'");
        while ($row = $stmt->fetch()) {
            if ($row["ACTIVE"] == 1) {
                $c_manila = $row["C_MANILA"];
                $c_marikina = $row["C_MARIKINA"];
                $c_north = $row["C_NORTH"];
                $c_bacoor = $row["C_BACOOR"];
            }
        }

        $active = $_POST["movie_active"];

        // INACTIVE
        if ($active == 0) {
            $statement = $connection->prepare("UPDATE coming_soon SET ACTIVE = ?, MODIFIED_ON = '$today' WHERE MOVIE_ID = ?");
            $result = $statement->execute(['0', $curr_id]);
            $statement = $connection->prepare("UPDATE now_showing SET ACTIVE = ?, MODIFIED_ON = '$today' WHERE MOVIE_ID = ?");
            $result = $statement->execute(['0', $curr_id]);

            // CINEMA
            if (empty($_POST["Manila"])) {
                $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '1' AND MOVIE_ID = '$curr_id'");
                $result = $statement->execute();
            }
            if (empty($_POST["Marikina"])) {
                $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '2' AND MOVIE_ID = '$curr_id'");
                $result = $statement->execute();
            }
            if (empty($_POST["North"])) {
                $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '3' AND MOVIE_ID = '$curr_id'");
                $result = $statement->execute();
            }
            if (empty($_POST["Bacoor"])) {
                $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '4' AND MOVIE_ID = '$curr_id'");
                $result = $statement->execute();
            }
        }

        // COMING SOON
        else if ($active == 1) {
            $statement = $connection->prepare("UPDATE coming_soon SET ACTIVE = ?, MODIFIED_ON = '$today' WHERE MOVIE_ID = ?");
            $result = $statement->execute(['1', $curr_id]);
            $statement = $connection->prepare("UPDATE now_showing SET ACTIVE = ?, MODIFIED_ON = '$today' WHERE MOVIE_ID = ?");
            $result = $statement->execute(['0', $curr_id]);

            // CINEMA
            if (empty($_POST["Manila"])) {
                $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '1' AND MOVIE_ID = '$curr_id'");
                $result = $statement->execute();
            }
            if (empty($_POST["Marikina"])) {
                $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '2' AND MOVIE_ID = '$curr_id'");
                $result = $statement->execute();
            }
            if (empty($_POST["North"])) {
                $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '3' AND MOVIE_ID = '$curr_id'");
                $result = $statement->execute();
            }
            if (empty($_POST["Bacoor"])) {
                $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '4' AND MOVIE_ID = '$curr_id'");
                $result = $statement->execute();
            }
        }

        // NOW SHOWING
        else if ($active == 2) {
            $statement = $connection->prepare("UPDATE coming_soon SET ACTIVE = ?, MODIFIED_ON = '$today' WHERE MOVIE_ID = ?");
            $result = $statement->execute(['0', $curr_id]);
            $statement = $connection->prepare("UPDATE now_showing SET B_MANILA = :Manila, B_MARIKINA = :Marikina, B_NORTH = :North, B_BACOOR = :Bacoor, C_MANILA = :cinema_manila, C_MARIKINA = :cinema_marikina, C_NORTH = :cinema_north, C_BACOOR = :cinema_bacoor, ACTIVE = '1', MODIFIED_ON = '$today' WHERE MOVIE_ID = :id");
            $result = $statement->execute(
                array(
                    ':Manila'   =>  $_POST["Manila"],
                    ':Marikina' =>  $_POST["Marikina"],
                    ':North' =>  $_POST["North"],
                    ':Bacoor' =>  $_POST["Bacoor"],
                    ':cinema_manila' =>  $_POST["cinema_manila"],
                    ':cinema_marikina' =>  $_POST["cinema_marikina"],
                    ':cinema_north' =>  $_POST["cinema_north"],
                    ':cinema_bacoor' =>  $_POST["cinema_bacoor"],
                    ':id' => $curr_id
                )
            );

            // CINEMA
            $manila = $_POST["Manila"];
            $marikina = $_POST["Marikina"];
            $north = $_POST["North"];
            $bacoor = $_POST["Bacoor"];

            // 1
            if ($manila == 1 && isset($_POST["Manila"])) {
                $stmt = $connection->query("SELECT * FROM cinema WHERE BRANCH_ID = '1' AND MOVIE_ID = '$curr_id'");
                while ($row = $stmt->fetch()) {
                    if ($row['ACTIVE'] == 1) {
                        $cinema = $row['CINEMA_NO'];
                    }
                }
                $statement = $connection->prepare("UPDATE cinema SET MOVIE_ID = '$curr_id', ACTIVE = '1', MODIFIED_ON = '$today' WHERE BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                $result = $statement->execute(
                    array(
                        ':cinema_manila' =>  $_POST["cinema_manila"]
                    )
                );

                // RESERVATION
                $statement = $connection->prepare("UPDATE reservation SET MOVIE_ID = '$curr_id', MODIFIED_ON = '$today' WHERE BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                $result = $statement->execute(
                    array(
                        ':cinema_manila' =>  $_POST["cinema_manila"]
                    )
                );

                if ($cinema != $_POST["cinema_manila"]) {
                    $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '1' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute();

                    $statement = $connection->prepare("UPDATE reservation SET A1 = :a1, A2 = :a2, A3 = :a3, A4 = :a4, A5 = :a5, A6 = :a6, A7 = :a7, A8 = :a8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':a1' =>  $reset,
                            ':a2' =>  $reset,
                            ':a3' =>  $reset,
                            ':a4' =>  $reset,
                            ':a5' =>  $reset,
                            ':a6' =>  $reset,
                            ':a7' =>  $reset,
                            ':a8' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET B1 = :b1, B2 = :b2, B3 = :b3, B4 = :b4, B5 = :b5, B6 = :b6, B7 = :b7, B8 = :b8, B9 = :b9, B10 = :b10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':b1' =>  $reset,
                            ':b2' =>  $reset,
                            ':b3' =>  $reset,
                            ':b4' =>  $reset,
                            ':b5' =>  $reset,
                            ':b6' =>  $reset,
                            ':b7' =>  $reset,
                            ':b8' =>  $reset,
                            ':b9' =>  $reset,
                            ':b10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET C1 = :c1, C2 = :c2, C3 = :c3, C4 = :c4, C5 = :c5, C6 = :c6, C7 = :c7, C8 = :c8, C9 = :c9, C10 = :c10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':c1' =>  $reset,
                            ':c2' =>  $reset,
                            ':c3' =>  $reset,
                            ':c4' =>  $reset,
                            ':c5' =>  $reset,
                            ':c6' =>  $reset,
                            ':c7' =>  $reset,
                            ':c8' =>  $reset,
                            ':c9' =>  $reset,
                            ':c10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET D1 = :d1, D2 = :d2, D3 = :d3, D4 = :d4, D5 = :d5, D6 = :d6, D7 = :d7, D8 = :d8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':d1' =>  $reset,
                            ':d2' =>  $reset,
                            ':d3' =>  $reset,
                            ':d4' =>  $reset,
                            ':d5' =>  $reset,
                            ':d6' =>  $reset,
                            ':d7' =>  $reset,
                            ':d8' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET E1 = :e1, E2 = :e2, E3 = :e3, E4 = :e4, E5 = :e5, E6 = :e6, E7 = :e7, E8 = :e8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':e1' =>  $reset,
                            ':e2' =>  $reset,
                            ':e3' =>  $reset,
                            ':e4' =>  $reset,
                            ':e5' =>  $reset,
                            ':e6' =>  $reset,
                            ':e7' =>  $reset,
                            ':e8' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET F1 = :f1, F2 = :f2, F3 = :f3, F4 = :f4, F5 = :f5, F6 = :f6, F7 = :f7, F8 = :f8, F9 = :f9, F10 = :f10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':f1' =>  $reset,
                            ':f2' =>  $reset,
                            ':f3' =>  $reset,
                            ':f4' =>  $reset,
                            ':f5' =>  $reset,
                            ':f6' =>  $reset,
                            ':f7' =>  $reset,
                            ':f8' =>  $reset,
                            ':f9' =>  $reset,
                            ':f10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET G1 = :g1, G2 = :g2, G3 = :g3, G4 = :g4, G5 = :g5, G6 = :g6, G7 = :g7, G8 = :g8, G9 = :g9, G10 = :g10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':g1' =>  $reset,
                            ':g2' =>  $reset,
                            ':g3' =>  $reset,
                            ':g4' =>  $reset,
                            ':g5' =>  $reset,
                            ':g6' =>  $reset,
                            ':g7' =>  $reset,
                            ':g8' =>  $reset,
                            ':g9' =>  $reset,
                            ':g10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET H1 = :h1, H2 = :h2, H3 = :h3, H4 = :h4, H5 = :h5, H6 = :h6, H7 = :h7, H8 = :h8, H9 = :h9, H10 = :h10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':h1' =>  $reset,
                            ':h2' =>  $reset,
                            ':h3' =>  $reset,
                            ':h4' =>  $reset,
                            ':h5' =>  $reset,
                            ':h6' =>  $reset,
                            ':h7' =>  $reset,
                            ':h8' =>  $reset,
                            ':h9' =>  $reset,
                            ':h10' =>  $reset
                        )
                    );
                }

                if ($c_manila != $_POST["cinema_manila"]) {
                    $statement = $connection->prepare("UPDATE reservation SET A1 = :a1, A2 = :a2, A3 = :a3, A4 = :a4, A5 = :a5, A6 = :a6, A7 = :a7, A8 = :a8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                    $result = $statement->execute(
                        array(
                            ':a1' =>  $reset,
                            ':a2' =>  $reset,
                            ':a3' =>  $reset,
                            ':a4' =>  $reset,
                            ':a5' =>  $reset,
                            ':a6' =>  $reset,
                            ':a7' =>  $reset,
                            ':a8' =>  $reset,
                            ':cinema_manila' =>  $_POST["cinema_manila"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET B1 = :b1, B2 = :b2, B3 = :b3, B4 = :b4, B5 = :b5, B6 = :b6, B7 = :b7, B8 = :b8, B9 = :b9, B10 = :b10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                    $result = $statement->execute(
                        array(
                            ':b1' =>  $reset,
                            ':b2' =>  $reset,
                            ':b3' =>  $reset,
                            ':b4' =>  $reset,
                            ':b5' =>  $reset,
                            ':b6' =>  $reset,
                            ':b7' =>  $reset,
                            ':b8' =>  $reset,
                            ':b9' =>  $reset,
                            ':b10' =>  $reset,
                            ':cinema_manila' =>  $_POST["cinema_manila"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET C1 = :c1, C2 = :c2, C3 = :c3, C4 = :c4, C5 = :c5, C6 = :c6, C7 = :c7, C8 = :c8, C9 = :c9, C10 = :c10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                    $result = $statement->execute(
                        array(
                            ':c1' =>  $reset,
                            ':c2' =>  $reset,
                            ':c3' =>  $reset,
                            ':c4' =>  $reset,
                            ':c5' =>  $reset,
                            ':c6' =>  $reset,
                            ':c7' =>  $reset,
                            ':c8' =>  $reset,
                            ':c9' =>  $reset,
                            ':c10' =>  $reset,
                            ':cinema_manila' =>  $_POST["cinema_manila"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET D1 = :d1, D2 = :d2, D3 = :d3, D4 = :d4, D5 = :d5, D6 = :d6, D7 = :d7, D8 = :d8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                    $result = $statement->execute(
                        array(
                            ':d1' =>  $reset,
                            ':d2' =>  $reset,
                            ':d3' =>  $reset,
                            ':d4' =>  $reset,
                            ':d5' =>  $reset,
                            ':d6' =>  $reset,
                            ':d7' =>  $reset,
                            ':d8' =>  $reset,
                            ':cinema_manila' =>  $_POST["cinema_manila"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET E1 = :e1, E2 = :e2, E3 = :e3, E4 = :e4, E5 = :e5, E6 = :e6, E7 = :e7, E8 = :e8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                    $result = $statement->execute(
                        array(
                            ':e1' =>  $reset,
                            ':e2' =>  $reset,
                            ':e3' =>  $reset,
                            ':e4' =>  $reset,
                            ':e5' =>  $reset,
                            ':e6' =>  $reset,
                            ':e7' =>  $reset,
                            ':e8' =>  $reset,
                            ':cinema_manila' =>  $_POST["cinema_manila"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET F1 = :f1, F2 = :f2, F3 = :f3, F4 = :f4, F5 = :f5, F6 = :f6, F7 = :f7, F8 = :f8, F9 = :f9, F10 = :f10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                    $result = $statement->execute(
                        array(
                            ':f1' =>  $reset,
                            ':f2' =>  $reset,
                            ':f3' =>  $reset,
                            ':f4' =>  $reset,
                            ':f5' =>  $reset,
                            ':f6' =>  $reset,
                            ':f7' =>  $reset,
                            ':f8' =>  $reset,
                            ':f9' =>  $reset,
                            ':f10' =>  $reset,
                            ':cinema_manila' =>  $_POST["cinema_manila"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET G1 = :g1, G2 = :g2, G3 = :g3, G4 = :g4, G5 = :g5, G6 = :g6, G7 = :g7, G8 = :g8, G9 = :g9, G10 = :g10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                    $result = $statement->execute(
                        array(
                            ':g1' =>  $reset,
                            ':g2' =>  $reset,
                            ':g3' =>  $reset,
                            ':g4' =>  $reset,
                            ':g5' =>  $reset,
                            ':g6' =>  $reset,
                            ':g7' =>  $reset,
                            ':g8' =>  $reset,
                            ':g9' =>  $reset,
                            ':g10' =>  $reset,
                            ':cinema_manila' =>  $_POST["cinema_manila"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET H1 = :h1, H2 = :h2, H3 = :h3, H4 = :h4, H5 = :h5, H6 = :h6, H7 = :h7, H8 = :h8, H9 = :h9, H10 = :h10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '1' AND CINEMA_NO = :cinema_manila");
                    $result = $statement->execute(
                        array(
                            ':h1' =>  $reset,
                            ':h2' =>  $reset,
                            ':h3' =>  $reset,
                            ':h4' =>  $reset,
                            ':h5' =>  $reset,
                            ':h6' =>  $reset,
                            ':h7' =>  $reset,
                            ':h8' =>  $reset,
                            ':h9' =>  $reset,
                            ':h10' =>  $reset,
                            ':cinema_manila' =>  $_POST["cinema_manila"]
                        )
                    );
                }
            } else {
                $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '1' AND MOVIE_ID = '$curr_id'");
                $result = $statement->execute();
            }

            // 2
            if ($marikina == 2 && isset($_POST["Marikina"])) {
                $stmt = $connection->query("SELECT * FROM cinema WHERE BRANCH_ID = '2' AND MOVIE_ID = '$curr_id'");
                while ($row = $stmt->fetch()) {
                    if ($row['ACTIVE'] == 1) {
                        $cinema = $row['CINEMA_NO'];
                    }
                }
                $statement = $connection->prepare("UPDATE cinema SET MOVIE_ID = '$curr_id', ACTIVE = '1', MODIFIED_ON = '$today' WHERE BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                $result = $statement->execute(
                    array(
                        ':cinema_marikina' =>  $_POST["cinema_marikina"]
                    )
                );

                // RESERVATION
                $statement = $connection->prepare("UPDATE reservation SET MOVIE_ID = '$curr_id', MODIFIED_ON = '$today' WHERE BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                $result = $statement->execute(
                    array(
                        ':cinema_marikina' =>  $_POST["cinema_marikina"]
                    )
                );

                if ($cinema != $_POST["cinema_marikina"]) {
                    $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '2' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute();

                    $statement = $connection->prepare("UPDATE reservation SET A1 = :a1, A2 = :a2, A3 = :a3, A4 = :a4, A5 = :a5, A6 = :a6, A7 = :a7, A8 = :a8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':a1' =>  $reset,
                            ':a2' =>  $reset,
                            ':a3' =>  $reset,
                            ':a4' =>  $reset,
                            ':a5' =>  $reset,
                            ':a6' =>  $reset,
                            ':a7' =>  $reset,
                            ':a8' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET B1 = :b1, B2 = :b2, B3 = :b3, B4 = :b4, B5 = :b5, B6 = :b6, B7 = :b7, B8 = :b8, B9 = :b9, B10 = :b10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':b1' =>  $reset,
                            ':b2' =>  $reset,
                            ':b3' =>  $reset,
                            ':b4' =>  $reset,
                            ':b5' =>  $reset,
                            ':b6' =>  $reset,
                            ':b7' =>  $reset,
                            ':b8' =>  $reset,
                            ':b9' =>  $reset,
                            ':b10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET C1 = :c1, C2 = :c2, C3 = :c3, C4 = :c4, C5 = :c5, C6 = :c6, C7 = :c7, C8 = :c8, C9 = :c9, C10 = :c10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':c1' =>  $reset,
                            ':c2' =>  $reset,
                            ':c3' =>  $reset,
                            ':c4' =>  $reset,
                            ':c5' =>  $reset,
                            ':c6' =>  $reset,
                            ':c7' =>  $reset,
                            ':c8' =>  $reset,
                            ':c9' =>  $reset,
                            ':c10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET D1 = :d1, D2 = :d2, D3 = :d3, D4 = :d4, D5 = :d5, D6 = :d6, D7 = :d7, D8 = :d8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':d1' =>  $reset,
                            ':d2' =>  $reset,
                            ':d3' =>  $reset,
                            ':d4' =>  $reset,
                            ':d5' =>  $reset,
                            ':d6' =>  $reset,
                            ':d7' =>  $reset,
                            ':d8' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET E1 = :e1, E2 = :e2, E3 = :e3, E4 = :e4, E5 = :e5, E6 = :e6, E7 = :e7, E8 = :e8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':e1' =>  $reset,
                            ':e2' =>  $reset,
                            ':e3' =>  $reset,
                            ':e4' =>  $reset,
                            ':e5' =>  $reset,
                            ':e6' =>  $reset,
                            ':e7' =>  $reset,
                            ':e8' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET F1 = :f1, F2 = :f2, F3 = :f3, F4 = :f4, F5 = :f5, F6 = :f6, F7 = :f7, F8 = :f8, F9 = :f9, F10 = :f10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':f1' =>  $reset,
                            ':f2' =>  $reset,
                            ':f3' =>  $reset,
                            ':f4' =>  $reset,
                            ':f5' =>  $reset,
                            ':f6' =>  $reset,
                            ':f7' =>  $reset,
                            ':f8' =>  $reset,
                            ':f9' =>  $reset,
                            ':f10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET G1 = :g1, G2 = :g2, G3 = :g3, G4 = :g4, G5 = :g5, G6 = :g6, G7 = :g7, G8 = :g8, G9 = :g9, G10 = :g10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':g1' =>  $reset,
                            ':g2' =>  $reset,
                            ':g3' =>  $reset,
                            ':g4' =>  $reset,
                            ':g5' =>  $reset,
                            ':g6' =>  $reset,
                            ':g7' =>  $reset,
                            ':g8' =>  $reset,
                            ':g9' =>  $reset,
                            ':g10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET H1 = :h1, H2 = :h2, H3 = :h3, H4 = :h4, H5 = :h5, H6 = :h6, H7 = :h7, H8 = :h8, H9 = :h9, H10 = :h10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':h1' =>  $reset,
                            ':h2' =>  $reset,
                            ':h3' =>  $reset,
                            ':h4' =>  $reset,
                            ':h5' =>  $reset,
                            ':h6' =>  $reset,
                            ':h7' =>  $reset,
                            ':h8' =>  $reset,
                            ':h9' =>  $reset,
                            ':h10' =>  $reset
                        )
                    );
                }

                if ($c_marikina != $_POST["cinema_marikina"]) {
                    $statement = $connection->prepare("UPDATE reservation SET A1 = :a1, A2 = :a2, A3 = :a3, A4 = :a4, A5 = :a5, A6 = :a6, A7 = :a7, A8 = :a8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                    $result = $statement->execute(
                        array(
                            ':a1' =>  $reset,
                            ':a2' =>  $reset,
                            ':a3' =>  $reset,
                            ':a4' =>  $reset,
                            ':a5' =>  $reset,
                            ':a6' =>  $reset,
                            ':a7' =>  $reset,
                            ':a8' =>  $reset,
                            ':cinema_marikina' =>  $_POST["cinema_marikina"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET B1 = :b1, B2 = :b2, B3 = :b3, B4 = :b4, B5 = :b5, B6 = :b6, B7 = :b7, B8 = :b8, B9 = :b9, B10 = :b10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                    $result = $statement->execute(
                        array(
                            ':b1' =>  $reset,
                            ':b2' =>  $reset,
                            ':b3' =>  $reset,
                            ':b4' =>  $reset,
                            ':b5' =>  $reset,
                            ':b6' =>  $reset,
                            ':b7' =>  $reset,
                            ':b8' =>  $reset,
                            ':b9' =>  $reset,
                            ':b10' =>  $reset,
                            ':cinema_marikina' =>  $_POST["cinema_marikina"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET C1 = :c1, C2 = :c2, C3 = :c3, C4 = :c4, C5 = :c5, C6 = :c6, C7 = :c7, C8 = :c8, C9 = :c9, C10 = :c10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                    $result = $statement->execute(
                        array(
                            ':c1' =>  $reset,
                            ':c2' =>  $reset,
                            ':c3' =>  $reset,
                            ':c4' =>  $reset,
                            ':c5' =>  $reset,
                            ':c6' =>  $reset,
                            ':c7' =>  $reset,
                            ':c8' =>  $reset,
                            ':c9' =>  $reset,
                            ':c10' =>  $reset,
                            ':cinema_marikina' =>  $_POST["cinema_marikina"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET D1 = :d1, D2 = :d2, D3 = :d3, D4 = :d4, D5 = :d5, D6 = :d6, D7 = :d7, D8 = :d8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                    $result = $statement->execute(
                        array(
                            ':d1' =>  $reset,
                            ':d2' =>  $reset,
                            ':d3' =>  $reset,
                            ':d4' =>  $reset,
                            ':d5' =>  $reset,
                            ':d6' =>  $reset,
                            ':d7' =>  $reset,
                            ':d8' =>  $reset,
                            ':cinema_marikina' =>  $_POST["cinema_marikina"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET E1 = :e1, E2 = :e2, E3 = :e3, E4 = :e4, E5 = :e5, E6 = :e6, E7 = :e7, E8 = :e8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                    $result = $statement->execute(
                        array(
                            ':e1' =>  $reset,
                            ':e2' =>  $reset,
                            ':e3' =>  $reset,
                            ':e4' =>  $reset,
                            ':e5' =>  $reset,
                            ':e6' =>  $reset,
                            ':e7' =>  $reset,
                            ':e8' =>  $reset,
                            ':cinema_marikina' =>  $_POST["cinema_marikina"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET F1 = :f1, F2 = :f2, F3 = :f3, F4 = :f4, F5 = :f5, F6 = :f6, F7 = :f7, F8 = :f8, F9 = :f9, F10 = :f10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                    $result = $statement->execute(
                        array(
                            ':f1' =>  $reset,
                            ':f2' =>  $reset,
                            ':f3' =>  $reset,
                            ':f4' =>  $reset,
                            ':f5' =>  $reset,
                            ':f6' =>  $reset,
                            ':f7' =>  $reset,
                            ':f8' =>  $reset,
                            ':f9' =>  $reset,
                            ':f10' =>  $reset,
                            ':cinema_marikina' =>  $_POST["cinema_marikina"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET G1 = :g1, G2 = :g2, G3 = :g3, G4 = :g4, G5 = :g5, G6 = :g6, G7 = :g7, G8 = :g8, G9 = :g9, G10 = :g10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                    $result = $statement->execute(
                        array(
                            ':g1' =>  $reset,
                            ':g2' =>  $reset,
                            ':g3' =>  $reset,
                            ':g4' =>  $reset,
                            ':g5' =>  $reset,
                            ':g6' =>  $reset,
                            ':g7' =>  $reset,
                            ':g8' =>  $reset,
                            ':g9' =>  $reset,
                            ':g10' =>  $reset,
                            ':cinema_marikina' =>  $_POST["cinema_marikina"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET H1 = :h1, H2 = :h2, H3 = :h3, H4 = :h4, H5 = :h5, H6 = :h6, H7 = :h7, H8 = :h8, H9 = :h9, H10 = :h10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '2' AND CINEMA_NO = :cinema_marikina");
                    $result = $statement->execute(
                        array(
                            ':h1' =>  $reset,
                            ':h2' =>  $reset,
                            ':h3' =>  $reset,
                            ':h4' =>  $reset,
                            ':h5' =>  $reset,
                            ':h6' =>  $reset,
                            ':h7' =>  $reset,
                            ':h8' =>  $reset,
                            ':h9' =>  $reset,
                            ':h10' =>  $reset,
                            ':cinema_marikina' =>  $_POST["cinema_marikina"]
                        )
                    );
                }
            } else {
                $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '2' AND MOVIE_ID = '$curr_id'");
                $result = $statement->execute();
            }

            // 3
            if ($north == 3 && isset($_POST["North"])) {
                $stmt = $connection->query("SELECT * FROM cinema WHERE BRANCH_ID = '3' AND MOVIE_ID = '$curr_id'");
                while ($row = $stmt->fetch()) {
                    if ($row['ACTIVE'] == 1) {
                        $cinema = $row['CINEMA_NO'];
                    }
                }
                $statement = $connection->prepare("UPDATE cinema SET MOVIE_ID = '$curr_id', ACTIVE = '1', MODIFIED_ON = '$today' WHERE BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                $result = $statement->execute(
                    array(
                        ':cinema_north' =>  $_POST["cinema_north"]
                    )
                );

                // RESERVATION
                $statement = $connection->prepare("UPDATE reservation SET MOVIE_ID = '$curr_id', MODIFIED_ON = '$today' WHERE BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                $result = $statement->execute(
                    array(
                        ':cinema_north' =>  $_POST["cinema_north"]
                    )
                );

                if ($cinema != $_POST["cinema_north"]) {
                    $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '3' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute();

                    $statement = $connection->prepare("UPDATE reservation SET A1 = :a1, A2 = :a2, A3 = :a3, A4 = :a4, A5 = :a5, A6 = :a6, A7 = :a7, A8 = :a8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':a1' =>  $reset,
                            ':a2' =>  $reset,
                            ':a3' =>  $reset,
                            ':a4' =>  $reset,
                            ':a5' =>  $reset,
                            ':a6' =>  $reset,
                            ':a7' =>  $reset,
                            ':a8' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET B1 = :b1, B2 = :b2, B3 = :b3, B4 = :b4, B5 = :b5, B6 = :b6, B7 = :b7, B8 = :b8, B9 = :b9, B10 = :b10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':b1' =>  $reset,
                            ':b2' =>  $reset,
                            ':b3' =>  $reset,
                            ':b4' =>  $reset,
                            ':b5' =>  $reset,
                            ':b6' =>  $reset,
                            ':b7' =>  $reset,
                            ':b8' =>  $reset,
                            ':b9' =>  $reset,
                            ':b10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET C1 = :c1, C2 = :c2, C3 = :c3, C4 = :c4, C5 = :c5, C6 = :c6, C7 = :c7, C8 = :c8, C9 = :c9, C10 = :c10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':c1' =>  $reset,
                            ':c2' =>  $reset,
                            ':c3' =>  $reset,
                            ':c4' =>  $reset,
                            ':c5' =>  $reset,
                            ':c6' =>  $reset,
                            ':c7' =>  $reset,
                            ':c8' =>  $reset,
                            ':c9' =>  $reset,
                            ':c10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET D1 = :d1, D2 = :d2, D3 = :d3, D4 = :d4, D5 = :d5, D6 = :d6, D7 = :d7, D8 = :d8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':d1' =>  $reset,
                            ':d2' =>  $reset,
                            ':d3' =>  $reset,
                            ':d4' =>  $reset,
                            ':d5' =>  $reset,
                            ':d6' =>  $reset,
                            ':d7' =>  $reset,
                            ':d8' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET E1 = :e1, E2 = :e2, E3 = :e3, E4 = :e4, E5 = :e5, E6 = :e6, E7 = :e7, E8 = :e8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':e1' =>  $reset,
                            ':e2' =>  $reset,
                            ':e3' =>  $reset,
                            ':e4' =>  $reset,
                            ':e5' =>  $reset,
                            ':e6' =>  $reset,
                            ':e7' =>  $reset,
                            ':e8' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET F1 = :f1, F2 = :f2, F3 = :f3, F4 = :f4, F5 = :f5, F6 = :f6, F7 = :f7, F8 = :f8, F9 = :f9, F10 = :f10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':f1' =>  $reset,
                            ':f2' =>  $reset,
                            ':f3' =>  $reset,
                            ':f4' =>  $reset,
                            ':f5' =>  $reset,
                            ':f6' =>  $reset,
                            ':f7' =>  $reset,
                            ':f8' =>  $reset,
                            ':f9' =>  $reset,
                            ':f10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET G1 = :g1, G2 = :g2, G3 = :g3, G4 = :g4, G5 = :g5, G6 = :g6, G7 = :g7, G8 = :g8, G9 = :g9, G10 = :g10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':g1' =>  $reset,
                            ':g2' =>  $reset,
                            ':g3' =>  $reset,
                            ':g4' =>  $reset,
                            ':g5' =>  $reset,
                            ':g6' =>  $reset,
                            ':g7' =>  $reset,
                            ':g8' =>  $reset,
                            ':g9' =>  $reset,
                            ':g10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET H1 = :h1, H2 = :h2, H3 = :h3, H4 = :h4, H5 = :h5, H6 = :h6, H7 = :h7, H8 = :h8, H9 = :h9, H10 = :h10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':h1' =>  $reset,
                            ':h2' =>  $reset,
                            ':h3' =>  $reset,
                            ':h4' =>  $reset,
                            ':h5' =>  $reset,
                            ':h6' =>  $reset,
                            ':h7' =>  $reset,
                            ':h8' =>  $reset,
                            ':h9' =>  $reset,
                            ':h10' =>  $reset
                        )
                    );
                }

                if ($c_north != $_POST["cinema_north"]) {
                    $statement = $connection->prepare("UPDATE reservation SET A1 = :a1, A2 = :a2, A3 = :a3, A4 = :a4, A5 = :a5, A6 = :a6, A7 = :a7, A8 = :a8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                    $result = $statement->execute(
                        array(
                            ':a1' =>  $reset,
                            ':a2' =>  $reset,
                            ':a3' =>  $reset,
                            ':a4' =>  $reset,
                            ':a5' =>  $reset,
                            ':a6' =>  $reset,
                            ':a7' =>  $reset,
                            ':a8' =>  $reset,
                            ':cinema_north' =>  $_POST["cinema_north"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET B1 = :b1, B2 = :b2, B3 = :b3, B4 = :b4, B5 = :b5, B6 = :b6, B7 = :b7, B8 = :b8, B9 = :b9, B10 = :b10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                    $result = $statement->execute(
                        array(
                            ':b1' =>  $reset,
                            ':b2' =>  $reset,
                            ':b3' =>  $reset,
                            ':b4' =>  $reset,
                            ':b5' =>  $reset,
                            ':b6' =>  $reset,
                            ':b7' =>  $reset,
                            ':b8' =>  $reset,
                            ':b9' =>  $reset,
                            ':b10' =>  $reset,
                            ':cinema_north' =>  $_POST["cinema_north"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET C1 = :c1, C2 = :c2, C3 = :c3, C4 = :c4, C5 = :c5, C6 = :c6, C7 = :c7, C8 = :c8, C9 = :c9, C10 = :c10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                    $result = $statement->execute(
                        array(
                            ':c1' =>  $reset,
                            ':c2' =>  $reset,
                            ':c3' =>  $reset,
                            ':c4' =>  $reset,
                            ':c5' =>  $reset,
                            ':c6' =>  $reset,
                            ':c7' =>  $reset,
                            ':c8' =>  $reset,
                            ':c9' =>  $reset,
                            ':c10' =>  $reset,
                            ':cinema_north' =>  $_POST["cinema_north"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET D1 = :d1, D2 = :d2, D3 = :d3, D4 = :d4, D5 = :d5, D6 = :d6, D7 = :d7, D8 = :d8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                    $result = $statement->execute(
                        array(
                            ':d1' =>  $reset,
                            ':d2' =>  $reset,
                            ':d3' =>  $reset,
                            ':d4' =>  $reset,
                            ':d5' =>  $reset,
                            ':d6' =>  $reset,
                            ':d7' =>  $reset,
                            ':d8' =>  $reset,
                            ':cinema_north' =>  $_POST["cinema_north"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET E1 = :e1, E2 = :e2, E3 = :e3, E4 = :e4, E5 = :e5, E6 = :e6, E7 = :e7, E8 = :e8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                    $result = $statement->execute(
                        array(
                            ':e1' =>  $reset,
                            ':e2' =>  $reset,
                            ':e3' =>  $reset,
                            ':e4' =>  $reset,
                            ':e5' =>  $reset,
                            ':e6' =>  $reset,
                            ':e7' =>  $reset,
                            ':e8' =>  $reset,
                            ':cinema_north' =>  $_POST["cinema_north"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET F1 = :f1, F2 = :f2, F3 = :f3, F4 = :f4, F5 = :f5, F6 = :f6, F7 = :f7, F8 = :f8, F9 = :f9, F10 = :f10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                    $result = $statement->execute(
                        array(
                            ':f1' =>  $reset,
                            ':f2' =>  $reset,
                            ':f3' =>  $reset,
                            ':f4' =>  $reset,
                            ':f5' =>  $reset,
                            ':f6' =>  $reset,
                            ':f7' =>  $reset,
                            ':f8' =>  $reset,
                            ':f9' =>  $reset,
                            ':f10' =>  $reset,
                            ':cinema_north' =>  $_POST["cinema_north"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET G1 = :g1, G2 = :g2, G3 = :g3, G4 = :g4, G5 = :g5, G6 = :g6, G7 = :g7, G8 = :g8, G9 = :g9, G10 = :g10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                    $result = $statement->execute(
                        array(
                            ':g1' =>  $reset,
                            ':g2' =>  $reset,
                            ':g3' =>  $reset,
                            ':g4' =>  $reset,
                            ':g5' =>  $reset,
                            ':g6' =>  $reset,
                            ':g7' =>  $reset,
                            ':g8' =>  $reset,
                            ':g9' =>  $reset,
                            ':g10' =>  $reset,
                            ':cinema_north' =>  $_POST["cinema_north"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET H1 = :h1, H2 = :h2, H3 = :h3, H4 = :h4, H5 = :h5, H6 = :h6, H7 = :h7, H8 = :h8, H9 = :h9, H10 = :h10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '3' AND CINEMA_NO = :cinema_north");
                    $result = $statement->execute(
                        array(
                            ':h1' =>  $reset,
                            ':h2' =>  $reset,
                            ':h3' =>  $reset,
                            ':h4' =>  $reset,
                            ':h5' =>  $reset,
                            ':h6' =>  $reset,
                            ':h7' =>  $reset,
                            ':h8' =>  $reset,
                            ':h9' =>  $reset,
                            ':h10' =>  $reset,
                            ':cinema_north' =>  $_POST["cinema_north"]
                        )
                    );
                }
            } else {
                $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '3' AND MOVIE_ID = '$curr_id'");
                $result = $statement->execute();
            }

            // 4
            if ($bacoor == 4 && isset($_POST["Bacoor"])) {
                $stmt = $connection->query("SELECT * FROM cinema WHERE BRANCH_ID = '4' AND MOVIE_ID = '$curr_id'");
                while ($row = $stmt->fetch()) {
                    if ($row['ACTIVE'] == 1) {
                        $cinema = $row['CINEMA_NO'];
                    }
                }
                $statement = $connection->prepare("UPDATE cinema SET MOVIE_ID = '$curr_id', ACTIVE = '1', MODIFIED_ON = '$today' WHERE BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                $result = $statement->execute(
                    array(
                        ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                    )
                );

                // RESERVATION
                $statement = $connection->prepare("UPDATE reservation SET MOVIE_ID = '$curr_id', MODIFIED_ON = '$today' WHERE BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                $result = $statement->execute(
                    array(
                        ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                    )
                );

                if ($cinema != $_POST["cinema_bacoor"]) {
                    $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '4' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute();

                    $statement = $connection->prepare("UPDATE reservation SET A1 = :a1, A2 = :a2, A3 = :a3, A4 = :a4, A5 = :a5, A6 = :a6, A7 = :a7, A8 = :a8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':a1' =>  $reset,
                            ':a2' =>  $reset,
                            ':a3' =>  $reset,
                            ':a4' =>  $reset,
                            ':a5' =>  $reset,
                            ':a6' =>  $reset,
                            ':a7' =>  $reset,
                            ':a8' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET B1 = :b1, B2 = :b2, B3 = :b3, B4 = :b4, B5 = :b5, B6 = :b6, B7 = :b7, B8 = :b8, B9 = :b9, B10 = :b10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':b1' =>  $reset,
                            ':b2' =>  $reset,
                            ':b3' =>  $reset,
                            ':b4' =>  $reset,
                            ':b5' =>  $reset,
                            ':b6' =>  $reset,
                            ':b7' =>  $reset,
                            ':b8' =>  $reset,
                            ':b9' =>  $reset,
                            ':b10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET C1 = :c1, C2 = :c2, C3 = :c3, C4 = :c4, C5 = :c5, C6 = :c6, C7 = :c7, C8 = :c8, C9 = :c9, C10 = :c10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':c1' =>  $reset,
                            ':c2' =>  $reset,
                            ':c3' =>  $reset,
                            ':c4' =>  $reset,
                            ':c5' =>  $reset,
                            ':c6' =>  $reset,
                            ':c7' =>  $reset,
                            ':c8' =>  $reset,
                            ':c9' =>  $reset,
                            ':c10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET D1 = :d1, D2 = :d2, D3 = :d3, D4 = :d4, D5 = :d5, D6 = :d6, D7 = :d7, D8 = :d8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':d1' =>  $reset,
                            ':d2' =>  $reset,
                            ':d3' =>  $reset,
                            ':d4' =>  $reset,
                            ':d5' =>  $reset,
                            ':d6' =>  $reset,
                            ':d7' =>  $reset,
                            ':d8' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET E1 = :e1, E2 = :e2, E3 = :e3, E4 = :e4, E5 = :e5, E6 = :e6, E7 = :e7, E8 = :e8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':e1' =>  $reset,
                            ':e2' =>  $reset,
                            ':e3' =>  $reset,
                            ':e4' =>  $reset,
                            ':e5' =>  $reset,
                            ':e6' =>  $reset,
                            ':e7' =>  $reset,
                            ':e8' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET F1 = :f1, F2 = :f2, F3 = :f3, F4 = :f4, F5 = :f5, F6 = :f6, F7 = :f7, F8 = :f8, F9 = :f9, F10 = :f10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':f1' =>  $reset,
                            ':f2' =>  $reset,
                            ':f3' =>  $reset,
                            ':f4' =>  $reset,
                            ':f5' =>  $reset,
                            ':f6' =>  $reset,
                            ':f7' =>  $reset,
                            ':f8' =>  $reset,
                            ':f9' =>  $reset,
                            ':f10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET G1 = :g1, G2 = :g2, G3 = :g3, G4 = :g4, G5 = :g5, G6 = :g6, G7 = :g7, G8 = :g8, G9 = :g9, G10 = :g10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':g1' =>  $reset,
                            ':g2' =>  $reset,
                            ':g3' =>  $reset,
                            ':g4' =>  $reset,
                            ':g5' =>  $reset,
                            ':g6' =>  $reset,
                            ':g7' =>  $reset,
                            ':g8' =>  $reset,
                            ':g9' =>  $reset,
                            ':g10' =>  $reset
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET H1 = :h1, H2 = :h2, H3 = :h3, H4 = :h4, H5 = :h5, H6 = :h6, H7 = :h7, H8 = :h8, H9 = :h9, H10 = :h10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = '$cinema'");
                    $result = $statement->execute(
                        array(
                            ':h1' =>  $reset,
                            ':h2' =>  $reset,
                            ':h3' =>  $reset,
                            ':h4' =>  $reset,
                            ':h5' =>  $reset,
                            ':h6' =>  $reset,
                            ':h7' =>  $reset,
                            ':h8' =>  $reset,
                            ':h9' =>  $reset,
                            ':h10' =>  $reset
                        )
                    );
                }

                if ($c_bacoor != $_POST["cinema_bacoor"]) {
                    $statement = $connection->prepare("UPDATE reservation SET A1 = :a1, A2 = :a2, A3 = :a3, A4 = :a4, A5 = :a5, A6 = :a6, A7 = :a7, A8 = :a8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                    $result = $statement->execute(
                        array(
                            ':a1' =>  $reset,
                            ':a2' =>  $reset,
                            ':a3' =>  $reset,
                            ':a4' =>  $reset,
                            ':a5' =>  $reset,
                            ':a6' =>  $reset,
                            ':a7' =>  $reset,
                            ':a8' =>  $reset,
                            ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET B1 = :b1, B2 = :b2, B3 = :b3, B4 = :b4, B5 = :b5, B6 = :b6, B7 = :b7, B8 = :b8, B9 = :b9, B10 = :b10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                    $result = $statement->execute(
                        array(
                            ':b1' =>  $reset,
                            ':b2' =>  $reset,
                            ':b3' =>  $reset,
                            ':b4' =>  $reset,
                            ':b5' =>  $reset,
                            ':b6' =>  $reset,
                            ':b7' =>  $reset,
                            ':b8' =>  $reset,
                            ':b9' =>  $reset,
                            ':b10' =>  $reset,
                            ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET C1 = :c1, C2 = :c2, C3 = :c3, C4 = :c4, C5 = :c5, C6 = :c6, C7 = :c7, C8 = :c8, C9 = :c9, C10 = :c10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                    $result = $statement->execute(
                        array(
                            ':c1' =>  $reset,
                            ':c2' =>  $reset,
                            ':c3' =>  $reset,
                            ':c4' =>  $reset,
                            ':c5' =>  $reset,
                            ':c6' =>  $reset,
                            ':c7' =>  $reset,
                            ':c8' =>  $reset,
                            ':c9' =>  $reset,
                            ':c10' =>  $reset,
                            ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET D1 = :d1, D2 = :d2, D3 = :d3, D4 = :d4, D5 = :d5, D6 = :d6, D7 = :d7, D8 = :d8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                    $result = $statement->execute(
                        array(
                            ':d1' =>  $reset,
                            ':d2' =>  $reset,
                            ':d3' =>  $reset,
                            ':d4' =>  $reset,
                            ':d5' =>  $reset,
                            ':d6' =>  $reset,
                            ':d7' =>  $reset,
                            ':d8' =>  $reset,
                            ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET E1 = :e1, E2 = :e2, E3 = :e3, E4 = :e4, E5 = :e5, E6 = :e6, E7 = :e7, E8 = :e8 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                    $result = $statement->execute(
                        array(
                            ':e1' =>  $reset,
                            ':e2' =>  $reset,
                            ':e3' =>  $reset,
                            ':e4' =>  $reset,
                            ':e5' =>  $reset,
                            ':e6' =>  $reset,
                            ':e7' =>  $reset,
                            ':e8' =>  $reset,
                            ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET F1 = :f1, F2 = :f2, F3 = :f3, F4 = :f4, F5 = :f5, F6 = :f6, F7 = :f7, F8 = :f8, F9 = :f9, F10 = :f10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                    $result = $statement->execute(
                        array(
                            ':f1' =>  $reset,
                            ':f2' =>  $reset,
                            ':f3' =>  $reset,
                            ':f4' =>  $reset,
                            ':f5' =>  $reset,
                            ':f6' =>  $reset,
                            ':f7' =>  $reset,
                            ':f8' =>  $reset,
                            ':f9' =>  $reset,
                            ':f10' =>  $reset,
                            ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET G1 = :g1, G2 = :g2, G3 = :g3, G4 = :g4, G5 = :g5, G6 = :g6, G7 = :g7, G8 = :g8, G9 = :g9, G10 = :g10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                    $result = $statement->execute(
                        array(
                            ':g1' =>  $reset,
                            ':g2' =>  $reset,
                            ':g3' =>  $reset,
                            ':g4' =>  $reset,
                            ':g5' =>  $reset,
                            ':g6' =>  $reset,
                            ':g7' =>  $reset,
                            ':g8' =>  $reset,
                            ':g9' =>  $reset,
                            ':g10' =>  $reset,
                            ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                        )
                    );
                    $statement = $connection->prepare("UPDATE reservation SET H1 = :h1, H2 = :h2, H3 = :h3, H4 = :h4, H5 = :h5, H6 = :h6, H7 = :h7, H8 = :h8, H9 = :h9, H10 = :h10 WHERE MOVIE_ID = '$curr_id' AND BRANCH_ID = '4' AND CINEMA_NO = :cinema_bacoor");
                    $result = $statement->execute(
                        array(
                            ':h1' =>  $reset,
                            ':h2' =>  $reset,
                            ':h3' =>  $reset,
                            ':h4' =>  $reset,
                            ':h5' =>  $reset,
                            ':h6' =>  $reset,
                            ':h7' =>  $reset,
                            ':h8' =>  $reset,
                            ':h9' =>  $reset,
                            ':h10' =>  $reset,
                            ':cinema_bacoor' =>  $_POST["cinema_bacoor"]
                        )
                    );
                }
            } else {
                $statement = $connection->prepare("UPDATE cinema SET ACTIVE = '0', MODIFIED_ON = '$today' WHERE BRANCH_ID = '4' AND MOVIE_ID = '$curr_id'");
                $result = $statement->execute();
            }
        }
    }
}
