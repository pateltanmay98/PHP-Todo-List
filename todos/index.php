<?php
    session_start();

    if($_SESSION['id'] == '')
    {
      header('Location: login.php');
    }
    else
    {

    include('crud/Database.php');

    $getDatabase = new Database();
    $email = $_SESSION['id'];
    $userName = $getDatabase->getUserName($email);

    include('header.php'); ?>

    <div class="content">
      <!-- Header Content -->
      <div class="card bg-dark text-white">
        <div class="card-body">
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

      <!-- Add New Todo -->
      <div class="ml-2 mr-2 mt-sm-4 border-bottom">
        <form class="row g-3 mt-4" action="#" method="POST">
          <div class="col-md-8">
            <input type="text" class="form-control" id="addNewTodo" placeholder="Add Task">
          </div>
          <div class="col-md-2">
            <select class="form-control" id="addNewPriority" aria-label="Default select example">
              <option selected value="High">High Priority</option>
              <option value="Low">Low Priority</option>
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
              <th>Update</th>
              <th>Delete</th>
            </tr>
          </thead>
        </table>
      </div>

      <?php include('footer.php'); ?>

    </div>

    <!-- Update Todo using Modal Plugin (Dialog box/popup window that is displayed on top of the current page) -->

    <div id="updateTodoModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Update Todo</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control" id="update_todo_text" placeholder="Insert Task" required>
            </div>
            <select class="form-control" id="update_priority_text" aria-label="Default select example">
              <option selected value="High">High Priority</option>
              <option value="Low">Low Priority</option>
            </select>
          </div>
          <div class="modal-footer">
            <input type="hidden" id="txt_todoid" value="0">
            <button type="button" class="btn btn-success btn-sm" id="update_todo">Save</button>
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>

      <script>
        $(document).ready(function () {
          var email = $('#sessionEmail').val().trim();
          // Insert Todo
          $('#submitNewTodo').click(function () {
            var newTodo = $('#addNewTodo').val().trim();
            var newTodoPriority = $('#addNewPriority').val().trim();

            if (newTodo != "" && newTodoPriority != "" && email != "") {
              // Ajax request
              $.ajax({
                url: 'crud/addTodo.php',
                type: 'POST',
                data: { newTodo: newTodo, newTodoPriority: newTodoPriority, email: email },
                dataType: 'json',
                success: function (response) {
                  if (response.status == 1) {
                    alert(response.data);
                    $('#addNewTodo').val(''); // Empty and reset the values
                    window.location.reload(true); // Reload Page
                  }
                  else {
                    alert(response.data);
                  }
                }
              }); // ajax bracket closing
            }
            else {
              alert('Please fill all fields.');
            }
          }); // End of #submitNewTodo click function

          // Display Data Table
          $('#todoDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
              'url': 'crud/showTodo.php',
              'data': function (data) {
                data.email = email;
              }
            },
            "serverMethod": "POST",
            "columns": [
              { data: 'task' },
              { data: 'priority' },
              { data: 'update' },
              { data: 'delete' }
            ],
          }); // End of #todoDataTable data table

          // Click on Update Button - Fetch data and Toggle update form
          $('#todoDataTable').on('click', '.updateTodo', function () {
            var id = $(this).data('id');
            $('#txt_todoid').val(id);

            // AJAX Request to Load Todo Data (This data is displayed on update form)
            $.ajax({
              url: 'crud/loadTodoData.php',
              type: 'post',
              data: {id:id},
              dataType: 'json',
              success: function(response)
              {
                if(response.status == 1)
                {
                    $('#update_todo_text').val(response.data.task);
                    $('#updateTodoModal').modal('toggle');
                }
                else
                {
                  alert("Data not found");
                }
				      }
            }); // End of AJAX call

            $('#updateModal').modal('toggle');
          }); // End of - Click on Update Button

          // Click on save button on toggled todo update form
          $('#update_todo').click(function(){
            var id = $('#txt_todoid').val();
            var task = $('#update_todo_text').val().trim();
            var priority = $('#update_priority_text').val().trim();

            if(task != '' && priority != '')
            {
              // AJAX request
              $.ajax({
                url:'crud/updateTodo.php',
                type: 'post',
                data: {id:id, task:task, priority:priority},
                dataType: 'json',
                success: function(response)
                {
                  if(response.status == 1)
                  {
                    alert(response.data);
                    // Empty and reset value
                    $('#update_todo_text').val('');
                    $('#txt_todoid').val(0);
                    $('#update_priority_text').val('High').change();
                    $('#todoDataTable').DataTable().ajax.reload(); // Reload data table after update record
                    $('#updateTodoModal').modal('toggle'); // Close update form modal
                  }
                  else
                  {
				            alert(response.data);
				          }
                }
              }); // End AJAX
            }
            else
            {
              alert("Please fill all fields");
            }
          }); // Ending process of Updating Todo Record

          // Delete Todo Record
          $('#todoDataTable').on('click', '.deleteTodo', function () {
            var id = $(this).data('id');
            var result = confirm( "Do you want to DELETE this task?" );

            if(result)
            {
              // AJAX request
              $.ajax({
                url: 'crud/deleteTodo.php',
                type: 'post',
                data: {id:id},
                dataType: 'json',
                success: function(response)
                {
                  if(response.status == 1)
                  {
                      alert(response.data);
                      $('#todoDataTable').DataTable().ajax.reload(); // Reload data table after update record
                  }
                  else
                  {
                    alert(response.data);
                  }
                }

              }); // AJAX End
            }
          });

        }); // End of Ready Function Bracket
      </script>
      <?php
        }
    ?>