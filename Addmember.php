<?php

$mysqli = include('connect.php');

// Check connection
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
    header("Location: index.php");
}
  
// input value 
$Name = $_POST['Name'];
$Address = $_POST['Address'];
$Email = $_POST['Email'];
$date_Created = date("Y-m-d H:i:s");
$expiration_Date=date('Y-m-d', strtotime('+1 year', strtotime($date_Created)) );
$Status = $_POST['Status'];

// Attempt insert query execution
$sql = "INSERT INTO Members (Name, Address, Email, Date_Created, Expiration_Date, Status) VALUES (\"$Name\",\"$Address\",\"$Email\",\"$date_Created\",\"$expiration_Date\",\"$Status\")";

$reset = "ALTER TABLE Members AUTO_INCREMENT = 1";

mysqli_query($link, $sql);
mysqli_query($link, $reset);




header("Location: https://gotogro.000webhostapp.com/Home.php");

 
// Close connection
mysqli_close($link);
?>