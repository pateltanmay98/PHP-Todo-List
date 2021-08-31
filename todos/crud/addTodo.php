<?php

    include('Database.php');
    include('../generalFunction.php');

    $getDatabase = new Database();

    if($_POST['newTodo'] && $_POST['newTodoPriority'] && $_POST['email'])
    {
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