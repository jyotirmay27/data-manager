<?php
require(__DIR__."/import.php");

$email=split_session()[1];
$com="SELECT NAME, folders FROM {$table_userdata} WHERE EMAILID = '{$email}'";
$result=$db->query($com);
$r=$result->fetch_row();
$usr=$r[0];
$result->close();
if(isset($_GET['url']))
{


if(is_file(urldecode($_GET['url'])))
{
  //$mypdf="http://localhost/14/".urldecode($_GET['url']);
  //echo "<script>window.open('$mypdf', '_blank');</script>";
        header("Location: ". urldecode($_GET['url']));
        exit;
    }
}

if($_SERVER['REQUEST_METHOD']=='POST')
{
$filename = $_POST['name'];

$final=search_by_filename($db,$filename);
$x=explode(",", $filename);
$finaltag= search_by_tags($db, $x);
$finalm=array_merge($final, $finaltag);
$finali=array_intersect($final, $finaltag);
$finald=array_diff($finalm, $finali);
$finals=array_merge($finald, $finali);
}

elseif($_SERVER['REQUEST_METHOD']=='GET')
{header("Location: error.php?err=1");
exit;}
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>List of things</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="assets/css/hexagons.css">
    <link href='assets/gfonts/style.css' rel='stylesheet' type='text/css'>
    <script src="assets/js/jquery.min.js"></script>
  <link href="assets/css/dashboard.css" rel="stylesheet">
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>
  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" style="font-size:20px; color:white;" href="home.php">Home</a>
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



</nav>
    <ul id="hexGrid">

    <?php
    forEach( $finals as $value)
    {
        $imgurl=filetypeimg($value);
        $x=explode("/", $value);
        $filename=end($x);
        echo "<li class='hex'>";
        echo "<div class='hexIn'>";
        echo "<a target='_blank' class='hexLink' href='?url=". urlencode($value) ."'>";
        echo "<img src='". $imgurl ."'>";
        echo "<p>". $filename ."</p>";
        echo "</a>";
        echo "</div>";
        echo "</li>";
    }
?>



        </ul>
      </body>
    </html>

<?php ob_flush(); ?>
