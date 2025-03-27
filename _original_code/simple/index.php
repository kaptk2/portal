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

// Start a session to capure the id and url of the incomming connection
session_start();

// Setup the session variables and display errors if not set
if ($_GET['id']) {
  $_SESSION['id'] = $_GET['id'];
} else {
  echo "Direct Access is not allowed";
  exit();
}

if ($_GET['url']) {
  $_SESSION['url'] = $_GET['url'];
} else {
  $_SESSION['url'] = 'http://www.google.com';
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
      <form method=POST action="authorize.php">
        By clicking submit you agree to the terms of service.
        <br />
        <input name="submit" type="submit" value="Submit">
      </form>
    </div>
  </body>
</html>
