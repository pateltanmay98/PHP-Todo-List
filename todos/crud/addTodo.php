<?php

    include('Database.php');
    include('../generalFunction.php');

    $getDatabase = new Database();

    if($_POST['newTodo'] && $_POST['newTodoPriority'] && $_POST['email'])
    {
        $insertTodo['newTodo'] = $_POST['newTodo'];
        $insertTodo['newTodoPriority'] = $_POST['newTodoPriority'];
        $insertTodo['email'] = $_POST['email'];

        $insertTodoResponse = $getDatabase->insertNewTodo($insertTodo);

        if($insertTodoResponse == 1)
        {
            $json['status'] = 1;
            $json['data'] = "Todo Inserted";
            echo json_encode($json);
        }
        else
        {
            $json['status'] = 0;
            $json['data'] = "Error!!";
            echo json_encode();
        }
        }
?>