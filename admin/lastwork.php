<?php

    // Manage lastworks page 
    // you can Add | Edit | Delete lastworks From Here

    session_start();

    $pageTitle = ' صفحة تعديل واضافة الاخبار ';
    



    if(isset($_SESSION['UserName'])){
        include 'init.php';

        // Start Manage lastworks Page
        $do = isset($_GET['do'])? $_GET['do']:'manage-lastwork';

        if($do == 'manage-lastwork'){ // manage lastworks page 

            

            
            // select all lastworks 
        
        $stmt = $con->prepare("SELECT * FROM lastwork  ORDER BY id DESC");

        // execute to the statment
        $stmt->execute();

        // assign data come to a variable

        $lastworks = $stmt->fetchAll();

        if(! empty ($lastworks)){
        
        
        ?>



<!-- <h1 class="text-center"> Manage lastworks</h1> -->
<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>

<div class="board">
<div class="add-new-user">
        <a href="lastwork.php?do=add" class="new-memeber-btn"><i class="fa fa-plus"></i>  عمل جديد  </a>
        </div>
            <table width="100%">
                <thead>
                    <tr>
                        <td>الترتيب</td>
                        <td>الصورة</td>
                        <td>اسم الشركة</td>
                        <td>اسم المشروع</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>

                <?php if(! empty($lastworks)){
                    foreach($lastworks as $lastwork){
                    ?>
                    <tr>


                        <td class="people-dec">
                            <h5><?php echo $lastwork['number']; ?></h5>
                        </td>

                        <td class="people">
                            <?php 
                            echo '<img src="../images/'. $lastwork['img'] .'" alt="">';
                            ?>
                        </td>

                        
                        <td class="people-dec">
                            <h5><?php echo $lastwork['companyname']; ?></h5>
                        </td>

                        <td class="people-dec">
                            <h5><?php echo $lastwork['projectname']; ?></h5>
                        </td>


                        <td class="edit">
                            <?php echo "  <a href='lastwork.php?do=edit&lastworkid=" . $lastwork['id'] . "' class='edit-btn'><i class='fa fa-edit'></i> Edit </a>
                                <a href='lastwork.php?do=Delete&lastworkid=" . $lastwork['id'] . "' class='delete-btn confirm'><i class='fa fa-close'></i> Delete </a>";
                            
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
                echo '<div class="nice-message"> There Is No lastworks To Show</div>';
                echo ' <a href="lastwork.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> عمل جديد  </a>';
                echo '</div>';
            }?>







<?php } elseif ($do == 'add'){?>
<!--  Add lastworks page -->

<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">



        <!-- Start lastwork projectname filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> اسم المشروع </label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="projectname" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End lastwork projectname filed -->



        <!-- Start lastwork companyname filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> اسم الشركة </label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="companyname" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End lastwork companyname filed -->
        




        <!-- Start  number filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> ترتيب المشروع </label>
            <div class="col-sm-10 col-md-4">
                <input type="number" name="number" class="form-control" 
                    placeholder=""  />
            </div>
        </div>

        <!-- End  number filed -->



        <!-- Start lastwork img filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> الصورة </label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="img" class="form-control" 
                    placeholder="lastwork img"/>
            </div>
        </div>
        <!-- End lastwork img filed -->



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

            // Insert lastwork page

            

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo "<h1 class='text-center'>Add lastwork </h1>";
            echo "<div class='container'>";

                // Upload Variables 


                // Get the variables from the form

                $companyname                               = $_POST['companyname'];
                $projectname                               = $_POST['projectname'];
                $number                                    = $_POST['number'];
                

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

                if (empty($companyname)) {
                    $formERRORS[] = '<div class="alert alert-danger"> companyname is Empty</div>';
                }
                if (empty($projectname)) {
                    $formERRORS[] = '<div class="alert alert-danger"> projectname is Empty</div>';
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
                            move_uploaded_file($imgTmp, "../images/" . $img);


                    }
                }
                    //Insert User lastwork in data base

                    $stmt = $con->prepare("INSERT
                                                INTO lastwork
                                                ( projectname,
                                                companyname,
                                                img,
                                                number
                                                
                                                
                                                )
                                VALUES (:zprojectname,:zcompanyname,:zimg,:znumber)");
                $stmt->execute(array(
                            'zprojectname'              =>$projectname,
                            'zcompanyname'              =>$companyname,
                            'zimg'                      =>$img,
                            'znumber'                   =>$number
                            
                            

                        ));

                //echo succes message
                echo '
                                <script>
                                    window.location= "lastwork.php?do=add";
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

            $lastworkid = isset($_GET['lastworkid']) && is_numeric($_GET['lastworkid'] ) ?intval ($_GET['lastworkid']): 0 ;
            // select all data depend on this id 
            $stmt = $con->prepare("SELECT * FROM lastwork WHERE id = ?  LIMIT 1");

            // excure query
            $stmt->execute(array($lastworkid));

            // bring the data

            $row = $stmt->fetch();

            // The Row count

            $count = $stmt->rowCount();

            // if there is such id show the form

            if($count > 0) { ?>


<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    
        <form class="form-horizontal" action="?do=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="lastworkid" value="<?php echo $lastworkid; ?>" />

    


        <!-- Start lastwork projectname filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> اسم المشروع </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['projectname']; ?>" type="text" name="projectname" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End lastwork projectname filed -->



        <!-- Start lastwork companyname filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> اسم الشركة </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['companyname']; ?>" type="text" name="companyname" class="form-control"
                    placeholder="" />

            </div>
        </div>


        <!-- End lastwork companyname filed -->
        




        <!-- Start  number filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> ترتيب المشروع </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['number']; ?>" type="number" name="number" class="form-control" 
                    placeholder=""  />
            </div>
        </div>

        <!-- End  number filed -->



        <!-- Start lastwork img filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> الصورة </label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="img" class="form-control" 
                    placeholder="lastwork img"/>
            </div>
        </div>
        <!-- End lastwork img filed -->





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
            echo "<h1 class='text-center'> Update lastwork </h1>";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Get the variables from the form
                $lastworkid              = $_POST['lastworkid'];
                
                $companyname                               = $_POST['companyname'];
                $projectname                               = $_POST['projectname'];
                $number                                     = $_POST['number'];

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

                if (empty($companyname)) {
                    $formERRORS[] = '<div class="alert alert-danger"> companyname is Empty</div>';
                }
                if (empty($projectname)) {
                    $formERRORS[] = '<div class="alert alert-danger"> projectname is Empty</div>';
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
                            
                                move_uploaded_file($imgTmp, "../images/" . $img);

                        }
                }
            }

                //Update the database with this lastwork



                if(isset($_FILES['img']) && $_FILES['img']['size'] > 0){
                $stmt = $con->prepare("UPDATE lastwork SET projectname=?, companyname=?, img=?, number= ? WHERE id = ?");
                $stmt->execute(array($projectname, $companyname ,$img, $number,$lastworkid));

                //echo succes message
                
                echo '
                                <script>
                                    window.location= "lastwork.php";
                                </script>
                            ';
                }else{
                    $stmt = $con->prepare("UPDATE lastwork SET projectname=?, companyname=?, number= ? WHERE id = ?");
                    $stmt->execute(array($projectname, $companyname , $number,$lastworkid));
    
                    //echo succes message
                    echo '
                                <script>
                                    window.location= "lastwork.php";
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

                        $lastworkid = isset($_GET['lastworkid']) && is_numeric($_GET['lastworkid'] ) ?intval ($_GET['lastworkid']): 0 ;
                        // select all data depend on this id 
                        $stmt = $con->prepare("SELECT * FROM lastwork WHERE id = ?  LIMIT 1");

                        // check if there is an id as sent or not 

                        $check = checkItem('id','lastwork', $lastworkid);
            
                        // if there is such id show the form
            
                    if($check > 0) { 
                        $stmt = $con->prepare("DELETE FROM lastwork WHERE id = :zlastworkid");
                        $stmt->bindParam(":zlastworkid" , $lastworkid);
                        $stmt->execute();
                        echo '
                                <script>
                                    window.location= "lastwork.php";
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

            $lastworkid = isset($_GET['lastworkid']) && is_numeric($_GET['lastworkid'] ) ?intval ($_GET['lastworkid']): 0 ;

            // select all data depend on this id 

            $stmt = $con->prepare("SELECT * FROM lastwork WHERE id = ?  LIMIT 1");

            // check if there is an id as sent or not 

            $check = checkItem('id','lastwork', $lastworkid);

            // if there is such id show the form

        if($check > 0) { 
            $stmt = $con->prepare("UPDATE lastwork SET active=1 Where id = ?");

            $stmt->execute(array($lastworkid));


            echo '
                                <script>
                                    window.location= "lastwork.php";
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