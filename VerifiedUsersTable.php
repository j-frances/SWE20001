<table class="table">
        <thead>
			<tr>
				<th>ID</th>
				<th>Userame</th>
				<th>Date Created</th>
			</tr>
		</thead>
    <?php
      $link = include('connect.php');
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
                    <td>" . $row["Date_Created"] . "</td>
                    </tr>";
               }
        }
    ?>
      </tbody>
    </table>