<?php


$mysqli = include('connect.php');

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);
$permission_level = htmlspecialchars($_POST['permission_level']);


// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
  header("Location: index.php");
}

$Salt = uniqid(); // Could use the second parameter to give it more entropy.
$Algo = '6'; // This is CRYPT_SHA512 as shown on http://php.net/crypt
$Rounds = '10000'; // The more, the more secure it is!

// This is the "salt" string we give to crypt().
$CryptSalt = '$' . $Algo . '$rounds=' . $Rounds . '$' . $Salt;

$hashed_password = crypt($password, $CryptSalt);
$date_created = date("Y-m-d H:i:s");


$sql = "INSERT INTO `Verified_Users`(`Permission_level`, `Salt`, `Username`, `Password`, `Date_Created`) VALUES (\"$permission_level\",\"$CryptSalt\",\"$username\",\"$hashed_password\",\"$date_created\")";

echo "SQL: " . $sql;
if ($mysqli -> query($sql) === FALSE) {
  echo "SQL error: " . $mysqli -> error;
  header("Location: home.php");
} else {
  header("Location: home.php");
}
?>
