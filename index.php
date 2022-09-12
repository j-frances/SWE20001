<?php
// Initialize the session
session_start();

// Check if the user is logged in, if so then redirect them to the home page
if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == "true"){
    header("location: home.php");
    exit;
}
?>
<html>
<head>
    <link href="stylesheet.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lobster+Two&display=swap">
    <title>GoToGro Management Portal</title>
</head>
<body class="index">
  <header>
    <a id="logo" href="https://GoToGro.com">GoToGro<sup>TM</sup></a>
  </header>
  <h1>Management Portal</h1>
  <div class="login">
      <form action="login.php" method="post">
        <input type="text" name="username" placeholder="Username" required="required" />
          <input type="password" name="password" placeholder="Password" required="required" />
          <button type="submit" class="btn btn-primary btn-block btn-large">Login</button>
      </form>
  </div>
  <footer>
    <a>&#169 GoToGro Inc. 2022</a>
    <a href="mailto:103426340@student.swin.edu.au,101231241@student.swin.edu.au,103141481@student.swin.edu.au,103068001@student.swin.edu.au,103492189@student.swin.edu.au,103175309@student.swin.edu.au"> | Contact</a>
  </footer>
</body>
</html>
