<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'id19550282_wp_25e04e32468a6e8648473b79738a8ac9');
define('DB_PASSWORD', '>[B!L^7e9q#|L>)U');
define('DB_NAME', 'id19550282_wp_25e04e32468a6e8648473b79738a8ac9');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
else{
   echo "<h2>This is working</h2>";
}
?>
