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
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible&display=swap" rel="stylesheet">
    <title>GoToGro Management Portal</title>
</head>
<body class="index">
  <header>
    <a id="logo" href="https://GoToGro.com">GoToGro<sup>TM</sup></a>
  </header>
  <div class="login">
    <h1 id="login-header">Log-in</h1>
    <a id="login-prompt-1">Welcome back!</a>
    <a id="login-prompt-2"><br>Please login to your account to continue</a>
      <form id="login-form" action="login.php" method="post">
        <input type="text" name="username" placeholder="Username" required="required" />
          <input type="password" name="password" placeholder="Password" required="required" />
          <button type="submit" class="btn btn-primary btn-block btn-large">Login</button>
      </form>
      <a id="login-forgot-password" href="https://google.com">Forgot password?</a>
      <hr>
      <a id="login-no-account-1">Don't have an account?<a id="login-no-account-2" href="mailto:administrator@gotogro.com"><br> Contact your administrator</a></a>

  </div>
  <footer>
    <a>&#169 GoToGro Inc. 2022</a>
    <a href="mailto:103426340@student.swin.edu.au,101231241@student.swin.edu.au,103141481@student.swin.edu.au,103068001@student.swin.edu.au,103492189@student.swin.edu.au,103175309@student.swin.edu.au"> | Contact</a>
  </footer>
</body>
</html>
