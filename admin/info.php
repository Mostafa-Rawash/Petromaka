<?php

    // Manage information page 
    // you can Add | Edit | Delete information From Here

    session_start();

    $pageTitle = ' صفحة تعديل واضافة الاخبار ';
    



    if(isset($_SESSION['UserName'])){
        include 'init.php';

        // Start Manage information Page
        $do = isset($_GET['do'])? $_GET['do']:'manage-information';

        if($do == 'manage-information'){ // manage information page 

            

            
            // select all information 
        
        $stmt = $con->prepare("SELECT * FROM information  ORDER BY id DESC");

        // execute to the statment
        $stmt->execute();

        // assign data come to a variable

        $information = $stmt->fetchAll();

        if(! empty ($information)){
        
        
        ?>



<!-- <h1 class="text-center"> Manage information</h1> -->
<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>

<div class="board">
<div class="add-new-user">
        <a href="info.php?do=add" class="new-memeber-btn"><i class="fa fa-plus"></i>  خبر جديد  </a>
        </div>
            <table width="100%">
                <thead>
                    <tr>
                        <td>الترتيب</td>
                        <td>الصورة</td>
                        <td>العنوان</td>
                        <td> الوصف</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>

                <?php if(! empty($information)){
                    foreach($information as $info){
                    ?>
                    <tr>


                        <td class="people-dec">
                            <h5><?php echo $info['number']; ?></h5>
                        </td>

                        <td class="people">
                            <?php 
                            echo '<img src="../images/landing/'. $info['img'] .'" alt="">';
                            ?>
                        </td>

                        
                        <td class="people-dec">
                            <h5><?php echo $info['name']; ?></h5>
                        </td>


                        <td class="edit">
                            <?php echo "  <a href='info.php?do=edit&infoid=" . $info['id'] . "' class='edit-btn'><i class='fa fa-edit'></i> Edit </a>
                                <a href='info.php?do=Delete&infoid=" . $info['id'] . "' class='delete-btn confirm'><i class='fa fa-close'></i> Delete </a>";
                            
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
                echo '<div class="nice-message"> There Is No information To Show</div>';
                echo ' <a href="info.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> خبر جديد  </a>';
                echo '</div>';
            }?>







<?php } elseif ($do == 'add'){?>
<!--  Add information page -->

<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">



        <!-- Start info name filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> عنوان المقال </label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="name" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End info name filed -->



        <!-- Start info Description filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> المقال  </label>
            <div class="col-sm-10 col-md-4">
            <textarea name="description" class="form-control"
                    placeholder="" ></textarea>
            </div>
        </div>
        <!-- End info Description filed -->
        




        <!-- Start  number filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> ترتيب المقال </label>
            <div class="col-sm-10 col-md-4">
                <input type="number" name="number" class="form-control" 
                    placeholder=""  />
            </div>
        </div>

        <!-- End  number filed -->



        <!-- Start info img filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> الصورة </label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="img" class="form-control" 
                    placeholder="info img"/>
            </div>
        </div>
        <!-- End info img filed -->



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

            // Insert info page

            

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo "<h1 class='text-center'>Add information </h1>";
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

                if (empty($name)) {
                    $formERRORS[] = '<div class="alert alert-danger"> Name is Empty</div>';
                }
                if (empty($description)) {
                    $formERRORS[] = '<div class="alert alert-danger">description Is Empty</div>';
                }
                if (empty($number)) {
                    $formERRORS[] = '<div class="alert alert-danger">number Is Empty</div>';
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
                    //Insert User Info in data base

                    $stmt = $con->prepare("INSERT
                                                INTO information
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
                                    window.location= "info.php?do=add";
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

            $infoid = isset($_GET['infoid']) && is_numeric($_GET['infoid'] ) ?intval ($_GET['infoid']): 0 ;
            // select all data depend on this id 
            $stmt = $con->prepare("SELECT * FROM information WHERE id = ?  LIMIT 1");

            // excure query
            $stmt->execute(array($infoid));

            // bring the data

            $row = $stmt->fetch();

            // The Row count

            $count = $stmt->rowCount();

            // if there is such id show the form

            if($count > 0) { ?>


<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    
        <form class="form-horizontal" action="?do=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="infoid" value="<?php echo $infoid; ?>" />

    

        <!-- Start info name filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> عنوان المقال </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['name']; ?>" type="text" name="name" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End info name filed -->



        <!-- Start info Description filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> المقال  </label>
            <div class="col-sm-10 col-md-4">
            <textarea name="description" class="form-control"><?php echo $row['description']; ?></textarea>
            </div>
        </div>
        <!-- End info Description filed -->
        




        <!-- Start  number filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> ترتيب المقال </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['number']; ?>" type="number" name="number" class="form-control" 
                    placeholder=""  />
            </div>
        </div>

        <!-- End  number filed -->



        <!-- Start info img filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> الصورة </label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="img" class="form-control" 
                    placeholder="info img"/>
            </div>
        </div>
        <!-- End info img filed -->



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
            echo "<h1 class='text-center'> Update info </h1>";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Get the variables from the form
                $infoid              = $_POST['infoid'];
                
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

                if (empty($name)) {
                    $formERRORS[] = '<div class="alert alert-danger"> Name is Empty</div>';
                }
                if (empty($description)) {
                    $formERRORS[] = '<div class="alert alert-danger">description Is Empty</div>';
                }
                if (empty($number)) {
                    $formERRORS[] = '<div class="alert alert-danger">number Is Empty</div>';
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
                            
                                move_uploaded_file($imgTmp, "../images/landing/" . $img);

                        }
                }
            }

                //Update the database with this info



                if(isset($_FILES['img']) && $_FILES['img']['size'] > 0){
                $stmt = $con->prepare("UPDATE information SET name=?, img=?, description= ?, number= ? WHERE id = ?");
                $stmt->execute(array($name, $img, $description, $number,$infoid));

                //echo succes message
                
                echo '
                                <script>
                                    window.location= "info.php";
                                </script>
                            ';
                }else{
                    $stmt = $con->prepare("UPDATE information SET name=?,description= ?, number= ? WHERE id = ?");
                    $stmt->execute(array($name, $description, $number,$infoid));
    
                    //echo succes message
                    echo '
                                <script>
                                    window.location= "info.php";
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

                        $infoid = isset($_GET['infoid']) && is_numeric($_GET['infoid'] ) ?intval ($_GET['infoid']): 0 ;
                        // select all data depend on this id 
                        $stmt = $con->prepare("SELECT * FROM information WHERE id = ?  LIMIT 1");

                        // check if there is an id as sent or not 

                        $check = checkItem('id','information', $infoid);
            
                        // if there is such id show the form
            
                    if($check > 0) { 
                        $stmt = $con->prepare("DELETE FROM information WHERE id = :zinfoid");
                        $stmt->bindParam(":zinfoid" , $infoid);
                        $stmt->execute();
                        echo '
                                <script>
                                    window.location= "info.php";
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

            $infoid = isset($_GET['infoid']) && is_numeric($_GET['infoid'] ) ?intval ($_GET['infoid']): 0 ;

            // select all data depend on this id 

            $stmt = $con->prepare("SELECT * FROM information WHERE id = ?  LIMIT 1");

            // check if there is an id as sent or not 

            $check = checkItem('id','information', $infoid);

            // if there is such id show the form

        if($check > 0) { 
            $stmt = $con->prepare("UPDATE information SET active=1 Where id = ?");

            $stmt->execute(array($infoid));


            echo '
                                <script>
                                    window.location= "info.php";
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