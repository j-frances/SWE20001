<?php
$connection = include('connect.php');

if($connection === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
}
 else{
    $sql = "SELECT * FROM Members";
    $result = mysqli_query($connection, $sql) or die("Selection Error " . mysqli_error($connection));
    
    $fp = fopen('books.csv', 'w');
    
    while($row = mysqli_fetch_assoc($result))
    {
            fputcsv($fp, $row);
    }


}
?>
