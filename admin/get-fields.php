<?php
    session_start();
    include_once "config-ter.php";
    include 'init.php';
    $companyid = $_GET['companyid'];
    $sql = "SELECT id,name FROM fields WHERE company_id= $companyid ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_all($query,MYSQLI_ASSOC);

    if(mysqli_num_rows($query) == 0){



    }elseif(mysqli_num_rows($query) > 0){

        foreach($rows as $row){
            echo '<option value="'. $row['id'] .'"> '. $row['name'] .' </option>';
        }
        
    }


?>