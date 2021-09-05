<?php
    include('Database.php');
    include('../generalFunction.php');

    $getDatabase = new Database();

    $draw = $_POST['draw'];

	$row = $_POST['start']; //Paging first record indicator. This is the start point in the current data set (0 index based - i.e. 0 is the first record).
	$rowPerPage = $_POST['length']; // Rows display per page
	$order_column = array("id", "task", "priority", null, null);

    $searchValue = mysqli_real_escape_string($getDatabase->getDBConnection(),$_POST['search']['value']); //Search value

    // Searching
	$searchString = " ";
	if($searchValue != "")
	{
		$searchString = "and(id like '%".$searchValue."%' or task like '%".$searchValue."%' or priority like '%".$searchValue."%' )";
	}

    // iTotalRecords - Get total records count
    $totalRecords = $getDatabase->getToalNoOfRecords();

    // Filtered Records
    $totalFilterdRecords = $getDatabase->getFilteredNoOfRecords($searchString);

    // Fetch records for data table
    if($_POST['order']['0']['column']!=0)
    {
        $todoQuery = "SELECT * FROM todos WHERE 1 ".$searchString." ORDER BY ".$order_column[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir']." LIMIT ".$row.", ".$rowPerPage;
    }
    else
	{
		$todoQuery = "SELECT * FROM todos WHERE 1 ".$searchString." ORDER BY id desc LIMIT ".$row.", ".$rowPerPage;
	}

    $todoRecords = mysqli_query($getDatabase->getConnection(), $todoQuery);

    $data = array();
    while($row = mysqli_fetch_assoc($todoRecords))
    {
        $data[] = array(
            'id' => $row['id'],
            'todo' => $row['todo'],
            'priority' => $row['priority'],
            'update' => "<button class='btn btn-warning btn-xs updateTodo' data-id='".$row['id']."' >Update</button>",
            'delete' => "<button class='btn btn-danger btn-xs deleteTodo' data-id='".$row['id']."' >Delete</button>"
        );
    }

    $dataset = array(
        "draw" => intval($draw),
        "recordsTotal" => $totalRecords,
        "recordsFiltered" => $totalFilterdRecords,
        "aaData" => $data
    );

    echo json_encode($dataset);
?>