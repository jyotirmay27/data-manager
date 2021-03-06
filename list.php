<?php
require(__DIR__.'/import.php');

ob_start();
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
  </head>
  <body>
    <ul id="hexGrid">

    <?php
    $page = $_SERVER['PHP_SELF'];

    if(isset($_GET['url'])){
        $_GET['url']=urldecode($_GET['url']);
        $_GET['url']=trim($_GET['url'], '/');
        $_GET['url']=rtrim($_GET['url'], '/');
    }

    if(!isset($_GET['url']) || dir_in_tree($_GET['url'])){
        //If nothing specified or out of scope, redirect to '/'
        header("Location: ". $page ."?url=");
        echo "</ul></body></html>";
        exit;
    }

    $resource_url=$repo_root.$_GET['url'];

    if(is_file($resource_url)){
        header("Location: ". $resource_url);
        exit;
    }

    $dir=array_diff(scandir($resource_url), array('..', '.'));
	
    if(check_ownership($db, split_session()[1], $resource_url)===true){

		$imgurl='assets/img/rb.jpg';
        echo "<li class='hex'>";
        echo "<div class='hexIn'>";
        echo "<a class='hexLink' href='modify.php?url=".$resource_url."'>";
        echo "<img src='". $imgurl ."'>";
        echo "<p>Delete data</p>";
        echo "</a>";
        echo "</div>";
        echo "</li>";
    }

    forEach(array_keys($dir) as $key){
        $url=$_GET['url'].'/'.$dir[$key];
		if(empty($url))
		continue;
        $x=explode("/", $url);
        $filename=end($x);
        $imgurl=filetypeimg($filename);
        echo "<li class='hex'>";
        echo "<div class='hexIn'>";
        echo "<a class='hexLink' href='?url=". urlencode($url) ."'>";
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
