<?php

    // Manage stats page 
    // you can Add | Edit | Delete stats From Here

    session_start();

    $pageTitle = ' صفحة تعديل الاحصائيات  ';
    



    if(isset($_SESSION['UserName'])){
        include 'init.php';

        // Start Manage stats Page
        $do = isset($_GET['do'])? $_GET['do']:'manage-stats';

        if($do == 'manage-stats'){ // manage stats page 

            

            
            // select all stats 
        
        $stmt = $con->prepare("SELECT * FROM stats  ORDER BY id DESC");

        // execute to the statment
        $stmt->execute();

        // assign data come to a variable

        $stats = $stmt->fetchAll();

        if(! empty ($stats)){
        
        
        ?>



<!-- <h1 class="text-center"> Manage stats</h1> -->
<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>

<div class="board">
<div class="add-new-user">
        </div>
            <table width="100%">
                <thead>
                    <tr>
                        <td> العنوان</td>
                        <td>الرقم</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>

                <?php if(! empty($stats)){
                    foreach($stats as $stat){
                    ?>
                    <tr>

                        <td class="people-dec">
                            <h5><?php echo $stat['name']; ?></h5>
                        </td>

                        
                        <td class="people-dec">
                            <h5><?php echo $stat['number']; ?></h5>
                        </td>


                        <td class="edit">
                            <?php echo "  <a href='stats.php?do=edit&statid=" . $stat['id'] . "' class='edit-btn'><i class='fa fa-edit'></i> Edit </a>";
                            
                            ?>
                        </td>

                    </tr>
                <?php 
                }
            }
            ?>

                </tbody>
            </table>

        </div>
        
        </section>



<?php }else{
                echo '<div id="interface" class="container">';
                echo '<div class="nice-message"> There Is No stats To Show</div>';
                echo '</div>';
            }?>







<?php } elseif ($do == 'add'){?>
<!--  Add stats page -->

<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">



        <!-- Start stat header filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> العنوان  </label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="header" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End stat header filed -->




        <!-- Start stat Description filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> الوصف  </label>
            <div class="col-sm-10 col-md-4">
            <textarea name="description" class="form-control"
                    placeholder="" ></textarea>
            </div>
        </div>
        <!-- End stat Description filed -->
        


        <!-- Start stat img filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> الصورة </label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="img" class="form-control" 
                    placeholder="stat img"/>
            </div>
        </div>
        <!-- End stat img filed -->



        <!-- Start Save Button filed -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="Submit" value="اضافة الخبر " class="btn btn-primary btn-lg" />
            </div>
        </div>
        <!-- End Save Button filed -->

    </form>
</div>
</section>



<?php 

        }elseif ($do == 'edit') { // edit page 

        $fields = getAllFrom("*","fields","","","id","");

            // check if get request userid is numeric & get the integer value of it

            $statid = isset($_GET['statid']) && is_numeric($_GET['statid'] ) ?intval ($_GET['statid']): 0 ;
            // select all data depend on this id 
            $stmt = $con->prepare("SELECT * FROM stats WHERE id = ?  LIMIT 1");

            // excure query
            $stmt->execute(array($statid));

            // bring the data

            $row = $stmt->fetch();

            // The Row count

            $count = $stmt->rowCount();

            // if there is such id show the form

            if($count > 0) { ?>


<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    
        <form class="form-horizontal" action="?do=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="statid" value="<?php echo $statid; ?>" />

    

        <!-- Start stat header filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> الاسم  </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['name']; ?>" type="text" name="name" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End stat header filed -->


        <!-- Start stat header filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> العدد  </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['number']; ?>" type="text" name="number" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End stat header filed -->









        <!-- Start Save Button filed -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="Submit" value="تحديث" class="btn btn-primary btn-lg" />
            </div>
        </div>
        <!-- End Save Button filed -->

    </form>

    
</div>
</section>


<?php 

            // else show error message

            } else { 
                    echo '<div class="container">';

                    $theMsg =  '<div class="alert alert-danger">there is no such ID </div>';

                    echo '
                                <script>
                                    window.location= "index.php";
                                </>
                            ';

                    echo '</ div>';

                    }


            } elseif($do == 'update') { // Update page
            echo "<h1 class='text-center'> Update stat </h1>";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Get the variables from the form
                $statid              = $_POST['statid'];
                
                $name                                   = $_POST['name'];
                $number                               = $_POST['number'];



                // validate the FORM
                $formERRORS = array();

                if (empty($name)) {
                    $formERRORS[] = '<div class="alert alert-danger"> name is Empty</div>';
                }
                if (empty($number)) {
                    $formERRORS[] = '<div class="alert alert-danger"> postition is Empty</div>';
                }
                

                // loop into errors Array And Echo It
                foreach ($formERRORS as $error) {
                    echo $error;
                }
    
                // check if there is no error Update the database

                if(empty($formERRORS)){

                //Update the database with this stat



                $stmt = $con->prepare("UPDATE stats SET name=?,number=? WHERE id = ?");
                $stmt->execute(array($name,$number,$statid));

                //echo succes message
                
                echo '
                                <script>
                                    window.location= "stats.php";
                                </script>
                            ';
                
            }


            }else{

                $theMsg =  "<div class = 'alert alert-danger'>sorry you cant Browse this page directly</div>";

                echo '
                                <script>
                                    window.location= "index.php";
                                </script>
                            ';
            }
            echo '</div>';


        }elseif($do == 'Delete'){ // Delete Member Page

                        // check if get request userid is numeric & get the integer value of it

                        $statid = isset($_GET['statid']) && is_numeric($_GET['statid'] ) ?intval ($_GET['statid']): 0 ;
                        // select all data depend on this id 
                        $stmt = $con->prepare("SELECT * FROM stat WHERE id = ?  LIMIT 1");

                        // check if there is an id as sent or not 

                        $check = checkItem('id','stat', $statid);
            
                        // if there is such id show the form
            
                    if($check > 0) { 
                        $stmt = $con->prepare("DELETE FROM stat WHERE id = :zstatid");
                        $stmt->bindParam(":zstatid" , $statid);
                        $stmt->execute();
                        echo '
                                <script>
                                    window.location= "stats.php";
                                </script>
                            ';
                    }else{
                        $theMsg = "<div class='alert alert-danger'>This ID is NOT Exist</div>"; 
                        echo '
                                <script>
                                    window.location= "index.php";
                                </script>
                            ';
                    }

                    echo '</div>';
        } elseif($do == 'Activate'){

            // check if get request userid is numeric & get the integer value of it

            $statid = isset($_GET['statid']) && is_numeric($_GET['statid'] ) ?intval ($_GET['statid']): 0 ;

            // select all data depend on this id 

            $stmt = $con->prepare("SELECT * FROM stat WHERE id = ?  LIMIT 1");

            // check if there is an id as sent or not 

            $check = checkItem('id','stat', $statid);

            // if there is such id show the form

        if($check > 0) { 
            $stmt = $con->prepare("UPDATE stat SET active=1 Where id = ?");

            $stmt->execute(array($statid));


            echo '
                                <script>
                                    window.location= "stats.php";
                                </script>
                            ';
        }else{
            $theMsg = "<div class='alert alert-danger'>This ID is NOT Exist</div>"; 
            echo '
                                <script>
                                    window.location= "index.php";
                                </script>
                            ';
        }

        echo '</div>';

        


    }

        include $tpl."footer.php";
    }else{
        header('location:index.php');
        exit();
    }