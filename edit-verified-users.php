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
    <h1 class="edit-user-header">Edit user(s)</h1>
    <a class="edit-user-prompt-1">Set username and password</a>
    <a class="edit-user-prompt-2"><br>Note: only users with Admin permission can add new users</a>
      <form class="edit-user-form" action="edit-user.php" method="post" autocomplete="off">
        <?php
        $mysqli = include('connect.php');

        if ($mysqli -> connect_errno) {
          echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
          exit();
          header("Location: index.php");
        }

        foreach($_POST['Check'] as $Check){
            $sql = "SELECT `ID`, `Username`, `Permission_level` FROM `Verified_Users` WHERE `ID` = \"$Check\"";
            $result = $mysqli -> query($sql);
            while($row = $result->fetch_assoc()) {
              echo "<input type=\"hidden\"  name=\"ID[]\" value="  . $row["ID"] . ">
              <input type=\"input\" name=\"username-"  . $row["ID"] . " \" value=" . $row["Username"] . " required=\"required\">
              <input type=\"password\" name=\"password-"  . $row["ID"] . " \" placeholder=\"Password\" required=\"required\" autocomplete=\"new-password\">
              <br><label for=\"permission_level-"  . $row["ID"] . " \">Permission level:</label>";
              if($row["Permission_level"] == 0){
              echo "<select name=\"permission_level-"  . $row["ID"] . " \" class=\"permission_level\">
                <option value=\"0\" selected>Staff</option>
                <option value=\"1\">Admin</option>
                </select>";
              }else{
                echo "<select name=\"permission_level-"  . $row["ID"] . " \" class=\"permission_level\">
                <option value=\"0\">Staff</option>
                <option value=\"1\" selected>Admin</option>
                </select>";
              }
              echo "<hr>";
            }
        }
        ?>
        <button type="submit" class="edit-user-btn btn-primary btn-block btn-large">Edit user(s)</button>
      </form>
  </div>
  <footer>
    <a>&#169 GoToGro Inc. 2022</a>
    <a href="mailto:103426340@student.swin.edu.au,101231241@student.swin.edu.au,103141481@student.swin.edu.au,103068001@student.swin.edu.au,103492189@student.swin.edu.au,103175309@student.swin.edu.au"> | Contact</a>
  </footer>
</body>
</html>
