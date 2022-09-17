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
    echo "<a>   Logged in as, " . $_SESSION['username'] . "</a>" ;
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
                <a href=\"Newmember.php\">| Add New Member</a>
                <a href=\"new_sale.php\">| Add Sales Record</a>
                <a href=\"Product.php\">| Add New Product</a>";
            }
        }
    }
    ?>
    <a id="logout" href="logout.php">| Log Out</a>
  </header>
  <div class="dashboard" style="margin-top: 70px;">
  <details>
    <summary>
      <h3 class="table-header">Members</h3>
    </summary>
    <table class="table">
      <thead>
        <tr>
            <th></th>
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
                      <td><input type=\"checkbox\" onclick=\"edit_members_btn_trigger(this)\" id=" . $row["ID"] . "</td>
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
      <input type="submit" id="edit_members_btn" value="Edit Member(s)">
  </details>
  </div>
  <div class="dashboard">
    <details>
      <summary>
        <h3 class="table-header">Products</h3>
      </summary>
      <table class="table">
        <thead>
			<tr>
			    <th></th>
				<th>ID</th>
				<th>Product Name</th>
				<th>Quantity</th>
				<th>Price ($)</th>
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
                    <td><input type=\"checkbox\" onclick=\"edit_products_btn_trigger(this)\" id=" . $row["ID"] . "</td>
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
    <input type="submit" id="edit_products_btn" value="Edit Product(s)">
    </details>
    </div>
    <div class="dashboard">
      <details>
        <summary>
          <h3 class="table-header">Sales Records</h3>
        </summary>
        <table class="table">
          <thead>
            <tr>
              <th>Sale ID</th>
              <th>Member Name (ID)</th>
              <th>Quantity of Products</th>
              <th>Net Sale ($)</th>
              <th>Timestamp</th>
            </tr>
          </thead>
          <?php
            if($link === false) die("ERROR: Could not connect. " . mysqli_connect_error());
            $sql = "SELECT S.ID, CONCAT(M.Name, ' (', M.ID, ')') AS 'Member Name (ID)', GROUP_CONCAT(CONCAT(I.Quantity, ' of ', P.ProductName)) AS 'Qty of Products', SUM(P.Price * I.Quantity) AS 'Net Price', S.Datetime_Created AS 'Timestamp' FROM Sales S LEFT JOIN Members M ON M.ID = S.Member_ID INNER JOIN Sale_Items I ON I.Sale_ID = S.ID INNER JOIN Products P ON P.ID = I.Product_ID GROUP BY S.ID";
            $result = $link->query($sql);
            while ($row = $result->fetch_assoc()) {
              echo  "<tr>" .
                      "<td>" . $row["ID"] . "</td>" .
                      "<td>" . $row["Member Name (ID)"] . "</td>" .
                      "<td>" . $row["Qty of Products"] . "</td>" .
                      "<td>" . $row["Net Price"] . "</td>" .
                      "<td>" . $row["Timestamp"] . "</td>" .
                    "</tr>";
            }
          ?>
        </table>
      </details>
    </div>
    <div class="dashboard">
    <details>
      <summary>
        <h3 class="table-header">Verified Users</h3>
      </summary>
    <form action="edit-verified-users.php" class="edit-user-form" method="post">
    <table class="table">
        <thead>
			<tr>
			  <th></th>
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
                    <td><input type=\"checkbox\" name=\"Check[]\" onclick=\"edit_verified_btn_trigger(this)\" value=" . $row["ID"] . "></td>
                    <td><input type=\"hidden\" name=\"ID[]\" value=". $row["ID"] . ">" . $row["ID"] . "</td>
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
    <input type="submit" id="edit_verified_btn" value="Edit User(s)">
    </form>
    </details>
    </div>
  <footer>
    <a>&#169 GoToGro Inc. 2022</a>
    <a href="mailto:103426340@student.swin.edu.au,101231241@student.swin.edu.au,103141481@student.swin.edu.au,103068001@student.swin.edu.au,103492189@student.swin.edu.au,103175309@student.swin.edu.au"> | Contact</a>
  </footer>
</body>
<script>
    members_counter = 0;
    products_counter = 0;
    users_counter = 0;
    
    var edit_members_btn = document.getElementById("edit_members_btn");
    var edit_products_btn = document.getElementById("edit_products_btn");
    var edit_verified_btn = document.getElementById("edit_verified_btn");
    
    function edit_members_btn_trigger(val){
          if(val.checked){
              members_counter++;
          }else{
              members_counter--;
          }
          
          if(members_counter > 0){
              edit_members_btn.style.visibility = "visible";
              edit_members_btn.style.display = "block";
          }else{
              edit_members_btn.style.visibility = "hidden";
              edit_members_btn.style.display = "none";

          }
      }
      
      function edit_products_btn_trigger(val){
          if(val.checked){
              products_counter++;
          }else{
              products_counter--;
          }
          
          if(products_counter > 0){
              edit_products_btn.style.visibility = "visible";
              edit_products_btn.style.display = "block";
          }else{
              edit_products_btn.style.visibility = "hidden";
              edit_products_btn.style.display = "none";
          }
      }
      
      function edit_verified_btn_trigger(val){
          if(val.checked){
              users_counter++;
          }else{
              users_counter--;
          }
          
          if(users_counter > 0){
              edit_verified_btn.style.visibility = "visible";
              edit_verified_btn.style.display = "block";

          }else{
              edit_verified_btn.style.visibility = "hidden";
              edit_verified_btn.style.display = "none";
          }
      }
  </script>
</html>
