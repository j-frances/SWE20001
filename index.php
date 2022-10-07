<?php

$configs = include('config.php');
$SALT = $configs['SALT'];

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
      <form id="login-form" action="javascript:encryptPOST()">
        <input type="text" id="username" name="username" placeholder="Username" required="required" />
          <input type="password" id="password" name="password" placeholder="Password" required="required" />
          <button type="submit" class="btn btn-primary btn-block btn-large">Login</button>
      </form>
      <a id="login-forgot-password" href="mailto:administrator@gotogro.com.au?subject=Request%20for%20password%20reset&body=Good%20day%2C%0D%0A%0D%0AThis%20is%20an%20auto-generated%20request%20for%20a%20password%20reset%20for%20the%20following%20user%3A%0D%0A%0D%0A%2F%2FPlease%20fill%20in%20the%20details%20of%20your%20GoToGro%20account%0D%0AUsername%3A%0D%0A%0D%0AThank%20you%2C%0D%0A%2F%2FYour%20name%20here">Forgot password?</a>
      <hr>
      <a id="login-no-account-1">Don't have an account?<a id="login-no-account-2" href="mailto:administrator@gotogro.com.au"><br> Contact your administrator</a></a>

  </div>
  <footer>
    <a>&#169 GoToGro Inc. 2022</a>
    <a href="mailto:103426340@student.swin.edu.au,101231241@student.swin.edu.au,103141481@student.swin.edu.au,103068001@student.swin.edu.au,103492189@student.swin.edu.au,103175309@student.swin.edu.au"> | Contact</a>
  </footer>
</body>
<script lang="js">
    function encryptPOST(){

        username = document.getElementById("username");
        password = document.getElementById("password");
        
        const cipherUser = btoa(escapeHtml(username.value) + "<?php echo $SALT; ?>");
        const cipherPass = btoa(escapeHtml(password.value) + "<?php echo $SALT; ?>");


        username.value = cipherUser;
        password.value = cipherPass;
        
        form = document.getElementById("login-form");
        form.action = "https://gotogro.000webhostapp.com/login.php";
        form.setAttribute("method", "POST")
        form.submit();
    }
    
    function escapeHtml(text) {
      var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
      };
      
      return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

</script>
</html>
