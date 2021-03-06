<?php
session_start();

require(__DIR__."/conf.php");
require(__DIR__."/config.php");

$errors = [];
$user_id = "";
// connect to database
$db = $conn;

if (isset($_POST['reset-password']) && isset($_POST['email'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    // ensure that the user exists on our system
    $query = "SELECT EMAILID FROM signup WHERE EMAILID='$email'";
    $results = mysqli_query($db, $query);

    if (empty($email)) {
      array_push($errors, "Your email is required");
    }else if(mysqli_num_rows($results) <= 0) {
      array_push($errors, "Sorry, no user exists on our system with that email");
    }
    // generate a unique random token of length 100
    $token = bin2hex(random_bytes(50));

    if (count($errors) == 0) {
      // store token in the password-reset database table against the user's email
      $sql = "INSERT INTO password_reset(email, token) VALUES ('$email', '$token')";
      $results = mysqli_query($db, $sql);

      // Send email to user with the token in a link they can click on
      $to = $email;
      $subject = "Reset your password";
      $msg = "Hi there, click on this ".$context."new_password.php?token=" . $token . "link to reset your password on our site";
      $msg = wordwrap($msg,70);
      $headers = "To: ".$email."\r\nFrom:  ".$sender_email;
      mail($to, $subject, $msg, $headers);
      header('location: resetpass.php?email=' . $email);
    }
  }

  // ENTER A NEW PASSWORD
  if (isset($_POST['new_password'])) {
    $new_pass = mysqli_real_escape_string($db, $_POST['new_pass']);
    $new_pass_c = mysqli_real_escape_string($db, $_POST['new_pass_c']);

    // Grab to token that came from the email link
    $token = $_POST['new_password'];
    if (empty($new_pass) || empty($new_pass_c)) array_push($errors, "Password is required");
    if ($new_pass !== $new_pass_c) array_push($errors, "Password do not match");
    if (count($errors) == 0) {
      // select email address of user from the password_reset table
      $sql = "SELECT email FROM password_reset WHERE token='$token' LIMIT 1";
      $results = mysqli_query($db, $sql);
      $email = mysqli_fetch_assoc($results)['email'];

      if ($email) {
        $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);//md5($new_pass);
        $sql = "UPDATE signup SET PASSWORD='$new_pass' WHERE EMAILID='$email'";
        $results = mysqli_query($db, $sql);
        $sql = "DELETE FROM password_reset WHERE email='$email'";
        $results = mysqli_query($db, $sql);
        header('location: login.php');
      }
    }
  }
  ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Login</title>

    <!-- Bootstrap core CSS -->
<link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="assets/css/floating-labels.css" rel="stylesheet">
  </head>
  <body>
    <form class="form-signin" action="resetpass.php" method="post">
  <div class="text-center mb-4">
    <img class="mb-4" src="assets/img/avtaar.png" alt="" width="144" height="144">
    <h1 class="h3 mb-3 font-weight-normal">Forgot password</h1>
  </div>

  <div class="form-label-group">
    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputEmail">Email address</label>
    <?php
    if(count($errors) != 0)
    echo "<p class='text-danger'>Something you entered is wrong </p>";
    ?>
  </div>


  <button class="btn btn-lg btn-primary btn-block" type="submit" name="reset-password">Continue</button>
</form>
</body>
</html>
