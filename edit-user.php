<?php

$mysqli = include('connect.php');

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
  header("Location: index.php");
}

$Salt = uniqid(); // Could use the second parameter to give it more entropy.
$Algo = '6'; // This is CRYPT_SHA512 as shown on http://php.net/crypt
$Rounds = '10000'; // The more, the more secure it is!

foreach($_POST['ID'] as $ID){

    $Username = $_POST["username-". $ID ."_"];
    $Password = $_POST["password-". $ID ."_"];
    $Permission_level = $_POST["permission_level-". $ID ."_"];

    $sql = "SELECT `Username` FROM `Verified_Users` WHERE `Username` = \"$Username\"";

    if ($mysqli -> query($sql) === FALSE) {
      echo "SQL error: " . $mysqli -> error;
      // header("Location: home.php");
    } else {
        $result = $mysqli->query($sql);
        while($row = $result->fetch_assoc()) {
            if($row['Username'] == $Username){
                // Non-unique username
                header("Location: home.php");
            }
        }
    }
    // Unique username, ok to insert
    $CryptSalt = '$' . $Algo . '$rounds=' . $Rounds . '$' . $Salt;

    $hashed_password = crypt($Password, $CryptSalt);
    $sql = "UPDATE `Verified_Users` SET `Salt` = \"$CryptSalt\", `Username` = \"$Username\", `Password` = \"$hashed_password\", `Permission_level` = \"$Permission_level\" WHERE `ID` = \"$ID\"";

    if ($mysqli -> query($sql) === FALSE) {
      echo "SQL error: " . $mysqli -> error;
    }
}
header("Location: home.php");

?>
