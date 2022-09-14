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
    <h1 id="add-user-header">Add New Members</h1>
      <form id="add-user-form" action="Addmember.php" method="post">
        <input type="text" name="Name" placeholder="Full Name" required="required" />
        <input type="text" name="Email" placeholder="Email" required="required" />
        <input type="text" name="Date_Created" placeholder="Format yyyy-mm-dd hh:mm:ss" required="required" />
        <button type="submit" class="btn btn-primary btn-block btn-large">Add Member</button>
      </form>
  </div>
  <footer>
    <a>&#169 GoToGro Inc. 2022</a>
    <a href="mailto:103426340@student.swin.edu.au,101231241@student.swin.edu.au,103141481@student.swin.edu.au,103068001@student.swin.edu.au,103492189@student.swin.edu.au,103175309@student.swin.edu.au"> | Contact</a>
  </footer>
</body>
</html>