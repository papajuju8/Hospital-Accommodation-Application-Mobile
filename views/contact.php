<?php 

require '../source/db_connect.php';

if(isset($_POST['submit_button'])){
    $subject = $_POST['issueSubject'];
    $description = $_POST['desc'];
    date_default_timezone_set("Asia/Manila");
    $date = date("Y-m-d h:i:sa");
    $status = "In Queue";

    $conn = mysqli_connect('localhost', 'root', '');
    $db = mysqli_select_db($conn, 'nearer');
    $mysqli->query("INSERT INTO ticket (subject, issue, date_issued, status_update) VALUES('$subject', '$description', '$date', '$status') ")
          or die($mysqli->error);
          echo "<script> alert('Issue/concern sent successfully!'); window.location = '../index.php' </script>";

}

?>