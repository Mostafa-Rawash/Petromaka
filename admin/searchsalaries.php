<?php
    session_start();
    include_once "config-ter.php";
    
    include 'connect.php';
    include "includes/functions/functions.php";
    $fields = getAllFrom("*","fields","","","id","");

    $search = trim($_GET["search"]);
    $sql = "SELECT * FROM workers WHERE name like '%{$search}%' OR idnumber = '$search' OR cardnumber = '$search'";
    $query = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_all($query,MYSQLI_ASSOC);

    $workeridd = 0;

    foreach($rows as $workersids){
        $workeridd = $workersids['id'];
    }


    $stmt5 = $con->prepare("SELECT * FROM salaries WHERE workerid = $workeridd ORDER BY id DESC");
    $stmt5->execute();
    $salaries = $stmt5->fetchAll();


    if(mysqli_num_rows($query) == 0){



    }elseif(mysqli_num_rows($query) > 0){

        foreach($salaries as $salary){
            echo '

                <tr>

                ';

                $workersnames = getAllFrom("*","workers","where id = $workeridd","","id","");

                foreach($workersnames as $name){
                    echo' <td class="people-dec">
                    <h5> '. $name['name'] .'</h5>
                </td>';
                }
                
                
            

                        echo'
                        <td class="people-dec">
                        <h5> '. $salary['workerid'] .'</h5>
                    </td>
                        ';
                    
                


                    

                        echo'
                        <td class="people-dec">
                        <h5> '. $salary['salary'] .'</h5>
                    </td>
                        ';
                    
                    
                
                    

                    echo"
                    <td class='edit'>
                            <a href='salaries.php?do=edit&salaryId=" . $salary['id'] . "' class='edit-btn'><i class='fa fa-edit'></i> Edit </a>
                            <a href='salaries.php?do=Delete&salaryId=" . $salary['id'] . "' class='delete-btn confirm'><i class='fa fa-close'></i> Delete </a>
                            
                        
                    </td>
                    ";
                    echo'

                </tr>
                ';

        }
        
    }


