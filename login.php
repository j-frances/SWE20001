<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

$mysqli = include('connect.php');


$username = base64_decode($_POST['username']);
$password = base64_decode($_POST['password']);


// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  header("Location: index.php");
  exit;
}


$sql = "SELECT `Salt`, `Username`, `Password` FROM `Verified_Users` WHERE `Username` = \"$username\"";

$result = $mysqli -> query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    // Username exists, query successful
    $CryptSalt = $row["Salt"];
    $hashed_password = crypt($password, $CryptSalt);

    if($row["Username"] == $username && $row["Password"] == strval($hashed_password)){
      // Password correct, authentication successful
      session_start();
      $_SESSION["loggedin"] = "true";
      $_SESSION["username"] = $username;
      
      header('Location: https://gotogro.000webhostapp.com/home.php');
      //exit;
    }else{
        // Password incorrect, authentication failed
        header("Location: index.php");
    }
  }
} else {
    // Username doesn't exist, query unsuccessful
    header("Location: index.php");
}
?>
