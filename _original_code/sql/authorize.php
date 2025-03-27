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

require_once('./config.php');

if ($_POST) { // Check to see if the form has been posted to
  // Set and sanitze the posted variables
  $user = preg_replace("/[^a-zA-Z0-9.]/", "", $_POST['username']);
  $pass = $_POST['password'];

  if ($_POST['terms'] == 'yes') {
    // See if the user exists in SQL
    if (authorizeSQL($user, $pass)) {
      sendAuthorization($_SESSION['id'], '480', $unifi);
      echo "<script type='text/javascript'>$(location).attr('href','".$_SESSION['url']."');</script>";
      echo ("Successfuly Connected");
    } else {
      echo "Couldn't authorize user please try again or use the contact form for additional assistance.";
    }
  } else {
    echo "You must accept the terms of service";
  }
}
?>
