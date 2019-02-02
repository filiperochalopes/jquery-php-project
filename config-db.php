<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'Generaltech';
$dbname = 'paluana';

$mydb = new mysqli($dbhost,$dbuser,$dbpass,$dbname) or die("Error " . mysqli_error($conn));
$mydb->set_charset("utf8");
//mysql_close($conn);

?>