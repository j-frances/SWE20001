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
$Email = $_POST['Email'];
$Date_Created = $_POST['Date_Created'];
$Expiration_Date = $_POST['Expiration_Date'];
$Status = $_POST['Status'];

// Attempt insert query execution
$sql = "INSERT INTO Members (Name, Email, Date_Created, Expiration_Date, Status) VALUES (\"$Name\",\"$Email\",\"$Date_Created\",\"$Expiration_Date\",\"$Status\")";

$reset = "ALTER TABLE Members AUTO_INCREMENT = 1";

mysqli_query($link, $sql);
mysqli_query($link, $reset);




header("Location: https://gotogro.000webhostapp.com/Product.php");

 
// Close connection
mysqli_close($link);
?>