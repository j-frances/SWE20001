<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== "true"){
    header("location: index.php");
    exit;
}

?>
<html>
<head>
  <link href="stylesheet.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lobster+Two&display=swap">
  <title>🥬 GoToGro Management Portal</title>
</head>
<body class="homepage">
  <header>
    <a id="logo" href="https://GoToGro.com">GoToGro<sup>TM</sup></a>
    <?php echo "<a>Logged in as, " . $_SESSION['username'] . "</a>" ; ?>
    <a id="logout" href="logout.php">| Log Out</a>
  </header>
  <div class="dashboard">
    <?php
      $link = include('connect.php');
      if($link === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
      }
      else{
        //List database tables here
        echo "<h2>Tables go here</h2>";
      }
      ?>
  </div>
  <footer>
    <a>&#169 GoToGro Inc. 2022</a>
    <a href="mailto:103426340@student.swin.edu.au,101231241@student.swin.edu.au,103141481@student.swin.edu.au,103068001@student.swin.edu.au,103492189@student.swin.edu.au,103175309@student.swin.edu.au"> | Contact</a>
  </footer>
</body>
</html>
