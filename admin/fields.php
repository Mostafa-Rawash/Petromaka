<?php

    // Manage fields page 
    // you can Add | Edit | Delete fields From Here

    session_start();

    $pageTitle = ' Edit fields';

    if(isset($_SESSION['UserName'])){
        include 'init.php';

        $do = isset($_GET['do'])? $_GET['do']:'manage-fields';

        // Start Manage fields Page

        if($do == 'manage-fields'){ // manage fields page 

            

            
            // select all fields 
        
        $stmt = $con->prepare("SELECT * FROM fields  ORDER BY id DESC");

        $stmt2 = $con->prepare("SELECT * FROM company  ORDER BY id DESC");

        // execute to the statment
        $stmt->execute();
        $stmt2->execute();

        // assign data come to a variable

        $fields = $stmt->fetchAll();

        $companies = $stmt2->fetchAll();

        if(! empty ($fields)){
        
        
        ?>

<!-- <h1 class="text-center"> Manage fields</h1> -->
<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>

<div class="board">
<div class="add-new-user">
        <a href="fields.php?do=add" class="new-memeber-btn"><i class="fa fa-plus"></i>  اضافة موقع </a>
        </div>
            <table width="100%">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>اسم الموقع</td>
                        <td>اسم الشركة</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>

                <?php if(! empty($fields)){
                    foreach($fields as $field){
                    ?>
                    <tr>

                        
                    <td class="people-dec">
                            <h5><?php echo $field['id']; ?></h5>
                        </td>
                        
                        <td class="people-dec">
                            <h5><?php echo $field['name']; ?></h5>
                        </td>

                        <td class="people-dec">
                            <?php 
                                foreach($companies as $company){
                                    if($company['id'] == $field['company_id']){
                                        ?>
                                        <h5><?php echo $company['name']; ?></h5>
                                        <?php
                                    }
                                }
                            ?>
                            
                        </td>

                        <td class="edit">
                            <?php echo "  <a href='fields.php?do=edit&fieldId=" . $field['id'] . "' class='edit-btn'><i class='fa fa-edit'></i> Edit </a>
                                <a href='fields.php?do=Delete&fieldId=" . $field['id'] . "' class='delete-btn confirm'><i class='fa fa-close'></i> Delete </a>";
                                
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
                echo '<div class="nice-message"> There Is No fields To Show</div>';
                echo ' <a href="fields.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> New field </a>';
                echo '</div>';
            }?>







<?php } elseif ($do == 'add'){
    $stmt2 = $con->prepare("SELECT * FROM company  ORDER BY id DESC");
    $stmt2->execute();
    $companies = $stmt2->fetchAll();
    ?>

    
<!--  Add fields page -->

<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">



        <!-- Start field Name filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> اسم الموقع </label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="name" class="form-control" required='required'
                    placeholder=" اسم الموقع" />

            </div>
        </div>
        <!-- End field Name filed -->


        <!-- Start company_id filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> اسم الشركة </label>
            <div class="col-sm-10 col-md-4">
                
                
                    <select  required='required' name="company_id" class="form-control">
                        <option value=""> اختر الشركة</option>
                        <?php 
                            foreach($companies as $company){
                                echo '<option value="'.$company['id'].'"> '. $company['name'] .' </option>';
                            }
                        ?>
                    </select>

            </div>
        </div>
        <!-- End company_id filed -->





        <!-- Start Save Button filed -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="Submit" value="Add field" class="btn btn-primary btn-lg" />
            </div>
        </div>
        <!-- End Save Button filed -->

    </form>
</div>
</section>



<?php 

        }elseif ($do == 'Insert'){

            // Insert field page

            

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo "<h1 class='text-center'>Add field </h1>";
            echo "<div class='container'>";

                // Upload Variables 


                // Get the variables from the form

                $name                            = $_POST['name'];
                $comapnyid                       = $_POST['company_id'];
                
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
                                                INTO fields
                                                ( name,
                                                company_id
                                                
                                                
                                                
                                                )
                                VALUES (:zname,:zcompany_id)");
                $stmt->execute(array(
                            'zname'          =>$name,
                            'zcompany_id'    =>$comapnyid
                            
                            

                        ));

                //echo succes message
                echo '
                <script>
                    window.location= "fields.php";
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
        $stmt2 = $con->prepare("SELECT * FROM company  ORDER BY id DESC");
        $stmt2->execute();
        $companies = $stmt2->fetchAll();

            // check if get request userid is numeric & get the integer value of it

            $fieldid = isset($_GET['fieldId']) && is_numeric($_GET['fieldId'] ) ?intval ($_GET['fieldId']): 0 ;
            // select all data depend on this id 
            $stmt = $con->prepare("SELECT * FROM fields WHERE id = ?  LIMIT 1");

            // excure query
            $stmt->execute(array($fieldid));

            // bring the data

            $row = $stmt->fetch();

            // The Row count

            $count = $stmt->rowCount();

            // if there is such id show the form

            if($count > 0) { ?>


<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    
        <form class="form-horizontal" action="?do=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="fieldId" value="<?php echo $fieldid; ?>" />

        
        <!-- Start field Name filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">اسم الموقع </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['name'] ?>" type="text" name="name" class="form-control" required='required'
                    placeholder="field Name" />

            </div>
        </div>
        <!-- End field Name filed -->


        <!-- Start company_id filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> اسم الشركة </label>
            <div class="col-sm-10 col-md-4">
                
                
                    <select  required='required' name="company_id" class="form-control">
                        <?php 
                            foreach($companies as $company){
                                if($row['company_id'] == $company['id']){
                                    echo '<option selected value="'.$company['id'].'"> '. $company['name'] .' </option>';

                                }else{
                                    echo '<option value="'.$company['id'].'"> '. $company['name'] .' </option>';

                                }
                            }
                        ?>
                    </select>

            </div>
        </div>
        <!-- End company_id filed -->





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
            echo "<h1 class='text-center'> Update field </h1>";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Get the variables from the form
                $fieldid              = $_POST['fieldId'];
                $name                       = $_POST['name'];
                $comapnyid                       = $_POST['company_id'];
                


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

                $stmt = $con->prepare("UPDATE fields SET name=?, company_id = ? WHERE id = ?");
                $stmt->execute(array($name,$comapnyid,$fieldid));

                //echo succes message
                
                echo '
                                <script>
                                    window.location= "fields.php";
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

                        $fieldid = isset($_GET['fieldId']) && is_numeric($_GET['fieldId'] ) ?intval ($_GET['fieldId']): 0 ;
                        // select all data depend on this id 
                        $stmt = $con->prepare("SELECT * FROM fields WHERE id = ?  LIMIT 1");

                        // check if there is an id as sent or not 

                        $check = checkItem('id','fields', $fieldid);
            
                        // if there is such id show the form
            
                    if($check > 0) { 
                        $stmt = $con->prepare("DELETE FROM fields WHERE id = :zfieldid");
                        $stmt->bindParam(":zfieldid" , $fieldid);
                        $stmt->execute();
                        echo '
                                <script>
                                    window.location= "fields.php";
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

            $fieldid = isset($_GET['fieldId']) && is_numeric($_GET['fieldId'] ) ?intval ($_GET['fieldId']): 0 ;

            // select all data depend on this id 

            $stmt = $con->prepare("SELECT * FROM fields WHERE id = ?  LIMIT 1");

            // check if there is an id as sent or not 

            $check = checkItem('id','fields', $fieldid);

            // if there is such id show the form

        if($check > 0) { 
            $stmt = $con->prepare("UPDATE fields SET Approve=1 Where id = ?");

            $stmt->execute(array($fieldid));


            echo '
                                <script>
                                    window.location= "fields.php";
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