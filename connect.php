<?php

//Change to your MariaDB server settings
//May even work with MySQL server, but hasn't been thoroughly tested
$host="localhost";
$username="root";
$password="";
$db_name="signup";

//Change anything below this line at your own risk
$db = new mysqli($host, $username, $password, $db_name);

if ($db->connect_errno) {
    header('Location: error.php?err=15');
    exit();
}
?>
