<?php

$mysqli = include('connect.php');

// Check connection
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
    header("Location: index.php");
}
  
// input value 
$productName = $_POST['ProductName'];
$quantity = $_POST['Quantity'];
$price = $_POST['Price'];

// Attempt insert query execution
$sql = "INSERT INTO Products (ProductName, Quantity, Price) VALUES (\"$productName\",\"$quantity\",\"$price\")";

$reset = "ALTER TABLE Products AUTO_INCREMENT = 1";

mysqli_query($link, $sql);
mysqli_query($link, $reset);




header("Location: https://gotogro.000webhostapp.com/Product.php");


//if(mysqli_query($link, $sql)){
//   echo "Records inserted successfully.";
//} else{
//    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
//}
 
// Close connection
mysqli_close($link);
?>
