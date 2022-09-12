<?php
// Initialize the session
session_start();

// Check if the user is logged in, if so then redirect them to the home page
if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == "true"){
    header("location: Product.php");
    exit;
}
?>
<html>
<head>
    <link href="stylesheet.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lobster+Two&display=swap">
    <title>GoToGro Management Portal: Product</title>
</head>
<body class="index">
  <header>
    <a id="logo" href="https://GoToGro.com">GoToGro<sup>TM</sup></a>
  </header>
  <div class="login">
    <h1 id="login-header">Add New Product</h1>
    <form id="add-product-form" action="AddProduct.php" method="post">
        <input type="text" name="ProductName" placeholder="Product Name" required="required" />
        <input type="number" name="Price" placeholder="Price" required="required" />
        <input type="number" name="Quantity" placeholder="Quantity" required="required" />
        <button type="submit" class="btn btn-primary btn-block btn-large">Add Product</button>
    </form>
     
  </div>
  <footer>
    <a>&#169 GoToGro Inc. 2022</a>
    <a href="mailto:103426340@student.swin.edu.au,101231241@student.swin.edu.au,103141481@student.swin.edu.au,103068001@student.swin.edu.au,103492189@student.swin.edu.au,103175309@student.swin.edu.au"> | Contact</a>
  </footer>
</body>
</html>