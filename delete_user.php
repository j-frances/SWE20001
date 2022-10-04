<?php
    $mysqli = include('connect.php');

    // Check connection
    if ($mysqli -> connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
      exit();
      header("Location: index.php");
    }

    foreach($_POST["Check"] as $ID) {
        $sql = "DELETE FROM `Verified_Users` WHERE `ID` = \"$ID\"";
        if ($mysqli -> query($sql) === FALSE) echo "SQL error: " . $mysqli -> error;
        else header("Location: home.php"); // Non-unique username
    }
?>
