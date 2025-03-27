<?php

require_once('../config.php'); 

if ($_GET) {
  // Remove the ID from the $_GET variable
  $id = preg_replace("/[^0-9.]/", "", $_GET["delete"]);

  if(removeUser($id)) {
    echo "Successfully removed user";
  } else {
    echo "Error removing user please see log";
  }
}

if ($_POST) 
{
  $days = filter_var($_POST["days"], FILTER_VALIDATE_INT);

  $guest = array();
  $guest['username']  = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
  $guest['password']  = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $guest['notes']     = filter_var($_POST['notes'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
  $guest['expires']   = time() + ($days * 24 * 60 * 60);

  if(adduser($guest)) {
    echo "Successfully added user";
  } else {
    echo "Error adding user please see log";
  }
}

try {
  // Select all the users from the database
  $sql =  'SELECT * FROM guests';
  $result = $db->query($sql);
  $db = NULL; // Close the connection
} catch(PDOException $e) {
  if($e->errorInfo[2] == "no such table: guests") {
    echo "<br />Creating table, please wait";
    $db->exec("CREATE TABLE guests (id INTEGER PRIMARY KEY AUTOINCREMENT, username UNIQUE, password NOT NULL, expires, notes)");
    $db = NULL; // Close the connection
  } else {
    die ('Exception: '.$e->getMessage());
  }
}
?>

<form method="POST" action="index.php">
  Username: <input type="text" name="username" /> <br />
  Password: <input type="text" name="password" /> <br />
  Expires (in days): <input type="number" name="days" /> <br />
  Notes:<br />
  <textarea name="notes"></textarea>
  <br />
  <input type="submit" name="addGuest" value="Add Guest">
</form>

<table border="1">
  <tr>
    <th>Username</th>
    <th>Expires</th>
    <th>Notes</th>
    <th>Delete?</th>
  </tr>
  <?php
  foreach($result as $row) {
    print '
    <tr>
      <td>'.$row['username'].'</td>
      <td>'.date("D F d Y",$row['expires']).'</td>
      <td>'.$row['notes'].'</td>
      <td><a href="'.$_SERVER['PHP_SELF'].'/?delete='.$row['id'].'">Delete?</a></td>
    </tr>';
  }
  ?>
</table>

<?php

//phpinfo();

?>
