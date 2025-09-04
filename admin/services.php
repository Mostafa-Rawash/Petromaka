<?php

    // Manage services page 
    // you can Add | Edit | Delete services From Here

    session_start();

    $pageTitle = ' صفحة تعديل واضافة الخدمات ';
    



    if(isset($_SESSION['UserName'])){
        include 'init.php';

        // Start Manage services Page
        $do = isset($_GET['do'])? $_GET['do']:'manage-service';

        if($do == 'manage-service'){ // manage services page 

            

            
            // select all services 
        
        $stmt = $con->prepare("SELECT * FROM services  ORDER BY id DESC");

        // execute to the statment
        $stmt->execute();

        // assign data come to a variable

        $services = $stmt->fetchAll();

        if(! empty ($services)){
        
        
        ?>



<!-- <h1 class="text-center"> Manage services</h1> -->
<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>

<div class="board">
<div class="add-new-user">
        <a href="services.php?do=add" class="new-memeber-btn"><i class="fa fa-plus"></i>   خدمة جديدة  </a>
        </div>
            <table width="100%">
                <thead>
                    <tr>
                        <td>الصورة</td>
                        <td>العنوان</td>
                        <td> الوصف </td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>

                <?php if(! empty($services)){
                    foreach($services as $service){
                    ?>
                    <tr>


                        <td class="people">
                            <?php 
                            echo '<img src="../images/'. $service['img'] .'" alt="">';
                            ?>
                        </td>

                        
                        <td class="people-dec">
                            <h5><?php echo $service['header']; ?></h5>
                        </td>

                        <td class="people-dec">
                            <h5><?php echo $service['description']; ?></h5>
                        </td>


                        <td class="edit">
                            <?php echo "  <a href='services.php?do=edit&serviceid=" . $service['id'] . "' class='edit-btn'><i class='fa fa-edit'></i> Edit </a>
                                <a href='services.php?do=Delete&serviceid=" . $service['id'] . "' class='delete-btn confirm'><i class='fa fa-close'></i> Delete </a>";
                            
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
                echo '<div class="nice-message"> There Is No services To Show</div>';
                echo ' <a href="services.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> خدمة جديدة  </a>';
                echo '</div>';
            }?>







<?php } elseif ($do == 'add'){?>
<!--  Add services page -->

<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">



        <!-- Start service header filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> العنوان </label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="header" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End service header filed -->



        <!-- Start service description filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span>  الوصف </label>
            <div class="col-sm-10 col-md-4">
            <textarea name="description" class="form-control"></textarea>

            </div>
        </div>


        <!-- End service description filed -->
        





        <!-- Start service img filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> الصورة </label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="img" class="form-control" 
                    placeholder="service img"/>
            </div>
        </div>
        <!-- End service img filed -->



        <!-- Start Save Button filed -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="Submit" value="اضافة خدمة " class="btn btn-primary btn-lg" />
            </div>
        </div>
        <!-- End Save Button filed -->

    </form>
</div>
</section>



<?php 

        }elseif ($do == 'Insert'){

            // Insert service page

            

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo "<h1 class='text-center'>Add service </h1>";
            echo "<div class='container'>";

                // Upload Variables 


                // Get the variables from the form

                $header                                    = $_POST['header'];
                $description                               = $_POST['description'];
                

                // $avatar     = $_FILES['avatar'];

                if(isset($_FILES['img']) && $_FILES['img']['size'] > 0){

                
                    $imgName          = $_FILES['img']['name'];
                    $imgSize          = $_FILES['img']['size'];
                    $imgTmp           = $_FILES['img']['tmp_name'];
                    $imgType          = $_FILES['img']['type'];

                    // List of allowed files to be uploaded
                    $imgAllowedExtension = array("jpeg", "jpg", "png", "gif","webp");

                    // Get avatar Extension
                    $var= explode('.', $imgName);
                    $imgExtension = strtolower(end($var));

                }

                // validate the FORM
                $formERRORS = array();

                if (empty($header)) {
                    $formERRORS[] = '<div class="alert alert-danger"> header is Empty</div>';
                }
                if (empty($description)) {
                    $formERRORS[] = '<div class="alert alert-danger"> description is Empty</div>';
                }


                    
                
                if(isset($_FILES['img']) && $_FILES['img']['size'] > 0){
    
                    if (! empty($imgName) && ! in_Array($imgExtension, $imgAllowedExtension)) {
                        $formERRORS[] = '<div class="alert alert-danger">img Extension Is Forbidden  </div>';
                    }
                    if ($imgSize > 10194304) {
                        $formERRORS[] = '<div class="alert alert-danger"> img Is So large try smaller one  </div>';
                    }

                }


                // loop into errors Array And Echo It
                foreach ($formERRORS as $error) {
                    echo $error;
                }
    

                // check if there is no error Update the database

                if(empty($formERRORS)){
                    if(isset($_FILES['img']) && $_FILES['img']['size'] > 0){
                    if (!empty($imgName)) {
                        $img = rand(0, 100000) . '_' . $imgName;
                            move_uploaded_file($imgTmp, "../images/" . $img);


                    }
                }
                    //Insert User service in data base

                    $stmt = $con->prepare("INSERT
                                                INTO services
                                                ( header,
                                                description,
                                                img
                                                
                                                
                                                )
                                VALUES (:zheader,:zdescription,:zimg)");
                $stmt->execute(array(
                            'zheader'                   =>$header,
                            'zdescription'              =>$description,
                            'zimg'                      =>$img
                            
                            

                        ));

                //echo succes message
                echo '
                                <script>
                                    window.location= "services.php?do=add";
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

        $fields = getAllFrom("*","fields","","","id","");

            // check if get request userid is numeric & get the integer value of it

            $serviceid = isset($_GET['serviceid']) && is_numeric($_GET['serviceid'] ) ?intval ($_GET['serviceid']): 0 ;
            // select all data depend on this id 
            $stmt = $con->prepare("SELECT * FROM services WHERE id = ?  LIMIT 1");

            // excure query
            $stmt->execute(array($serviceid));

            // bring the data

            $row = $stmt->fetch();

            // The Row count

            $count = $stmt->rowCount();

            // if there is such id show the form

            if($count > 0) { ?>


<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    
        <form class="form-horizontal" action="?do=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="serviceid" value="<?php echo $serviceid; ?>" />

    


        <!-- Start service header filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> العنوان </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['header']; ?>" type="text" name="header" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End service header filed -->



        <!-- Start service description filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span>  الوصف </label>
            <div class="col-sm-10 col-md-4">
            <textarea name="description" class="form-control"><?php echo $row['description']; ?></textarea>

            </div>
        </div>


        <!-- End service description filed -->
        




        <!-- Start service img filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> الصورة </label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="img" class="form-control" 
                    placeholder="service img"/>
            </div>
        </div>
        <!-- End service img filed -->





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
            echo "<h1 class='text-center'> Update service </h1>";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Get the variables from the form
                $serviceid              = $_POST['serviceid'];
                
                $header                               = $_POST['header'];
                $description                               = $_POST['description'];

                // $avatar     = $_FILES['avatar'];

                if(isset($_FILES['img']) && $_FILES['img']['size'] > 0){

                
                    $imgName          = $_FILES['img']['name'];
                    $imgSize          = $_FILES['img']['size'];
                    $imgTmp           = $_FILES['img']['tmp_name'];
                    $imgType          = $_FILES['img']['type'];

                    // List of allowed files to be uploaded
                    $imgAllowedExtension = array("jpeg", "jpg", "png", "gif","webp");

                    // Get avatar Extension
                    $var= explode('.', $imgName);
                    $imgExtension = strtolower(end($var));

                }

                // validate the FORM
                $formERRORS = array();

                if (empty($header)) {
                    $formERRORS[] = '<div class="alert alert-danger"> header is Empty</div>';
                }
                if (empty($description)) {
                    $formERRORS[] = '<div class="alert alert-danger"> description is Empty</div>';
                }
                
                

                
                if(isset($_FILES['img']) && $_FILES['img']['size'] > 0){
    
                    if (! empty($imgName) && ! in_Array($imgExtension, $imgAllowedExtension)) {
                        $formERRORS[] = '<div class="alert alert-danger">img Extension Is Forbidden  </div>';
                    }
                    if ($imgSize > 10194304) {
                        $formERRORS[] = '<div class="alert alert-danger"> img Is So large try smaller one  </div>';
                    }

                }



    
                // loop into errors Array And Echo It
                foreach ($formERRORS as $error) {
                    echo $error;
                }
    
                // check if there is no error Update the database

                if(empty($formERRORS)){
                    if(isset($_FILES['img']) && $_FILES['img']['size'] > 0){
                    if(isset($_FILES['img']) && $imgSize != 0){
                        if (!empty($imgName)) {
                            $img = rand(0, 100000) . '_' . $imgName;
                            
                                move_uploaded_file($imgTmp, "../images/" . $img);

                        }
                }
            }

                //Update the database with this service



                if(isset($_FILES['img']) && $_FILES['img']['size'] > 0){
                $stmt = $con->prepare("UPDATE services SET header=?, description=?,img=? WHERE id = ?");
                $stmt->execute(array($header, $description, $img,$serviceid));

                //echo succes message
                
                echo '
                                <script>
                                    window.location= "services.php";
                                </script>
                            ';
                }else{
                    $stmt = $con->prepare("UPDATE services SET header=?, description=? WHERE id = ?");
                    $stmt->execute(array($header, $description ,$serviceid));
    
                    //echo succes message
                    echo '
                                <script>
                                    window.location= "services.php";
                                </script>
                            ';
                }

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

                        $serviceid = isset($_GET['serviceid']) && is_numeric($_GET['serviceid'] ) ?intval ($_GET['serviceid']): 0 ;
                        // select all data depend on this id 
                        $stmt = $con->prepare("SELECT * FROM services WHERE id = ?  LIMIT 1");

                        // check if there is an id as sent or not 

                        $check = checkItem('id','services', $serviceid);
            
                        // if there is such id show the form
            
                    if($check > 0) { 
                        $stmt = $con->prepare("DELETE FROM services WHERE id = :zserviceid");
                        $stmt->bindParam(":zserviceid" , $serviceid);
                        $stmt->execute();
                        echo '
                                <script>
                                    window.location= "services.php";
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

            $serviceid = isset($_GET['serviceid']) && is_numeric($_GET['serviceid'] ) ?intval ($_GET['serviceid']): 0 ;

            // select all data depend on this id 

            $stmt = $con->prepare("SELECT * FROM service WHERE id = ?  LIMIT 1");

            // check if there is an id as sent or not 

            $check = checkItem('id','service', $serviceid);

            // if there is such id show the form

        if($check > 0) { 
            $stmt = $con->prepare("UPDATE service SET active=1 Where id = ?");

            $stmt->execute(array($serviceid));


            echo '
                                <script>
                                    window.location= "services.php";
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