
<html>
<head>
    <link href="stylesheet.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lobster+Two&display=swap">
    <title>GoToGro Management Portal: Product</title>
</head>
<body class="homepage">
  <header>
    <a id="logo" href="https://gotogro.000webhostapp.com">GoToGro<sup>TM</sup></a>
  </header>
  <div class="dashboard">
    <table class="table">
        <h3 class="table-header">Products:</h3>
        <thead>
			<tr>
				<th>ID</th>
				<th>Product Name</th>
				<!--<th>Quantity</th>
				<th>Price</th>-->
			</tr>
		</thead>
    <?php
      $link = include('connect.php');
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
                    
                    </tr>";
                 }
            }
      ?>
      </tbody>
    </table>
    <hr>
    </div>
    <br><br><br><br><br>

    <div class="add-user">
    <h1 id="add-user-header">Add New Product</h1>
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
