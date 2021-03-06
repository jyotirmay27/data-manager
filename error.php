<?php
$num=0;
if(isset($_GET['err'])){
    $num=intval($_GET['err']);
}
$msg="If it persists, try contacting your server administrator with information about what you were try to do when the error appeared and error code #".$num;

if($num===5){//Folder creation error
    $msg="Could not create the specified folder, try contacting the administrator if error persists";
}
elseif($num===6){//Folder does not exist
    $msg="Could not find the specified folder, try contacting the administrator if error persists";
}
elseif($num===8){//Deletion error
    $msg="There was some error in deleting the specified files, try contacting the administrator if error persists";
}
elseif($num===9){//Ownership error
    $msg="You cannot change what you do not own or did not create, contact the administrator if you think there is some mistake";
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
    <title>Error</title>

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
  </head>
  <body class="text-center">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  <header class="masthead mb-auto">
    <div class="inner">
      <h3 class="masthead-brand">Error</h3>
    </div>
  </header>

  <main role="main" class="inner cover">
    <h1 class="cover-heading">Error encountered while processing your request</h1>
    <p class="lead"><?php echo $msg; ?></p>
    <p class="lead">
      <a href="home.php" class="btn btn-lg btn-secondary">Go to home</a>
    </p>
  </main>

  <footer class="mastfoot mt-auto">
  </footer>
</div>
</body>
</html>
