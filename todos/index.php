<?php
  session_start();

  include('crud/Database.php');
  include('generalFunction.php');

  $getDatabase = new Database();

  if(isset($_POST['submit']))
  {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $getEncryptedPassword = $getDatabase->getUserPassword($email);
    $decryptedPassword = getDecryptedText($getEncryptedPassword);
    
    if($decryptedPassword == $password)
    {
      $_SESSION['id'] = $email;
      header('Location: todos.php');
    }
    else
    {
      echo "<script> alert('Invalid authentication information') </script>";
      header('Location: index.php');
    }
  }
?>


<html>

<head>
  <title>Todo Notes</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../Library/Bootstrap/css/bootstrap.min.css">
  <script type="text/javascript" src="../Library/jQuery.min.js"></script>
  <script type="text/javascript" src="../Library/jQUery-validation.js"></script>
  <script type="text/javascript" src="../Library/Bootstrap/js/bootstrap.min.js"></script>
</head>

  <body>

    <div class="container-fluid h-100">
      <div class="row justify-content-center align-items-center h-100">
        <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
          <form id='validation_form' action="#" method="POST">
            <div class="form-group">
              <input id="email" name="email" class="form-control form-control-lg" placeholder="User email" type="text">
            </div>
            <div class="form-group">
              <input id="password" name="password" class="form-control form-control-lg" placeholder="Password"
                type="password">
            </div>
            <div class="form-group">
              <button class="btn btn-info btn-lg btn-block" name="submit">Sign In</button>
            </div>
          </form>
          <a href="registration.php" class="link-primary">Don't have account?</a>
        </div>
      </div>
    </div>

    <script type="text/javascript">
      jQuery(document).ready(function ($){
        var validationForm = $('#validation_form');
        validationForm.validate({
          rules:{
            email: {
              required: true,
              minlength: 5
            },
            password: {
              required: true,
              minlength: 5
            }
          },
          message: {
            email:{
              required: "Please enter email",
              minlength: "Your username must consist of at least 4 characters"
            },
            password:{
              required: "Please enter email",
              minlength: "Your username must consist of at least 4 characters"
            }
          }
        })
      });
    </script>

  </body>

</html>