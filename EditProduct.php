<?php

$mysqli = include('connect.php');

// Check connection
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
    header("Location: index.php");
}
  
// input value
foreach($_POST['ID'] as $ID){
    $ID = $_POST['ID'];
    $productName = $_POST['ProductName'];
    $quantity = $_POST['Quantity'];
    $price = $_POST['Price'];

    $select = mysqli_query($mysqli, "SELECT `ID` FROM `Products` WHERE `ID` = '".$_POST['ID']."'") or exit(mysqli_error($mysqli));
    if(mysqli_num_rows($select)) {
        $sql = "UPDATE `Products` SET `ProductName` = \"$productName\", `Quantity`= \"$quantity\", `Price` = \"$price\" WHERE `ID` = \"$ID\"";
        mysqli_query($link, $sql);
        
    }else{
        echo "Product does not exist";
    }
// Attempt insert query execution
//$sql = "INSERT INTO Products (ProductName, Quantity, Price) VALUES (\"$productName\",\"$quantity\",\"$price\")";

}
header("Location: https://gotogro.000webhostapp.com/home.php");
 
// Close connection
mysqli_close($link);
?>

