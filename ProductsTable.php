<table class="table">
        <thead>
			<tr>
				<th>ID</th>
				<th>Product Name</th>
				<th>Quantity</th>
				<th>Price</th>
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
                    <td>" . $row["Quantity"] . "</td>
                    <td>" . $row["Price"] . "</td>
                    </tr>";
                 }
      ?>
      </tbody>
    </table>