<?php
    session_start();

    include('Database.php');
    include('generalFunction.php');

    $getDatabase = new Database();
    $email = $_SESSION['id'];
    $userName = $getDatabase->getUserName($email);
    $json = array();

    // Insert New Todo
    if(isset($_POST['request']) == 1)
    {
      $newTodo = $_POST['newTodo'];
      $newTodoPriority = $_POST['newTodoPriority'];
      $email = $_POST['email'];

      $getEncryptedTodo = getEncryptedText($newTodo);

      $insertTodo['newTodo'] = $getEncryptedTodo;
      $insertTodo['newTodoPriority'] = $newTodoPriority;
      $insertTodo['email'] = $email;

      $insertTodoResponse = $getDatabase->insertNewTodo($insertTodo);

      if($insertTodoResponse == 1)
      {
        $json['status'] = 1;
        $json['data'] = "Todo Inserted";
        echo json_encode($json);
        exit;
      }
      else
      {
        $json['status'] = 0;
        $json['data'] = "Error!!";
        echo json_encode();
        exit;
      }
    }

?>

<html>

  <head>
    <title>Todo Notes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../Library/Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles.css">
    <script type="text/javascript" src="../Library/jQuery.min.js"></script>
    <script type="text/javascript" src="../Library/jQUery-validation.js"></script>
    <script type="text/javascript" src="../Library/Bootstrap/js/bootstrap.min.js"></script>
  </head>

  <body>
    <div class="card bg-dark text-white">
      <div class="card-body">
        <div class="container">
          <div class="row">
            <div class="col">
              <h3 class="card-title">
                <?php echo $userName; ?>
              </h3>
            </div>
            <div class="col-auto">
              <button type="button" class="btn btn-primary">Logout</button>
            </div>
          </div>
        </div>
      </div>
    </div>
      <div class="ml-2 mr-2 mt-sm-4 border-bottom">
        <form class="row g-3 mt-4" action="#" method="POST">
          <div class="col-md-8">
            <input type="text" class="form-control" id="addNewTodo">
          </div>
          <div class="col-md-2">
            <select class="form-control" id="addNewPriority" aria-label="Default select example">
              <option selected value="high">High Priority</option>
              <option value="low">Low Priority</option>
            </select>
          </div>
          <div class="col-md-2">
            <button type="button" id="submitNewTodo" class="btn btn-primary btn-block">Add Todo</button>
          </div>
        </form>
      </div>
      <input type="hidden" id="sessionEmail" value="<?php echo $email ?>" />
  </body>

  <script type="text/javascript">
    $(document).ready(function()
		{

      $('#submitNewTodo').click(function()
      {
        var newTodo = $('#addNewTodo').val().trim();
        var newTodoPriority = $('#addNewPriority').val().trim();
        var email = $('#sessionEmail').val().trim();
        console.log(newTodo);
        console.log(newTodoPriority);
        console.log(email);

        if(newTodo != "" && newTodoPriority != "" && email != "" )
        {
          // Ajax request
          $.ajax({
            type: 'POST',
            data: {request:1, newTodo:newTodo, newTodoPriority:newTodoPriority, email:email},
            dataType: 'json',
            success: function(response)
            {
              if(response.status == 1)
              {
                alert(response.data);

                // Empty and reset the values
                $('#addNewTodo').val('');

                // Reload Page
                window.location.reload(true);
              }
              else
              {
                alert(response.data);
              }
            }
          }); // ajax bracket closing
        }
        else
        {
          alert('Please fill all fields.');
        }

      }); // End of #submitNewTodo click function

    }); // End of Ready Function Bracket
  </script>

</html>