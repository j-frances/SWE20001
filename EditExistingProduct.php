<html>
<head>
    <link href="stylesheet.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lobster+Two&display=swap">
    <title>GoToGro Management Portal</title>
</head>
<body class="index">
  <header>
    <a id="logo" href="index.php">GoToGro<sup>TM</sup></a>
  </header>

  <div class="edit-user">
    <h1 class="edit-user-header">Edit products(s)</h1>
      <form class="edit-user-form" action="EditProduct.php" method="post" autocomplete="off">
        <?php
        $mysqli = include('connect.php');

        if ($mysqli -> connect_errno) {
          echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
          exit();
          header("Location: index.php");
        }
        
       
        
        
        
        foreach($_POST['Check'] as $Check){
            $sql = "SELECT `ID`, `ProductName`, `Quantity`, `Price` FROM `Products` WHERE `ID` = \"$Check\"";
            $result = $mysqli -> query($sql);
            while($row = $result->fetch_assoc()) {
              echo "<input type=\"hidden\"  name=\"ID[]\" value="  . $row["ID"] . ">
              <input type=\"input\" name=\"ProductName"  . $row["ID"] . " \" value=" . $row["ProductName"] . " required=\"required\">
              <input type=\"number\" name=\"Quantity"  . $row["ID"] . " \" placeholder=\"Quantity\" required=\"required\>
              <input type=\"number\" name=\"Price"  . $row["ID"] . " \" placeholder=\"Price\" required=\"required\">";
                
            }
        }
        ?>
        <button type="submit" class="edit-user-btn btn-primary btn-block btn-large">Edit product(s)</button>
      </form>
  </div>
  <footer>
    <a>&#169 GoToGro Inc. 2022</a>
    <a href="mailto:103426340@student.swin.edu.au,101231241@student.swin.edu.au,103141481@student.swin.edu.au,103068001@student.swin.edu.au,103492189@student.swin.edu.au,103175309@student.swin.edu.au"> | Contact</a>
  </footer>
</body>
</html>
