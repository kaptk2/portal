<?php

require_once('./config.php');

// Check to see if the form has been posted to
if ($_POST) {

  // Set and sanitze the posted variables
  $user = preg_replace("/[^a-zA-Z0-9.@\-]/", "", $_POST['email']);
  $pass = $_POST['password'];

  if ($_POST['terms'] == 'yes') {
    // See if the user exists in SQL
    if (authorizeSQL($user, $pass)) {
      sendAuthorization($_SESSION['id'], '480', $unifi);
      echo "<script type='text/javascript'>$(location).attr('href','".$_SESSION['url']."');</script>";
      echo ("Sėkmingai prisijungta");
    } elseif (authorizeLDAP($user, $pass)) {
      sendAuthorization($_SESSION['id'], '480', $unifi);
      echo "<script type='text/javascript'>$(location).attr('href','".$_SESSION['url']."');</script>";
      echo ("Sėkmingai prisijungta");
    } else {
      echo "Prisijungimo klaida";
    }
  } else {
    echo "Turite priimti tinklo naudojimo taisykles";
  }
}
?>
