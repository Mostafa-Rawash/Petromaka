<?php

    // Manage companies page 
    // you can Add | Edit | Delete companies From Here

    session_start();

    $pageTitle = ' Edit companies';

    if(isset($_SESSION['UserName'])){
        include 'init.php';

        $do = isset($_GET['do'])? $_GET['do']:'manage-companies';

        // Start Manage companies Page

        if($do == 'manage-companies'){ // manage companies page 

            

            
            // select all companies 
        
        $stmt = $con->prepare("SELECT * FROM company  ORDER BY id DESC");

        // execute to the statment
        $stmt->execute();

        // assign data come to a variable

        $companies = $stmt->fetchAll();

        if(! empty ($companies)){
        
        
        ?>

<!-- <h1 class="text-center"> Manage companies</h1> -->
<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>

<div class="board">
<div class="add-new-user">
        <a href="companies.php?do=add" class="new-memeber-btn"><i class="fa fa-plus"></i>  New company </a>
        </div>
            <table width="100%">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>اسم الشركة</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>

                <?php if(! empty($companies)){
                    foreach($companies as $company){
                    ?>
                    <tr>

                        
                    <td class="people-dec">
                            <h5><?php echo $company['id']; ?></h5>
                        </td>
                        
                        <td class="people-dec">
                            <h5><?php echo $company['name']; ?></h5>
                        </td>

                        <td class="edit">
                            <?php echo "  <a href='companies.php?do=edit&companyId=" . $company['id'] . "' class='edit-btn'><i class='fa fa-edit'></i> Edit </a>
                                <a href='companies.php?do=Delete&companyId=" . $company['id'] . "' class='delete-btn confirm'><i class='fa fa-close'></i> Delete </a>";
                                
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
                echo '<div class="nice-message"> There Is No companies To Show</div>';
                echo ' <a href="companies.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> New company </a>';
                echo '</div>';
            }?>







<?php } elseif ($do == 'add'){?>
<!--  Add companies page -->

<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">



        <!-- Start company Name filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> اسم الشركة  </label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="name" class="form-control" required='required'
                    placeholder="company Name" />

            </div>
        </div>
        <!-- End company Name filed -->





        <!-- Start Save Button filed -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="Submit" value="Add company" class="btn btn-primary btn-lg" />
            </div>
        </div>
        <!-- End Save Button filed -->

    </form>
</div>
</section>



<?php 

        }elseif ($do == 'Insert'){

            // Insert company page

            

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo "<h1 class='text-center'>Add company </h1>";
            echo "<div class='container'>";

                // Upload Variables 


                // Get the variables from the form

                $name                       = $_POST['name'];
                
                // validate the FORM
                $formERRORS = array();

                if (empty($name)) {
                    $formERRORS[] = '<div class="alert alert-danger"> Name is Empty</div>';
                }
                // loop into errors Array And Echo It
                foreach ($formERRORS as $error) {
                    echo $error;
                }
    

                // check if there is no error Update the database

                if(empty($formERRORS)){
                    //Insert User Info in data base

                    $stmt = $con->prepare("INSERT
                                                INTO company
                                                ( name
                                                
                                                
                                                
                                                )
                                VALUES (:zname)");
                        $stmt->execute(array(
                            'zname'          =>$name
                            
                            

                        ));

                //echo succes message
                echo '
                <script>
                    window.location= "companies.php";
                </script>
            ';
                    }
            


            }else{

                echo '<div class="container">';

                $theMsg =  "<div class ='alert alert-danger'>sorry you cant Browse this page directly</div>";
                // function wriiten in functions file to redirect my page to the home page if the page got directly from any user

                echo '
                                <script>
                                    window.location= "index.php";
                                </script>
                            ';

                echo '</div>';
            }
            echo '</div>';

        
        
    
    }elseif ($do == 'edit') { // edit page 

            // check if get request userid is numeric & get the integer value of it

            $companyid = isset($_GET['companyId']) && is_numeric($_GET['companyId'] ) ?intval ($_GET['companyId']): 0 ;
            // select all data depend on this id 
            $stmt = $con->prepare("SELECT * FROM company WHERE id = ?  LIMIT 1");

            // excure query
            $stmt->execute(array($companyid));

            // bring the data

            $row = $stmt->fetch();

            // The Row count

            $count = $stmt->rowCount();

            // if there is such id show the form

            if($count > 0) { ?>


<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    
        <form class="form-horizontal" action="?do=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="companyId" value="<?php echo $companyid; ?>" />

        
        <!-- Start company Name filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">  اسم الشركة   </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['name'] ?>" type="text" name="name" class="form-control" required='required'
                    placeholder="company Name" />

            </div>
        </div>
        <!-- End company Name filed -->




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
                                </script>
                            ';

                    echo '</ div>';

                    }


            } elseif($do == 'update') { // Update page
            echo "<h1 class='text-center'> Update company </h1>";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Get the variables from the form
                $companyid              = $_POST['companyId'];
                $name                       = $_POST['name'];
                


                // validate the FORM
                $formERRORS = array();

                if (empty($name)) {
                    $formERRORS[] = '<div class="alert alert-danger"> Name is Empty</div>';
                }
                
    
                // loop into errors Array And Echo It
                foreach ($formERRORS as $error) {
                    echo $error;
                }
    
                // check if there is no error Update the database

                if(empty($formERRORS)){
                    

                //Update the database with this info

                $stmt = $con->prepare("UPDATE company SET name=? WHERE id = ?");
                $stmt->execute(array($name,$companyid));

                //echo succes message
                
                echo '
                                <script>
                                    window.location= "companies.php";
                                </script>
                            ';
                

                // }
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

                        $companyid = isset($_GET['companyId']) && is_numeric($_GET['companyId'] ) ?intval ($_GET['companyId']): 0 ;
                        // select all data depend on this id 
                        $stmt = $con->prepare("SELECT * FROM company WHERE id = ?  LIMIT 1");

                        // check if there is an id as sent or not 

                        $check = checkItem('id','company', $companyid);
            
                        // if there is such id show the form
            
                    if($check > 0) { 
                        $stmt = $con->prepare("DELETE FROM company WHERE id = :zcompanyid");
                        $stmt->bindParam(":zcompanyid" , $companyid);
                        $stmt->execute();
                        echo '
                                <script>
                                    window.location= "companies.php";
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

            $companyid = isset($_GET['companyId']) && is_numeric($_GET['companyId'] ) ?intval ($_GET['companyId']): 0 ;

            // select all data depend on this id 

            $stmt = $con->prepare("SELECT * FROM company WHERE id = ?  LIMIT 1");

            // check if there is an id as sent or not 

            $check = checkItem('id','company', $companyid);

            // if there is such id show the form

        if($check > 0) { 
            $stmt = $con->prepare("UPDATE company SET Approve=1 Where id = ?");

            $stmt->execute(array($companyid));


            echo '
                                <script>
                                    window.location= "companies.php";
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