<?php

    include('Database.php');
    $getDatabase = new Database();

    $json = array();
    $id = 0;

    if(isset($_POST['id']))
    {
        $id = mysqli_escape_string($getDatabase->getDBConnection(),$_POST['id']);
        $record = mysqli_query($getDatabase->getDBConnection(),"SELECT * FROM todos WHERE id=".$id);
        $response = array();
        if(mysqli_num_rows($record) > 0)
        {
            $row = mysqli_fetch_assoc($record);
			$response = array(
                "task" => $row['task']
            );
            $json['status'] = 1;
            $json['data']=$response;
			echo json_encode($json);
        }
        else
        {
            $json['status']=0;
			echo json_encode($json);
        }
    }
    else
    {
        $json['status']=0;
		echo json_encode($json);
    }
?>