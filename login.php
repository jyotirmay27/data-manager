<?php
     $Email_err = $thpassword_error = "";
     $error=0;
     if(isset($_GET['err'])){
    $error=intval($_GET['err']);
}
if($error == 13)
{
  $Email_err="Email address cannot be blank";

}
if($error == 12)
{
  $thpassword_err="Password cannot be blank";

}
if($error == 14)
{
  $Email_err="Either Email is wrong or Password";

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
    <form class="form-signin" action="verify.php" method="post">
  <div class="text-center mb-4">
    <img class="mb-4" src="assets/img/avtaar.png" alt="" width="144" height="144">
    <h1 class="h3 mb-3 font-weight-normal">User Login</h1>
  </div>

  <div class="form-label-group">
    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputEmail">Email address</label>
    <?php 
    if(!empty($Email_err))
    echo "<p class='text-danger'>.$Email_err.</p>";
    ?>
  </div>

  <div class="form-label-group">
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
    <label for="inputPassword">Password</label>
    <?php
    if(!empty($thpassword_err))
    echo "<p class='text-danger'>".$thpassword_err."</p>";
    ?>
  </div>
  </br><a href="forget.php">Forgost Password?</a>
  <a href="register.php">&nbsp; New user?</a></br></br></br>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Continue</button>
</form>
</body>
</html>
