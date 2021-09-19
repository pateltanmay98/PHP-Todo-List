<?php
    session_start();

    $json = array();
    unset($_SESSION['id']);
    $json['status'] = 1;
    echo json_encode($json);
?>