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
    <footer>
    <a>&#169 GoToGro Inc. 2022</a>
    <a href="mailto:103426340@student.swin.edu.au,101231241@student.swin.edu.au,103141481@student.swin.edu.au,103068001@student.swin.edu.au,103492189@student.swin.edu.au,103175309@student.swin.edu.au"> | Contact</a>
    </footer>
    </body>
</html>