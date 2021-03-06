<?php
if (session_id() == ""){
  session_start();
}

require(__DIR__.'/conf.php');
require(__DIR__.'/connect.php');
require(__DIR__.'/helper.php');
require(__DIR__.'/functions.php');

if(!isset($_SESSION['uid'])){
    header('Location: login.php');
    exit;
}
?>
