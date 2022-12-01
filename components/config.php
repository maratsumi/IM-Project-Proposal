<?php
// @TODO
// Change DB_USERNAME to corresponding username
// Change DB_NAME to corresponding name
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'demo');
 
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
?>