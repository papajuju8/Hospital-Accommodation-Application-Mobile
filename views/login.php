<?php
include('session.php');
if(isset($_POST['login_button'])) {
    
  $email = $_POST['user_email'];
  $password = $_POST['user_password'];
   
    $conn = mysqli_connect('localhost', 'root', '');
    $db = mysqli_select_db($conn,'nearer');
    $query = mysqli_query($conn,"SELECT * FROM users_profile WHERE user_email = '$email' AND user_password = '$password'");
    $rows = $query->fetch_assoc();

    if($rows){
      $_SESSION['user_id'] = $rows['user_id'];
      header("Location: ../index.php");
    }

    else{
      echo "<script> alert('Invalid Email Address or Password!'); window.location = 'login_form.php' </script>";
      }
        mysqli_close($conn);
    }

?>