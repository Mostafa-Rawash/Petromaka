<?php

    // Manage clientwords page 
    // you can Add | Edit | Delete clientwords From Here

    session_start();

    $pageTitle = ' صفحة تعديل واضافة الاخبار ';
    



    if(isset($_SESSION['UserName'])){
        include 'init.php';

        // Start Manage clientwords Page
        $do = isset($_GET['do'])? $_GET['do']:'manage-clientwords';

        if($do == 'manage-clientwords'){ // manage clientwords page 

            

            
            // select all clientwords 
        
        $stmt = $con->prepare("SELECT * FROM clientword  ORDER BY id DESC");

        // execute to the statment
        $stmt->execute();

        // assign data come to a variable

        $clientwords = $stmt->fetchAll();

        if(! empty ($clientwords)){
        
        
        ?>



<!-- <h1 class="text-center"> Manage clientwords</h1> -->
<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>

<div class="board">
<div class="add-new-user">
        </div>
            <table width="100%">
                <thead>
                    <tr>
                        <td> الصورة</td>
                        <td>الاسم</td>
                        <td>الوظيفة</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>

                <?php if(! empty($clientwords)){
                    foreach($clientwords as $clientword){
                    ?>
                    <tr>

                        <td class="people">
                            <?php 
                            echo '<img src="../images/'. $clientword['img'] .'" alt="">';
                            ?>
                        </td>


                        <td class="people-dec">
                            <h5><?php echo $clientword['name']; ?></h5>
                        </td>

                        
                        <td class="people-dec">
                            <h5><?php echo $clientword['postition']; ?></h5>
                        </td>


                        <td class="edit">
                            <?php echo "  <a href='clientword.php?do=edit&clientwordid=" . $clientword['id'] . "' class='edit-btn'><i class='fa fa-edit'></i> Edit </a>";
                            
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
                echo '<div class="nice-message"> There Is No clientwords To Show</div>';
                echo '</div>';
            }?>







<?php } elseif ($do == 'add'){?>
<!--  Add clientwords page -->

<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">



        <!-- Start clientword header filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> العنوان  </label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="header" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End clientword header filed -->




        <!-- Start clientword Description filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> الوصف  </label>
            <div class="col-sm-10 col-md-4">
            <textarea name="description" class="form-control"
                    placeholder="" ></textarea>
            </div>
        </div>
        <!-- End clientword Description filed -->
        


        <!-- Start clientword img filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> الصورة </label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="img" class="form-control" 
                    placeholder="clientword img"/>
            </div>
        </div>
        <!-- End clientword img filed -->



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

        }elseif ($do == 'Insert'){

            // Insert clientword page

            

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo "<h1 class='text-center'>Add clientwords </h1>";
            echo "<div class='container'>";

                // Upload Variables 


                // Get the variables from the form

                $name                               = $_POST['name'];
                $postition                               = $_POST['name'];
                $description                        = $_POST['description'];
                $number                             = $_POST['number'];
                

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
                    $formERRORS[] = '<div class="alert alert-danger"> Name is Empty</div>';
                }
                
                if (empty($description)) {
                    $formERRORS[] = '<div class="alert alert-danger">description Is Empty</div>';
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
                            move_uploaded_file($imgTmp, "../images/landing/" . $img);


                    }
                }
                    //Insert User clientword in data base

                    $stmt = $con->prepare("INSERT
                                                INTO clientword
                                                ( name,
                                                img,
                                                description,
                                                number
                                                
                                                
                                                )
                                VALUES (:zname,:zimg,:zdescription,:znumber)");
                $stmt->execute(array(
                            'zname'                     =>$name,
                            'zimg'                      =>$img,
                            'zdescription'              =>$description,
                            'znumber'                   =>$number
                            
                            

                        ));

                //echo succes message
                echo '
                                <script>
                                    window.location= "clientword.php?do=add";
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

            $clientwordid = isset($_GET['clientwordid']) && is_numeric($_GET['clientwordid'] ) ?intval ($_GET['clientwordid']): 0 ;
            // select all data depend on this id 
            $stmt = $con->prepare("SELECT * FROM clientword WHERE id = ?  LIMIT 1");

            // excure query
            $stmt->execute(array($clientwordid));

            // bring the data

            $row = $stmt->fetch();

            // The Row count

            $count = $stmt->rowCount();

            // if there is such id show the form

            if($count > 0) { ?>


<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    
        <form class="form-horizontal" action="?do=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="clientwordid" value="<?php echo $clientwordid; ?>" />

    

        <!-- Start clientword header filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> الاسم  </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['name']; ?>" type="text" name="name" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End clientword header filed -->


        <!-- Start clientword header filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> الوظيفة  </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['postition']; ?>" type="text" name="postition" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End clientword header filed -->




        <!-- Start clientword Description filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> الوصف  </label>
            <div class="col-sm-10 col-md-4">
            <textarea name="description" class="form-control"><?php echo $row['description']; ?></textarea>
            </div>
        </div>
        <!-- End clientword Description filed -->
        


        <!-- Start clientword img filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> الصورة </label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="img" class="form-control" 
                    placeholder="clientword img"/>
            </div>
        </div>
        <!-- End clientword img filed -->





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
            echo "<h1 class='text-center'> Update clientword </h1>";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Get the variables from the form
                $clientwordid              = $_POST['clientwordid'];
                
                $name                                   = $_POST['name'];
                $postition                               = $_POST['postition'];
                $description                            = $_POST['description'];

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

                if (empty($name)) {
                    $formERRORS[] = '<div class="alert alert-danger"> name is Empty</div>';
                }
                if (empty($postition)) {
                    $formERRORS[] = '<div class="alert alert-danger"> postition is Empty</div>';
                }
                if (empty($description)) {
                    $formERRORS[] = '<div class="alert alert-danger">description Is Empty</div>';
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

                //Update the database with this clientword



                if(isset($_FILES['img']) && $_FILES['img']['size'] > 0){
                $stmt = $con->prepare("UPDATE clientword SET name=?,postition=?, img=?, description= ? WHERE id = ?");
                $stmt->execute(array($name,$postition, $img, $description,$clientwordid));

                //echo succes message
                
                echo '
                                <script>
                                    window.location= "clientword.php";
                                </script>
                            ';
                }else{
                    $stmt = $con->prepare("UPDATE clientword SET name=?,postition=?, description= ? WHERE id = ?");
                    $stmt->execute(array($name,$postition, $description,$clientwordid));
    
    
                    //echo succes message
                    echo '
                                <script>
                                    window.location= "clientword.php";
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

                        $clientwordid = isset($_GET['clientwordid']) && is_numeric($_GET['clientwordid'] ) ?intval ($_GET['clientwordid']): 0 ;
                        // select all data depend on this id 
                        $stmt = $con->prepare("SELECT * FROM clientword WHERE id = ?  LIMIT 1");

                        // check if there is an id as sent or not 

                        $check = checkItem('id','clientword', $clientwordid);
            
                        // if there is such id show the form
            
                    if($check > 0) { 
                        $stmt = $con->prepare("DELETE FROM clientword WHERE id = :zclientwordid");
                        $stmt->bindParam(":zclientwordid" , $clientwordid);
                        $stmt->execute();
                        echo '
                                <script>
                                    window.location= "clientword.php";
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

            $clientwordid = isset($_GET['clientwordid']) && is_numeric($_GET['clientwordid'] ) ?intval ($_GET['clientwordid']): 0 ;

            // select all data depend on this id 

            $stmt = $con->prepare("SELECT * FROM clientword WHERE id = ?  LIMIT 1");

            // check if there is an id as sent or not 

            $check = checkItem('id','clientword', $clientwordid);

            // if there is such id show the form

        if($check > 0) { 
            $stmt = $con->prepare("UPDATE clientword SET active=1 Where id = ?");

            $stmt->execute(array($clientwordid));


            echo '
                                <script>
                                    window.location= "clientword.php";
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