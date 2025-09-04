<?php

    // Manage aboutus page 
    // you can Add | Edit | Delete aboutus From Here

    session_start();

    $pageTitle = ' صفحة تعديل واضافة الاخبار ';
    



    if(isset($_SESSION['UserName'])){
        include 'init.php';

        // Start Manage aboutus Page
        $do = isset($_GET['do'])? $_GET['do']:'manage-aboutus';

        if($do == 'manage-aboutus'){ // manage aboutus page 

            

            
            // select all aboutus 
        
        $stmt = $con->prepare("SELECT * FROM aboutus  ORDER BY id DESC");

        // execute to the statment
        $stmt->execute();

        // assign data come to a variable

        $aboutus = $stmt->fetchAll();

        if(! empty ($aboutus)){
        
        
        ?>



<!-- <h1 class="text-center"> Manage aboutus</h1> -->
<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>

<div class="board">
<div class="add-new-user">
        </div>
            <table width="100%">
                <thead>
                    <tr>
                        <td> الصورة</td>
                        <td>العنوان</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>

                <?php if(! empty($aboutus)){
                    foreach($aboutus as $about){
                    ?>
                    <tr>

                        <td class="people">
                            <?php 
                            echo '<img src="../images/'. $about['img'] .'" alt="">';
                            ?>
                        </td>


                        <td class="people-dec">
                            <h5><?php echo $about['header']; ?></h5>
                        </td>


                        <td class="edit">
                            <?php echo "  <a href='aboutus.php?do=edit&aboutid=" . $about['id'] . "' class='edit-btn'><i class='fa fa-edit'></i> Edit </a>";
                            
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
                echo '<div class="nice-message"> There Is No aboutus To Show</div>';
                echo '</div>';
            }?>







<?php } elseif ($do == 'add'){?>
<!--  Add aboutus page -->

<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">



        <!-- Start about header filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> العنوان  </label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="header" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End about header filed -->




        <!-- Start about Description filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> الوصف  </label>
            <div class="col-sm-10 col-md-4">
            <textarea name="description" class="form-control"
                    placeholder="" ></textarea>
            </div>
        </div>
        <!-- End about Description filed -->
        


        <!-- Start about img filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> الصورة </label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="img" class="form-control" 
                    placeholder="about img"/>
            </div>
        </div>
        <!-- End about img filed -->



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

            // Insert about page

            

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo "<h1 class='text-center'>Add aboutus </h1>";
            echo "<div class='container'>";

                // Upload Variables 


                // Get the variables from the form

                $name                               = $_POST['name'];
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
                    //Insert User about in data base

                    $stmt = $con->prepare("INSERT
                                                INTO aboutus
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
                                    window.location= "aboutus.php?do=add";
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

            $aboutid = isset($_GET['aboutid']) && is_numeric($_GET['aboutid'] ) ?intval ($_GET['aboutid']): 0 ;
            // select all data depend on this id 
            $stmt = $con->prepare("SELECT * FROM aboutus WHERE id = ?  LIMIT 1");

            // excure query
            $stmt->execute(array($aboutid));

            // bring the data

            $row = $stmt->fetch();

            // The Row count

            $count = $stmt->rowCount();

            // if there is such id show the form

            if($count > 0) { ?>


<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    
        <form class="form-horizontal" action="?do=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="aboutid" value="<?php echo $aboutid; ?>" />

    

        <!-- Start about header filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> العنوان  </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['header']; ?>" type="text" name="header" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End about header filed -->



        <!-- Start about Description filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> الوصف  </label>
            <div class="col-sm-10 col-md-4">
            <textarea name="description" class="form-control"><?php echo $row['description']; ?></textarea>
            </div>
        </div>
        <!-- End about Description filed -->
        


        <!-- Start about img filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> الصورة </label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="img" class="form-control" 
                    placeholder="about img"/>
            </div>
        </div>
        <!-- End about img filed -->





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
            echo "<h1 class='text-center'> Update about </h1>";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Get the variables from the form
                $aboutid              = $_POST['aboutid'];
                
                $header                               = $_POST['header'];
                $description                          = $_POST['description'];

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

                //Update the database with this about



                if(isset($_FILES['img']) && $_FILES['img']['size'] > 0){
                $stmt = $con->prepare("UPDATE aboutus SET header=?, img=?, description= ? WHERE id = ?");
                $stmt->execute(array($header, $img, $description,$aboutid));

                //echo succes message
                
                echo '
                                <script>
                                    window.location= "aboutus.php";
                                </script>
                            ';
                }else{
                    $stmt = $con->prepare("UPDATE aboutus SET header=?,description= ? WHERE id = ?");
                    $stmt->execute(array($header,$description,$aboutid));
    
                    //echo succes message
                    echo '
                                <script>
                                    window.location= "aboutus.php";
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

                        $aboutid = isset($_GET['aboutid']) && is_numeric($_GET['aboutid'] ) ?intval ($_GET['aboutid']): 0 ;
                        // select all data depend on this id 
                        $stmt = $con->prepare("SELECT * FROM aboutus WHERE id = ?  LIMIT 1");

                        // check if there is an id as sent or not 

                        $check = checkItem('id','aboutus', $aboutid);
            
                        // if there is such id show the form
            
                    if($check > 0) { 
                        $stmt = $con->prepare("DELETE FROM aboutus WHERE id = :zaboutid");
                        $stmt->bindParam(":zaboutid" , $aboutid);
                        $stmt->execute();
                        echo '
                                <script>
                                    window.location= "aboutus.php";
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

            $aboutid = isset($_GET['aboutid']) && is_numeric($_GET['aboutid'] ) ?intval ($_GET['aboutid']): 0 ;

            // select all data depend on this id 

            $stmt = $con->prepare("SELECT * FROM aboutus WHERE id = ?  LIMIT 1");

            // check if there is an id as sent or not 

            $check = checkItem('id','aboutus', $aboutid);

            // if there is such id show the form

        if($check > 0) { 
            $stmt = $con->prepare("UPDATE aboutus SET active=1 Where id = ?");

            $stmt->execute(array($aboutid));


            echo '
                                <script>
                                    window.location= "aboutus.php";
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