<?php
require_once "config.php";

$username = $operatingcompany= $password =$confirm_password = $EMAIL = "";
$username_err = $operatingcompany_err= $password_err = $confirm_password_err = $EMAIL_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["NAME"]))){
        $username_err = "Username cannot be blank";
    }


    if(empty(trim($_POST['OPCO']))){
        $operatingcompany_err = "OPCO cannot be blank";
    }

    else{
        $operatingcompany = trim($_POST['OPCO']);
    }

    // Check if username is empty
    if(empty(trim($_POST["EMAIL-ID"]))){
      $EMAIL_err = "EMAIL-ID cannot be blank";
  }
  else{
      $sql = "SELECT id FROM signup WHERE EMAILID = ?";
      $stmt = mysqli_prepare($conn, $sql);
      if($stmt)
      {
          mysqli_stmt_bind_param($stmt, "s", $param_username2);

          // Set the value of param username
          $param_username2 = trim($_POST['EMAIL-ID']);

          // Try to execute this statement
          if(mysqli_stmt_execute($stmt)){
              mysqli_stmt_store_result($stmt);
              if(mysqli_stmt_num_rows($stmt) == 1)
              {
                  $EMAIL_err = "This email id is already registered. Try forgot password.";
              }
              else{
                  $EMAIL = trim($_POST['EMAIL-ID']);
              }
          }
          else{
              echo "Something went wrong";
          }
      }
  }
  if (!$stmt) {
    printf("Error message: %s\n", mysqli_error($conn));
}
  mysqli_stmt_close($stmt);

  // Check for password
if(empty(trim($_POST['password']))){
  $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
  $password_err = "Password cannot be less than 5 characters";
}
else{
  $password = trim($_POST['password']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
  $confirm_password_err = "Passwords should match";
}


    // If there were no errors, go ahead and insert into the database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)  && empty($EMAIL_err))
    {
        $sql = "INSERT INTO signup (NAME,OPCO,EMAILID,PASSWORD,folders) VALUES ( ?, ? , ? , ? ,';')";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt)
        {
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_operatingcompany, $param_username2,$param_password);

            // Set these parameters
            $param_username = $username;
            $param_username2 = $EMAIL;
            $param_operatingcompany = $operatingcompany;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // Try to execute the query
            if (mysqli_stmt_execute($stmt))
            {
                header("location: login.php");
            }
            else{
                echo "Something went wrong... cannot redirect!";
            }
        }

          if (!$stmt) {
            printf("Error message: %s\n", mysqli_error($conn));
        }
        mysqli_stmt_close($stmt);
    }


    mysqli_close($conn);
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
    <form class="form-signin" action="" method="post">
  <div class="text-center mb-4">
  <img class="mb-4" src="assets/img/avtaar.png" alt="" width="144" height="144">
    <h1 class="h3 mb-3 font-weight-normal">User Sign UP</h1>
  </div>

  <div class="form-label-group">

    <input type="text" id="NAME" name="NAME" class="form-control" placeholder="Email address" required autofocus>
    <label for="name">NAME</label>
    <?php
    if(!empty($username_err))
    echo "<p class='text-danger'>.$username_err.</p>";
    ?>
  </div>

  <div class="form-label-group">
    <input type="test" id="OPCO" name="OPCO" class="form-control" placeholder="Email address" required autofocus>
    <label for="operating comapany">OPERATING COMPANY</label>
  </div>

  <div class="form-label-group">
    <input type="email" id="inputEmail" name="EMAIL-ID" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputEmail">ENTERPRISE Email address</label>
    <?php
    if(!empty($Email_err))
    echo "<p class='text-danger'>.$EMAIL_err.</p>";
    ?>
  </div>

  <div class="form-label-group">
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
    <label for="inputPassword">Password</label>
    <?php
    if(!empty($password_err))
    echo "<p class='text-danger'>.$password_err.</p>";
    ?>
  </div>

  <div class="form-label-group">
    <input type="password" id="confirm_Password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
    <label for="inputPassword2">Confirm Password</label>
    <?php
    if(!empty($confirm_password_err))
    echo "<p class='text-danger'>.$confirm_password_err.</p>";
    ?>
  </div>

  <button class="btn btn-lg btn-primary btn-block" type="submit">Continue</button>
</form>
</body>
</html>
