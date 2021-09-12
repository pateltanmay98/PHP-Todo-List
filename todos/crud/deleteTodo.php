<?php
    include('Database.php');
    $getDatabase = new Database();

    $json = array();
    $id = 0;

    if(isset($_POST['id']))
    {
        $id = mysqli_escape_string($getDatabase->getDBConnection(),$_POST['id']);
    }

    mysqli_query($getDatabase->getDBConnection(),"DELETE FROM todos WHERE id=".$id);
    $deleteAffect = mysqli_affected_rows($getDatabase->getDBConnection());

    if($deleteAffect == 1)
    {
        $json['status']=1;
		$json['data']='Data deleted succesfully.';
		echo json_encode($json);
    }
    else
    {
        $json['status']=0;
		$json['data']='Error occured for deletion';
		echo json_encode($json);
    }

?>