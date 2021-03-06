<?php
require(__DIR__."/import.php");

$page = $_SERVER['PHP_SELF'];

if(isset($_GET['url'])){
    $_GET['url']=urldecode($_GET['url']);
    $_GET['url']=trim($_GET['url'], '/');
    $_GET['url']=rtrim($_GET['url'], '/');
}

if(!isset($_GET['url']) || !is_dir($_GET['url'])){
    header("Location: error.php?err=6");
    echo "</ul></body></html>";
    exit;
}

$resource_url=$_GET['url'];

$arr=array_diff(scandir($resource_url), array('..', '.'));
?>
<html>
<head>
<link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
</head>
<body>
<form action="delete.php" method="post">
<?php
$i=0;
forEach($arr as $file){
    echo '<label class="form-check-label list-group-item list-group-item-action" for="exampleCheck'. $i .'"><input type="checkbox" class="form-check-input" id="exampleCheck'. $i .'" name="del[]" value="'.urlencode($resource_url.'//'.$file).'">'. $file .'</label>';
	//echo "\n";
    $i++;
}
?>
</br>
<button class="btn btn-lg btn-primary btn-block" type="submit">Delete</button>
</form>
</body>
</html>
