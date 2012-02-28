<?php
// Start a session to capure the id and url of the incomming connection
session_start();

// Setup the session variables and display errors if not set
if ($_GET['id'])
{
  $_SESSION['id'] = $_GET['id'];
}
else
{
  echo "Direct Access is not allowed";
  exit();
}

if ($_GET['url'])
{
  $_SESSION['url'] = $_GET['url'];
}
else
{
  $_SESSION['url'] = 'http://www.rocky.edu';
}

// Display the login form
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Free Wireless Internet</title>
  </head>
  <body>
    <div id="page" align="center">
      <div id="header">
        <div id="companyname" align="left">Welcome!</div>
      </div>
      <br />
      <form method=POST action="authorized.php">
        Username: <input name="username" type="text" />
        <br />
        Password: <input name="password" type="password" />
        <br />
        <input name="submit" type="submit" value="Submit">
      </form>
    </div>
  </body>
</html>
