<?php
include('../source/db_connect.php');
$conn = mysqli_connect('localhost', 'root', '');
$db = mysqli_select_db($conn,'nearer');
session_start();
if (isset($_SESSION['user_id'])){
    $session_id = $_SESSION['user_id'];
    $session_query = mysqli_query($conn,"SELECT * from users_profile where user_id = '$session_id'");
    $user_row = $session_query->fetch_assoc();
    $email = $user_row['user_email'];
    }
?>
