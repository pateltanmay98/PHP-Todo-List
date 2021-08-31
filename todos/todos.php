<?php
    session_start();

    include('crud/Database.php');
    include('generalFunction.php');

    $getDatabase = new Database();
    $email = $_SESSION['id'];
    $userName = $getDatabase->getUserName($email);

?>

<html>

  <head>
    <title>Todo Notes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../Library/Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Library/jquery.dataTables.min.css">
    <link rel="stylesheet" href="./styles.css">
    <script type="text/javascript" src="../Library/jQuery.min.js"></script>
    <script type="text/javascript" src="../Library/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../Library/jQUery-validation.js"></script>
    <script type="text/javascript" src="../Library/Bootstrap/js/bootstrap.min.js"></script>
  </head>

  <body>
    <!-- Header Content -->
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

    <!-- Add New Todo -->
      <div class="ml-2 mr-2 mt-sm-4 border-bottom">
        <form class="row g-3 mt-4" action="#" method="POST">
          <div class="col-md-8">
            <input type="text" class="form-control" id="addNewTodo" placeholder="Add Todo">
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

      <!-- Data Table to Display Data -->
      <div class="mt-4 ml-2 mr-2">
        <table id="todoDataTable" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th class="col-md-6">Task</th>
              <th>Priority</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>

      <script>
        $(document).ready(function()
        {
          // Submit new Todo
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
                url: 'crud/addTodo.php',
                type: 'POST',
                data: {newTodo:newTodo, newTodoPriority:newTodoPriority, email:email},
                dataType: 'json',
                success: function(response)
                {
                  if(response.status == 1)
                  {
                    alert(response.data);
                    $('#addNewTodo').val(''); // Empty and reset the values
                    window.location.reload(true); // Reload Page
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

          // Display Data Table
          $('#todoDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "serverMethod": "POST",
            "ajax": {
              'data': function(data)
              {
                data.request = 2;
              }
            },
            "columns": [
              {data: 'task'},
              {data: 'priority'},
              {data: 'action1'},
              {data: 'action1'}
            ],
          }); // End of #todoDataTable data table

        }); // End of Ready Function Bracket
      </script>

  </body>

</html>