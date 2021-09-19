<?php
  session_start();

  include('crud/Database.php');
  include('generalFunction.php');

  if(isset($_SESSION['message']))
  {
    $message = $_SESSION['message'];
    echo '<script type="text/javascript">alert("'.$message.'")</script>';
    unset($_SESSION['message']);
  }

  $getDatabase = new Database();

  if(isset($_POST['submit']))
  {
    $email = $_POST['email'];

    $getEmail = $getDatabase->getEmail($email);

    if($email != $getEmail)
    {
      $_SESSION['message'] = "This email doesn't exist. Please register yourself.";
      header('Location: registration.php');
    }
    else
    {
      $password = $_POST['password'];
      $getEncryptedPassword = $getDatabase->getUserPassword($email);
      $decryptedPassword = getDecryptedText($getEncryptedPassword);
      
      if($decryptedPassword == $password)
      {
        $_SESSION['id'] = $email;
        header('Location: index.php');
      }
      else
      {
        echo "<script> alert('Invalid authentication information') </script>";
        header('Location: index.php');
      }
    }
  }
    include('header.php'); ?>

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
  