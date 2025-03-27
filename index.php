<?php

session_start();

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

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>WiFi | Prisijungimas</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="img/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="css/font.css" rel="stylesheet">
</head>

<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <img src="img/logo.png" class="logo">
    <p class="text-xl">Mokyklos bevielis tinklas</p>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Norėdami pradėti naršyti, prisijunkite</p>

      <form action="authorize.php" method="post" id="LoginForm">
        <div class="form-group mb-3">
          <input type="email" name="email" id="email" class="form-control" placeholder="El.paštas">
        </div>
        <div class="form-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Slaptažodis">
        </div>
        <div class="row">
          <div class="col-8">
            <div class="form-group">
            <div class="icheck-primary">
              <input type="checkbox" name="terms" id="terms" value="yes">
              <label for="terms">Sutinku su <a href="tos.html" target="_blank">naudojimosi tinklu taisyklėmis</a>.</label>
            </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Jungtis</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>

<!-- Page specific script -->
<script>
$(function () {
  $.validator.setDefaults({
//    submitHandler: function () {
//      alert( "Form successful submitted!" );
//    }
  });
  $('#LoginForm').validate({
    rules: {
      email: {
        required: true,
        email: true
      },
      password: {
        required: true
      },
      terms: {
        required: true
      },
    },
    messages: {
      email: {
        required: "Prašome įrašyti el.pašto adresą",
        email: "Prašome įrašyti teisingą el.pašto adresą"
      },
      password: {
        required: "Prašome įrašyti slaptažodį"
      },
      terms: "Prašome priimti tinklo naudojimo taisykles"
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>


</body>
</html>
