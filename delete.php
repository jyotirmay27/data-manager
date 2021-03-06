<?php
require(__DIR__."/import.php");

if(!isset($_POST['del'])){
    header("Location: error.php?err=8");
    exit;
}

echo '<html><head></head><body>';

foreach($_POST['del'] as $path){
    $path=urldecode($path);
    $path=trim($path, '/');
    $path=rtrim($path, '/');
    $x=explode('//', $path);
    if(check_ownership($db, split_session()[1], $x[0])!==true){
        header("Location: error.php?err=9");
        exit;
    }
    $path=str_replace("//", "/", $path);

    echo 'Deleting '.$path;
	$com="DELETE FROM {$table_paths} WHERE name = '{$path}'";
	$db->query($com);
    unlink($path);
    echo '</br>';
}
header("location: list.php");
?>
