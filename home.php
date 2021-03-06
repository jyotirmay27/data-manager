<?php
require(__DIR__.'/import.php');

$repo=$repo_root.date('Y-F', time()).'/';

if(!is_dir($repo)){
  mkdir($repo, 0660);
}

$email=split_session()[1];
$com="SELECT NAME, folders FROM {$table_userdata} WHERE EMAILID = '{$email}'";
$result=$db->query($com);
if(!$result){
  header('Location: error.php?err=15');
  exit;
}
$r=$result->fetch_row();
$usr=$r[0];
$result->close();

$a=array_diff(scandir($repo), array('..', '.'));
$o=explode(";", $r[1]);
$o=array_diff($o, array(''));
forEach(array_keys($o) as $key)
{
	$x=explode("/", $o[$key]);
	$o[$key]=end($x);
}
$no=array_diff($a, $o);
?>

<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Jekyll v4.1.1">
  <title>Dashboard</title>

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
  <link href="assets/css/dashboard.css" rel="stylesheet">
  </head>
  <body>
  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Coding Strings</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
  </button>
  <span class="navbar-text"><?php echo $usr; ?></span>
  <ul class="navbar-nav px-3">
  <li class="nav-item text-nowrap">
    <a class="nav-link" href="begining.php?logout=11">Sign out</a>
  </li>
  </ul>
</nav>

<div class="container-fluid">
  <div class="row">
  <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="sidebar-sticky pt-3">
    <ul class="nav flex-column">
      <li class="nav-item">
      <a class="nav-link" href="#" onclick="changeto('')">
        <span data-feather="home"></span>
        Home
      </a>
    </li>
    <?php
    forEach(array_keys($no) as $key){
      $url=$no[$key];
			$url=$repo.$url;
		if(empty($url))
		continue;
      $x=explode("/", $url);
      $foldername=end($x);
			$url=rtrim($url, $foldername);
	  $url=trim($url, '/');
      $url=urlencode(trim($url, $repo_root)).'/'.$foldername;
				echo '<li class="nav-item">';
				echo "<a class=\"nav-link\" href=\"#\" onclick=\"changeto('{$url}')\">";
				echo '<span data-feather="folder"></span>';
				echo $foldername;
				echo '</a>';
				echo '</li>';
    }
    ?>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>Create new folder</span>
      <a class="d-flex align-items-center text-muted" href="folder.php" aria-label="Create a new folder">
      <span data-feather="plus-circle"></span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
    <?php
    forEach(array_keys($o) as $key){
      $url=$o[$key];
			$url=$repo.$url;
		if(empty($url))
		continue;
      $x=explode("/", $url);
      $foldername=end($x);
			$url=rtrim($url, $foldername);
	  $url=trim($url, '/');
      $url=urlencode(trim($url, $repo_root)).'/'.$foldername;
				echo '<li class="nav-item">';
				echo "<a class=\"nav-link\" href=\"#\" onclick=\"changeto('{$url}')\">";
				echo '<span data-feather="folder"></span>';
				echo $foldername;
				echo '</a>';
				echo '</li>';
    }
    ?>
    </ul>
    </div>
  </nav>

  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Index of the repository</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group mr-2">
      <a class="btn btn-sm btn-outline-secondary" href="upload.php"><span data-feather="share"></span>&nbsp;Upload files</a>
      <a href="search.php" class="btn btn-sm btn-outline-secondary"><span data-feather="search"></span>&nbsp;Search</a>
      </div>
    </div>
    </div>
    <div class="embed-responsive embed-responsive-16by9">
      <iframe class="embed-responsive-item" id="indexplaceholder" src="list.php"></iframe>
    </div>
  </main>
  </div>
</div>
<script src="assets/js/jquery.min.js"></script>
</script><script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/feather.min.js"></script>
<script>
feather.replace();

function changeto(url){
  document.getElementById("indexplaceholder").src='list.php?url='+decodeURIComponent(url);
}
</script>
</html>
