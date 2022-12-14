<html>
<head>
    <link href="stylesheet.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lobster+Two&display=swap">
    <title>GoToGro Management Portal</title>
</head>
<body class="index">
  <header>
    <a id="logo" href="https://GoToGro.com">GoToGro<sup>TM</sup></a>
  </header>

  <div class="add-user">
    <h1 id="add-user-header">Add new user</h1>
      <form id="add-user-form" action="add-user.php" method="post">
        <input type="text" name="username" placeholder="Username" required="required" />
        <input type="password" name="password" placeholder="Password" required="required" />
        <label for="permission_level">Choose a permission level:</label>
        <select name="permission_level" id="permission_level">
         <option value="0">Staff</option>
         <option value="1">Admin</option>
        </select>
        <button type="submit" class="btn btn-primary btn-block btn-large">Add user</button>
      </form>
  </div>
  <footer>
    <a>&#169 GoToGro Inc. 2022</a>
    <a href="mailto:103426340@student.swin.edu.au,101231241@student.swin.edu.au,103141481@student.swin.edu.au,103068001@student.swin.edu.au,103492189@student.swin.edu.au,103175309@student.swin.edu.au"> | Contact</a>
  </footer>
</body>
</html>
