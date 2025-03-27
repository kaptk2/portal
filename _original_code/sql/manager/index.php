<?php
/* Orignally written by Andrew Niemantsverdriet 
 * email: andrewniemants@gmail.com
 * website: http://www.rimrockhosting.com
 *
 * This code is on Github: https://github.com/kaptk2/portal
 *
 * Copyright (c) 2015, Andrew Niemantsverdriet <andrewniemants@gmail.com>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met: 
 *
 * 1. Redistributions of source code must retain the above copyright notice, this
 *    list of conditions and the following disclaimer. 
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution. 
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * The views and conclusions contained in the software and documentation are those
 * of the authors and should not be interpreted as representing official policies, 
 * either expressed or implied, of the FreeBSD Project.
*/
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
