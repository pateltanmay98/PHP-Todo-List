<?php
    include('Database.php');
    $getDatabase = new Database();

    $json = array();
    $id = 0;

    if(isset($_POST['id']))
    {
        $id = mysqli_escape_string($getDatabase->getDBConnection(),$_POST['id']);
    }

    $record = mysqli_query($getDatabase->getDBConnection(),"SELECT * FROM todos WHERE id=".$id);

    if(mysqli_num_rows($record)>0)
	{
        $task = mysqli_escape_string($getDatabase->getDBConnection(),trim($_POST['task']));
	    $priority = mysqli_escape_string($getDatabase->getDBConnection(),trim($_POST['priority']));

        if($task != '' && $priority != '')
        {
            mysqli_query($getDatabase->getDBConnection(), "UPDATE todos SET task='".$task."', priority='".$priority."' WHERE id=".$id);

            $json['status']=1;
			$json['data']="Record updated";
			echo json_encode($json);
        }
        else
        {
            $json['status']=0;
			$json['data']="Please fill all fields";
			echo json_encode($json);
        }
    }
    else
    {
        $json['status']=0;
		$json['data']="Invalid id";
		echo json_encode($json);
    }
?>