<?php
require(__DIR__.'/import.php');

$ret=0;
$folder = $_POST['folder'];
if(is_valid_foldername($folder)===true){
    $ret=create_folder($db, split_session()[1], $folder);
}
else{
    echo '<html><head></head><body>';
    echo "Folder creation failed because the name supplied was invalid</br>";
    echo "<a href='home.php'>Click here to go to home</a>";
    echo '</body></html>';
    exit;
}

if($ret!==0){
	var_dump($ret);
	var_dump($folder);
    header('Location: error.php?err=5');
    exit;
}

echo '<html><head></head><body>';
echo "Folder created successfully!";
header("location: home.php");
echo '</body></html>';

?>
