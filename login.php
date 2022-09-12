<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

// These only work for CRYPT_SHA512, but it should give you an idea of how crypt() works.
// $Salt = uniqid(); // Could use the second parameter to give it more entropy.
// $Algo = '6'; // This is CRYPT_SHA512 as shown on http://php.net/crypt
// $Rounds = '10000'; // The more, the more secure it is!
//
// // This is the "salt" string we give to crypt().
// $CryptSalt = '$' . $Algo . '$rounds=' . $Rounds . '$' . $Salt;


$mysqli = include('connect.php');

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
  header("Location: index.php");
}

$sql = "SELECT `Salt`, `Username`, `Password` FROM `Verified_Users` WHERE `Username` = \"$username\"";

$result = $mysqli -> query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    // Username exists, query successful
    $CryptSalt = $row["Salt"];
    $hashed_password = crypt($password, $CryptSalt);


    if($row["Username"] == $username && $row["Password"] == $hashed_password){
      // Password correct, authentication successful
      session_start();
      $_SESSION["loggedin"] = "true";
      $_SESSION["username"] = $username;
      header("Location: home.php");
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
