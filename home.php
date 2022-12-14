<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != "true"){
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
<body class="homepage" onunload="test()">
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
                echo "<a href=\"new_user.php\"><button>Add New User</button></a>
                <a href=\"Newmember.php\"><button>Add New Member</button></a>
                <a href=\"new_sale.php\"><button>Add Sales Record</button></a>
                <a href=\"Product.php\"><button>Add New Product</button></a>
                <label><input type=checkbox onclick=\"del_edit_toggle_btn_trigger(this)\" id=\"del_edit_toggle\"><a>Delete</a></label>";
            }
        }
    }
    ?>
    <a id="logout" href="logout.php"><button>Log Out</button></a>
    <img id="inventory_bell" src="img/bell_noAlert.png" onclick="inDemandAlert()">
  </header>
  <div class="dashboard" style="margin-top: 70px;">
  <details>
    <summary>
      <h3 class="table-header">Members</h3>
    </summary>
    <form action="EditMembers.php" class="edit_members_form" id="edit_members_form" method="post">
    <table class="table">
      <thead>
        <tr>
            <th></th>
          <th>ID</th>
          <th>Full Name</th>
          <th>Address</th>
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
                      <td>" . $row["Address"] . "</td>
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
      <label id="del_members_lbl">Cannot Delete Members(s). Contact <a href="mailto:administrator@gotogro.com.au">Administrator</a></label>
    </form>
  </details>
  </div>
  <div class="dashboard">
    <details>
      <summary>
        <h3 class="table-header">Products</h3>
      </summary>
     <script>var stockWarning = [];</script>;
      <form action="EditExistingProduct.php" class="edit-products-form" id="edit_products_form" method="post">
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
            //<td>" . $row["ID"] . "</td>
			while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td><input type=\"checkbox\" name=\"Check[]\" onclick=\"edit_products_btn_trigger(this)\" id=" . $row["ID"] . "</td>
                    <td><input type=\"hidden\" name=\"ID[]\" value=". $row["ID"] . ">" . $row["ID"] . "</td>
                    
                    <td>" . $row["ProductName"] . "</td>
                    <td>" . $row["Quantity"] . "</td>
                    <td>" . $row["Price"] . "</td>
                    </tr>";
                    $p = $row["ProductName"];
                    $alert_const = 10;
                    if($row["Quantity"] < $alert_const){
                        echo "<script type='text/javascript'>
                        var item = \" " . $p ." : " . $row['Quantity'] ." \";
                        stockWarning.push(item);
                        document.getElementById(\"inventory_bell\").src = \"img/bell_Alert.png\";
                        </script>";
                    }
                 }
                 
            }
            
      ?>
      </tbody>
    </table>
    <input type="submit" id="edit_products_btn" value="Edit Product(s)">
    <label id="del_products_lbl">Cannot Delete Product(s). Contact <a href="mailto:administrator@gotogro.com.au">Administrator</a></label>    </form>
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
    <form action="edit-verified-users.php" class="edit-user-form" id="edit_user_form" method="post">
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
    <input type="submit" id="del_verified_btn" onclick="return confirm('Are you sure?')" value="Delete User(s)">
    </form>
    </details>
    </div>
    <style>
    .button {
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 80px 60px;
      cursor: pointer;
    }

    .button1 {background-color: #4CAF50;} /* Green */
    .button2 {background-color: #008CBA;} /* Green */
    
    </style>    
  <div class="form-group">
    <button onclick="Exportg()" class="button button1">Export Daily Data to CSV File</button>
    <button onclick="Exportm()" class="button button2">Export Monthly Data to CSV File</button> 

  </div>
  <script>
        function Exportg()
        {
            
            var conf = confirm("Export General Daily Data to CSV?");
            if(conf == true)
            {
                window.open("export_daily.php", '_blank');
            }
        }
        function Exportm()
        {
            
            var conf = confirm("Export Monthly Members/Sales Data to CSV?");
            if(conf == true)
            {
                window.open("export_monthly.php", '_blank');
            }
        }
  </script>
    

    
  <footer>
    <a>&#169 GoToGro Inc. 2022</a>
    <a href="mailto:103426340@student.swin.edu.au,101231241@student.swin.edu.au,103141481@student.swin.edu.au,103068001@student.swin.edu.au,103492189@student.swin.edu.au,103175309@student.swin.edu.au"> | Contact</a>
  </footer>
</body>
<script>
    members_counter = 0;
    products_counter = 0;
    users_counter = 0;
    
    del_edit_toggle_counter = 0;
    
    window.addEventListener("pageshow", () => {
        let checkboxes = document.querySelectorAll("input");
        checkboxes.forEach(input => {
            if (input.type == "checkbox")
                input.checked = false;
        });
    });
    
    var del_edit_toggle_btn = document.getElementById("del_edit_toggle");
    
    var edit_members_btn = document.getElementById("edit_members_btn");
    var edit_products_btn = document.getElementById("edit_products_btn");
    var edit_verified_btn = document.getElementById("edit_verified_btn");
   
    var del_members_lbl = document.getElementById("del_members_lbl");
    var del_products_lbl = document.getElementById("del_products_lbl");
    var del_verified_btn = document.getElementById("del_verified_btn");
    
    var edit_members_form = document.getElementById("edit_members_form");
    var edit_products_form = document.getElementById("edit_products_form");
    var edit_user_form = document.getElementById("edit_user_form");
    
    var form = document.getElementById("edit_user_form")
    del_verified_btn.addEventListener("click", function () {
        form.action = "delete_user.php";
    });
    
    function inDemandAlert(){
        var array = []
        array = stockWarning.join("\n") + "\n";
        if(stockWarning.length > 0){
            alert("Stock Warning! Quantity is low for these items:\n" + array);
        }
    }
    
    
    function del_edit_toggle_btn_trigger(val){
        if(val.checked){
            del_edit_toggle_counter++;
            
            edit_members_form.action = "DelMembers.php";
            edit_products_form.action = "DelProducts.php";
            edit_user_form.action = "DelUsers.php";
            
            clear_checkboxes();
            reset_forms();
            reset_counters();
        }else{
            del_edit_toggle_counter--;
            
            edit_members_form.action = "EditMembers.php";
            edit_products_form.action = "EditExistingProduct.php";
            edit_user_form.action = "edit-verified-users.php";
            
            clear_checkboxes();
            reset_forms();
            reset_counters();
        }
    }
    
    function clear_checkboxes(){
        let checkboxes = document.querySelectorAll("input");
        checkboxes.forEach(input => {
            if(input.id != "del_edit_toggle"){
                if (input.type == "checkbox"){
                    input.checked = false;
                }
            }
        });
    }
    
    function reset_forms(){
        edit_members_btn.style.visibility = "hidden";
        edit_members_btn.style.display = "none";

        del_members_lbl.style.visibility = "hidden";
        del_members_lbl.style.display = "none";
        
        edit_products_btn.style.visibility = "hidden";
        edit_products_btn.style.display = "none";

        del_products_lbl.style.visibility = "hidden";
        del_products_lbl.style.display = "none";

        edit_verified_btn.style.visibility = "hidden";
        edit_verified_btn.style.display = "none";

        del_verified_btn.style.visibility = "hidden";
        del_verified_btn.style.display = "none";
    }
    
    function reset_counters(){
        members_counter = 0;
        products_counter = 0;
        users_counter = 0;
    }
    
    function edit_members_btn_trigger(val){
          if(val.checked){
              members_counter++;
          }else{
              members_counter--;
          }
          
          if(members_counter > 0){
              if(del_edit_toggle_counter == 0){
                edit_members_btn.style.visibility = "visible";
                edit_members_btn.style.display = "block";   
              }else{
                del_members_lbl.style.visibility = "visible";
                del_members_lbl.style.display = "block";
              }
          }else{
              if(del_edit_toggle_counter == 0){
                edit_members_btn.style.visibility = "hidden";
                edit_members_btn.style.display = "none";
              }else{
                del_members_lbl.style.visibility = "hidden";
                del_members_lbl.style.display = "none";

              }
          }
      }
      
      function edit_products_btn_trigger(val){
          if(val.checked){
              products_counter++;
          }else{
              products_counter--;
          }
          
        if(products_counter > 0){
              if(del_edit_toggle_counter == 0){
                edit_products_btn.style.visibility = "visible";
                edit_products_btn.style.display = "block";   
              }else{
                del_products_lbl.style.visibility = "visible";
                del_products_lbl.style.display = "block";
              }
          }else{
              if(del_edit_toggle_counter == 0){
                edit_products_btn.style.visibility = "hidden";
                edit_products_btn.style.display = "none";
              }else{
                del_products_lbl.style.visibility = "hidden";
                del_products_lbl.style.display = "none";
    
              }
          }
      }
      
  
  

      
      function edit_verified_btn_trigger(val){
          if(val.checked){
              users_counter++;
          }else{
              users_counter--;
          }
          
            if(users_counter > 0){
              if(del_edit_toggle_counter == 0){
                edit_verified_btn.style.visibility = "visible";
                edit_verified_btn.style.display = "block";   
              }else{
                del_verified_btn.style.visibility = "visible";
                del_verified_btn.style.display = "block";
              }
          }else{
              if(del_edit_toggle_counter == 0){
                edit_verified_btn.style.visibility = "hidden";
                edit_verified_btn.style.display = "none";
              }else{
                del_verified_btn.style.visibility = "hidden";
                del_verified_btn.style.display = "none";

              }
          }
      }
  </script>
</html>
