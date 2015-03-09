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
if (isset($_GET['id'])) {
  $_SESSION['id'] = $_GET['id'];
} else {
  die("Direct Access is not allowed");
}

if (isset($_GET['url'])) {
  $_SESSION['url'] = $_GET['url'];
} else {
  $_SESSION['url'] = 'http://www.google.com';
}

// Display the login form
?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Wireless Portal Page">
    <meta name="author" content="Andrew Niemantsverdriet">
    <link rel="icon" href="./img/favicon.ico">

    <title>Wireless Internet Portal</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="./css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Allow for the terms of service box to be scrollable -->
    <style>
      .scrollable{
        height:210px;
        overflow-y:scroll;
        width:100%;
      }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="./js/html5shiv.min.js"></script>
      <script src="./js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body role="document">
    <div class="container" role="main">
      <div class="page-header">
        <h1>Wireless Network</h1>
      </div>

      <div class="jumbotron">
        <h1>Login Required</h1>
        <p>
          Welcome to the wireless network. This network is for guest use. If you have questions regarding this network please contact support.</p>
          <div class="row">
            <form method="post" id="login" action="authorize.php" class="well col-md-4 form-horizontal">
              <div class="form-group">
                <label for="username">User Name</label>
                <input type="text" class="form-control" id="username" placeholder="firstname.lastname" name="username" />
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input name="password" id="password" class="form-control" type="password" />
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" id="terms" name="terms" value="yes"> I agree to the <a href="aup_text.html">terms of service</a>
                </label>
              </div>
              <button type="submit" class="btn btn-primary btn-medium pull-right">Login &raquo;</button>
            </form>
            <div class="col-md-8">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title">Terms Of Service</h3>
                </div>
                <div class="panel-body scrollable">
                  <!-- Read the terms and conditions from a file -->
                  <?php readfile("./aup.html"); ?>
                </div>
              </div>
            </div>
          </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title">Encryption</h3>
            </div>
            <div class="panel-body">
              Concerned about security? This network offers encrypted access using WPA2. The encrypted network is only available to authorized users and is not available to guests. Some configuration is needed to enable encryption on your device and not all devices are supported.
            </div>
          </div>
        </div><!-- /.col-sm-6 -->
        <div class="col-sm-6">
          <div class="panel panel-warning">
            <div class="panel-heading">
              <h3 class="panel-title">Need Help?</h3>
            </div>
            <div class="panel-body">
             Can't get your computer to connect? Having trouble getting to websites? We can help, you can call us for additional assistance.
            </div>
          </div>
        </div><!-- /.col-sm-6 -->
      </div>

      <hr>

      <footer>
        <p>&copy; Andrew Niemantsverdriet 2015</p>
      </footer>

      <!-- Loading modal -->
      <div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Status...</h4>
            </div>
            <div class="modal-body">
              <p class="text-center" id="status">Please wait while computer is being authorized. <img src='./img/ajax-loader.gif' /></p>
            </div>
          </div>
        </div>
      </div>

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./js/ie10-viewport-bug-workaround.js"></script>
    <!-- jQuery form validation -->
    <script src="./js/jquery.validate.min.js"></script>

    <!-- Page specific JavaScript -->
    <script type="text/javascript">
      // Login form processing
      $('#login').submit(function(e){
        e.preventDefault();
        var url = '<?php echo $_SESSION['url']; ?>';
        if (!$('#terms').is(':checked')) {
          alert("You must accept the terms of service");
          return false; // stop the form submission
        }
        $.ajax({
          type: 'POST',
          url: 'authorize.php',
          data: $('#login').serialize(),
          success: function(msg){
             $("#status").html(msg);
          }
        });
        // Show a loading modal
        $('#loading').modal('show');
      });

      $('#loading').on('hidden.bs.modal', function () {
        $("#status").html("Please wait your device is being authorized. <img src='./img/ajax-loader.gif'/>");
      });
    </script>
  </body>
</html>
