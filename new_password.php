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
    <form class="form-signin" action="forget.php" method="post">
  <div class="text-center mb-4">
    <img class="mb-4" src="assets/img/avtaar.png" alt="" width="144" height="144">
    <h1 class="h3 mb-3 font-weight-normal">Forgot password</h1>
  </div>

  <div class="form-label-group">
    <input type="password" id="inputEmail" name="new_pass" class="form-control" placeholder="New password" required autofocus>
    <label for="inputEmail">Password</label></br>
  </div>
  
    <div class="form-label-group">
    <input type="password" id="inputPass" name="new_pass_c" class="form-control" placeholder="Confirm new password" required autofocus>
    <label for="inputPass">Confirm Password</label></div>
	
	<input type="hidden" name="new_password" value="<?php echo $_GET['token'];?>"></input>


  <button class="btn btn-lg btn-primary btn-block" type="submit" name="reset-password">Continue</button>
</form>
</body>
</html>
