<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once '../phpmailer/Exception.php';
require_once '../phpmailer/PHPMailer.php';
require_once '../phpmailer/SMTP.php';

$mail = new PHPMailer(true);

$alert = '';

if ($code == $temp_code) {

  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'nearer.tup@gmail.com'; // Email as SMTP server
    $mail->Password = 'nearer_123'; // Email SMTP server Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = '587';

    $mail->setFrom('t1movies.tup@gmail.com'); // Email as SMTP server
    $mail->addAddress($email_forgot); // Email receiver

    $mail->isHTML(true);
    $mail->Subject = 'T1 Movies (Verification Code)';
    $mail->Body = "<h2>Verification Code :</h2><h1>$code</h1><h3>Copy and paste it to the Verification code text input!</h3>";

    $mail->send();

    /*$alert = '<div class="alert-success">
                 <span>Message Sent! Thank you for contacting us.</span>
                </div>';*/
  } catch (Exception $e) {
    /*
    $alert = '<div class="alert-error">
                <span>' . $e->getMessage() . '</span>
              </div>';*/
  }
} else if ($_SESSION["send"] == "send") {

  $email = $_SESSION["send_email"];
  $movie = $_SESSION["send_movie"];
  $theater = $_SESSION["send_branch"];
  $date = $_SESSION["send_date"];
  $time = $_SESSION["send_time"];
  $quantity = $_SESSION["send_quantity"];
  $seats =  $_SESSION["send_seats"];
  $price = $_SESSION["send_price"];

  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 't1movies.tup@gmail.com'; // Email as SMTP server
    $mail->Password = 't1movies_123'; // Email SMTP server Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = '587';

    $mail->setFrom('t1movies.tup@gmail.com'); // Email as SMTP server
    $mail->addAddress($email); // Email receiver

    $mail->isHTML(true);
    $mail->Subject = 'T1 Movies (Ticket Redemption)';
    $mail->Body = "<h1>T1 Movies (Ticket Reserved)</h1>
                    <h2>Movie: </h2>
                    <h3>$movie</h3>
                    <h2>Movie Branch: </h2>
                    <h3>$theater</h3>
                    <h2>Date: </h2>
                    <h3>$date</h3>
                    <h2>Time: </h2>
                    <h3>$time</h3>
                    <h2>Seat/s: ( $quantity )</h2>
                    <h3>$seats</h3>
                    <h2>Price: </h2>
                    <h3>₱$price</h3>
                    <h4>Purchased through Paypal.</h4>
                    <h4>Show this ticket/s to the cinema operators for ticket validation.</h4>";

    $mail->send();

    $_SESSION["send"] = "";
    $_SESSION["send_email"] = "";
    $_SESSION["send_movie"] = "";
    $_SESSION["send_branch"] = "";
    $_SESSION["send_date"] = "";
    $_SESSION["send_time"] = "";
    $_SESSION["send_quantity"] = "";
    $_SESSION["send_seats"] = "";
    $_SESSION["send_price"] = "";

    /*$alert = '<div class="alert-success">
                 <span>Message Sent! Thank you for contacting us.</span>
                </div>';*/
  } catch (Exception $e) {
    /*
    $alert = '<div class="alert-error">
                <span>' . $e->getMessage() . '</span>
              </div>';*/
  }
}
