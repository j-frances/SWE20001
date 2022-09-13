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
    <a id="logo" href="index.php">GoToGro<sup>TM</sup></a>
    <?php 
    echo "<a>Logged in as, " . $_SESSION['username'] . "</a>" ;
    $link = include('connect.php');
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }else{
        $username = $_SESSION['username'];
        $sql = "SELECT `Permission_level` FROM `Verified_Users` WHERE `Username` = \"$username\"";
        
        $result = $link->query($sql);
        while($row = $result->fetch_assoc()){
            if($row['Permission_level'] != 1){
                continue;
            }else{
                echo "<a href=\"new_user.php\">| Add New User</a>
                <a href=\"new_user.php\">| Add New Member</a>
                <a href=\"new_sale.php\">| Add Sales Record</a>
                <a href=\"Product.php\">| Add New Product</a>";
            }
        }
    }
    ?>
    <a id="logout" href="logout.php">| Log Out</a>
  </header>
  <div class="dashboard">
  <table class="table">
    <h3 class="table-header">Members:</h3>
        <thead>
			<tr>
				<th>ID</th>
				<th>Full Name</th>
				<th>Email</th>
				<th>Date Created</th>
				<th>Expiration Date</th>
				<th>Status</th>
			</tr>
		</thead>
    <?php
      if($link === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
      }
      else{
         // read all row from database table
			$sql = "SELECT * FROM Members";
			$result = $link->query($sql);
            // read data of each row
			while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["ID"] . "</td>
                    <td>" . $row["Name"] . "</td>
                    <td>" . $row["Email"] . "</td>
                    <td>" . $row["Date_Created"] . "</td>
                    <td>" . $row["Expiration_Date"] . "</td>";
                    if($row["Status"] == 0){
                        echo "<td>Inactive</td>";
                    }else{
                        echo "<td>Active</td>";
                    }
                    echo "</tr>";
            }
      }
      ?>
      </tbody>
    </table>
    <hr>
    </div>
    <div class="dashboard">
    <table class="table">
        <h3 class="table-header">Products:</h3>
        <a class= "table-header" href="Product.php">Edit Product</a>
        <thead>
			<tr>
				<th>ID</th>
				<th>Product Name</th>
				<th>Quantity</th>
				<th>Price</th>
			</tr>
		</thead>
    <?php
      if($link === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
      }
      else{
         // read all row from database table
			$sql = "SELECT * FROM Products";
			$result = $link->query($sql);

            // read data of each row
			while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["ID"] . "</td>
                    <td>" . $row["ProductName"] . "</td>
                    <td>" . $row["Quantity"] . "</td>
                    <td>" . $row["Price"] . "</td>
                    </tr>";
                 }
            }
      ?>
      </tbody>
    </table>
    <hr>
    </div>
    <div class="dashboard">
    <table class="table">
        <h3 class="table-header">Verified users:</h3>
        <thead>
			<tr>
				<th>ID</th>
				<th>Userame</th>
				<th>Date Created</th>
				<th>Permission Level</th>
			</tr>
		</thead>
    <?php
      if($link === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
      }
      else{
         // read all row from database table
			$sql = "SELECT * FROM Verified_Users";
			$result = $link->query($sql);

            // read data of each row
			while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["ID"] . "</td>
                    <td>" . $row["Username"] . "</td>
                    <td>" . $row["Date_Created"] . "</td>";
                    if($row["Permission_level"] == 0){
                        echo "<td>Staff</td>";
                    }else{
                        echo "<td>Admin</td>";
                    }
                    echo "</tr>";
               }
        }
    ?>
      </tbody>
    
    </table>
    <hr>
    </div>
  <footer>
    <a>&#169 GoToGro Inc. 2022</a>
    <a href="mailto:103426340@student.swin.edu.au,101231241@student.swin.edu.au,103141481@student.swin.edu.au,103068001@student.swin.edu.au,103492189@student.swin.edu.au,103175309@student.swin.edu.au"> | Contact</a>
  </footer>
</body>
</html>
