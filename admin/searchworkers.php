<?php
    session_start();
    include_once "config-ter.php";
    
    include 'connect.php';
    include "includes/functions/functions.php";
    $fields = getAllFrom("*","fields","","","id","");

    $search = trim($_GET["search"]);
    $sql = "SELECT * FROM workers WHERE name like '%{$search}%' OR idnumber like '%{$search}%'OR cardnumber like '%{$search}%'";
    $query = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_all($query,MYSQLI_ASSOC);

    if(mysqli_num_rows($query) == 0){



    }elseif(mysqli_num_rows($query) > 0){

        foreach($rows as $worker){
            echo '<tr>

            <td class="people">
            
                <img src="../workers/'. $worker['image'] .'" alt="">
            </td>

            
            <td class="people-dec">
                <h5>'. $worker['name'].'</h5>
            </td>

            <td class="people-dec">
                <h5>'.$worker['idnumber'].'</h5>
            </td>

            <td class="people-dec">

                <h5>';

                foreach($fields as $field){
                    if($field['id'] == $worker['location']){
                        echo $field['name']; 
                    }
                }

                echo '
                
                
                </h5>
            </td>

            <td class="people-dec">

            ';
            
                    if($worker['active'] == 0){
                        echo "<h5>not Active</h5>";
                    }else{
                        echo "<h5>Active</h5>";
                    }
                    echo'
            </td>
        

            <td class="edit">
                <a href="workers.php?do=edit&workerId=' . $worker['id'] . '" class="edit-btn"><i class="fa fa-edit"></i> Edit </a>
                    <a href="workers.php?do=Delete&workerId=' . $worker['id'] . '" class="delete-btn confirm"><i class="fa fa-close"></i> Delete </a>';
                    
                    if($worker['active'] == 0){
                        echo '<a href="workers.php?do=Activate&workerId='. $worker['id'] . '" class="edit-btn confirm"><i class="fa fa-edit"></i> Activate </a>';
                    }
                    echo'
            </td>

        </tr>';

        }
        
    }


