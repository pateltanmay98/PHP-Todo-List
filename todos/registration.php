<?php
    include('crud/Database.php');
    include('generalFunction.php');

    $getDatabase = new Database();

    if(isset($_POST['submit']))
    {

        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];

        $encryptedPassword = getEncryptedText($password);

        $insertUser['name'] = $name;
        $insertUser['email'] = $email;
        $insertUser['encryptedPassword'] = $encryptedPassword;

        $insertEffect = $getDatabase->insertUserInfo($insertUser);

        echo "<script> alert('You are registered!') </script>";
        header('Location: index.php');

    }
?>

<html>

  <head>
    <?php include('header.php'); ?>
  </head>

  <body>

    <div class="container-fluid h-100">
      <div class="row justify-content-center align-items-center h-100">
        <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
          <form id='validation_form' action="#" method="POST">
          <div class="form-group">
              <input id="name" name="name" class="form-control form-control-lg" placeholder="User name" type="text">
            </div>
            <div class="form-group">
              <input id="email" name="email" class="form-control form-control-lg" placeholder="User email" type="text">
            </div>
            <div class="form-group">
              <input id="password" name="password" class="form-control form-control-lg" placeholder="Password"
                type="password">
            </div>
            <div class="form-group">
              <input id="confirmpassword" name="confirmpassword" class="form-control form-control-lg" placeholder="Confirm Password"
                type="password">
            </div>
            <div class="form-group">
              <button class="btn btn-info btn-lg btn-block" name="submit">Sign In</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script type="text/javascript">
      jQuery(document).ready(function ($){
        var validationForm = $('#validation_form');
        validationForm.validate({
          rules:{
            name: {
              required: true,
              minlength: 6
            },
            email: {
              required: true,
              minlength: 5
            },
            password: {
              required: true,
              minlength: 5
            },
            confirmpassword:{
                equalTo: "#password",
                required: true
            }
          },
          message: {
            name:{
              required: "Please enter email",
              minlength: "Your username must consist of at least 5 characters"
            },
            email:{
              required: "Please enter email",
              minlength: "Your username must consist of at least 4 characters"
            },
            password:{
              required: "Please enter email",
              minlength: "Your username must consist of at least 4 characters"
            },
            confirmpassword:{
                equalTo: "Enter Confirm Password Same as Password",
                required: "Please enter email"
            }
          }
        })
      });
    </script>

  </body>

</html>