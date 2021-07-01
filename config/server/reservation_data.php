<?php
include('../config_pdo.php');
include('reservation_records.php');

if (isset($_POST)) {
    $output = array();

    $statement = $connection->prepare("SELECT * FROM reservation WHERE MOVIE_ID = '" . $_POST["movie_id"] . "' AND BRANCH_ID = '" . $_POST["theater"] . "' AND DAY = '" . $_POST["day"] . "' AND TIME = '" . $_POST["time"] . "'");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["a1"] = $row["A1"];
        $output["a2"] = $row["A2"];
        $output["a3"] = $row["A3"];
        $output["a4"] = $row["A4"];
        $output["a5"] = $row["A5"];
        $output["a6"] = $row["A6"];
        $output["a7"] = $row["A7"];
        $output["a8"] = $row["A8"];
        $output["b1"] = $row["B1"];
        $output["b2"] = $row["B2"];
        $output["b3"] = $row["B3"];
        $output["b4"] = $row["B4"];
        $output["b5"] = $row["B5"];
        $output["b6"] = $row["B6"];
        $output["b7"] = $row["B7"];
        $output["b8"] = $row["B8"];
        $output["b9"] = $row["B9"];
        $output["b10"] = $row["B10"];
        $output["c1"] = $row["C1"];
        $output["c2"] = $row["C2"];
        $output["c3"] = $row["C3"];
        $output["c4"] = $row["C4"];
        $output["c5"] = $row["C5"];
        $output["c6"] = $row["C6"];
        $output["c7"] = $row["C7"];
        $output["c8"] = $row["C8"];
        $output["c9"] = $row["C9"];
        $output["c10"] = $row["C10"];
        $output["d1"] = $row["D1"];
        $output["d2"] = $row["D2"];
        $output["d3"] = $row["D3"];
        $output["d4"] = $row["D4"];
        $output["d5"] = $row["D5"];
        $output["d6"] = $row["D6"];
        $output["d7"] = $row["D7"];
        $output["d8"] = $row["D8"];
        $output["e1"] = $row["E1"];
        $output["e2"] = $row["E2"];
        $output["e3"] = $row["E3"];
        $output["e4"] = $row["E4"];
        $output["e5"] = $row["E5"];
        $output["e6"] = $row["E6"];
        $output["e7"] = $row["E7"];
        $output["e8"] = $row["E8"];
        $output["f1"] = $row["F1"];
        $output["f2"] = $row["F2"];
        $output["f3"] = $row["F3"];
        $output["f4"] = $row["F4"];
        $output["f5"] = $row["F5"];
        $output["f6"] = $row["F6"];
        $output["f7"] = $row["F7"];
        $output["f8"] = $row["F8"];
        $output["f9"] = $row["F9"];
        $output["f10"] = $row["F10"];
        $output["g1"] = $row["G1"];
        $output["g2"] = $row["G2"];
        $output["g3"] = $row["G3"];
        $output["g4"] = $row["G4"];
        $output["g5"] = $row["G5"];
        $output["g6"] = $row["G6"];
        $output["g7"] = $row["G7"];
        $output["g8"] = $row["G8"];
        $output["g9"] = $row["G9"];
        $output["g10"] = $row["G10"];
        $output["h1"] = $row["H1"];
        $output["h2"] = $row["H2"];
        $output["h3"] = $row["H3"];
        $output["h4"] = $row["H4"];
        $output["h5"] = $row["H5"];
        $output["h6"] = $row["H6"];
        $output["h7"] = $row["H7"];
        $output["h8"] = $row["H8"];
        $output["h9"] = $row["H9"];
        $output["h10"] = $row["H10"];
    }

    echo json_encode($output);
}
