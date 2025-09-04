<?php

    // Manage partners page 
    // you can Add | Edit | Delete partners From Here

    session_start();

    $pageTitle = ' صفحة تعديل واضافة الشركاء ';
    



    if(isset($_SESSION['UserName'])){
        include 'init.php';

        // Start Manage partners Page
        $do = isset($_GET['do'])? $_GET['do']:'manage-partner';

        if($do == 'manage-partner'){ // manage partners page 

            

            
            // select all partners 
        
        $stmt = $con->prepare("SELECT * FROM partner  ORDER BY id DESC");

        // execute to the statment
        $stmt->execute();

        // assign data come to a variable

        $partners = $stmt->fetchAll();

        if(! empty ($partners)){
        
        
        ?>



<!-- <h1 class="text-center"> Manage partners</h1> -->
<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>

<div class="board">
<div class="add-new-user">
        <a href="partners.php?do=add" class="new-memeber-btn"><i class="fa fa-plus"></i>  شريك جديد  </a>
        </div>
            <table width="100%">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>الصورة</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>

                <?php if(! empty($partners)){
                    foreach($partners as $partner){
                    ?>
                    <tr>


                        <td class="people-dec">
                            <h5><?php echo $partner['id']; ?></h5>
                        </td>

                        <td class="people">
                            <?php 
                            echo '<img src="../images/partners/'. $partner['img'] .'" alt="">';
                            ?>
                        </td>

                        <td class="edit">
                            <?php echo "  <a href='partners.php?do=edit&partnerid=" . $partner['id'] . "' class='edit-btn'><i class='fa fa-edit'></i> Edit </a>
                                <a href='partners.php?do=Delete&partnerid=" . $partner['id'] . "' class='delete-btn confirm'><i class='fa fa-close'></i> Delete </a>";
                            
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
                echo '<div class="nice-message"> There Is No partners To Show</div>';
                echo ' <a href="partners.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> شريك جديد  </a>';
                echo '</div>';
            }?>







<?php } elseif ($do == 'add'){?>
<!--  Add partners page -->

<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">




        <!-- Start partner img filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> الصورة </label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="img" class="form-control" 
                    placeholder="partner img"/>
            </div>
        </div>
        <!-- End partner img filed -->



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

            // Insert partner page

            

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo "<h1 class='text-center'>Add partner </h1>";
            echo "<div class='container'>";

                // Upload Variables 


                // Get the variables from the form

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

                if (!isset($_FILES['img'])) {
                    $formERRORS[] = '<div class="alert alert-danger">img can not be empty  </div>';
                }
                
                if(isset($_FILES['img']) && $_FILES['img']['size'] > 0){
    
                    if (! empty($imgName) && ! in_Array($imgExtension, $imgAllowedExtension)) {
                        $formERRORS[] = '<div class="alert alert-danger">img Extension Is Forbidden  </div>';
                    }
                    if ($imgSize == 0 || $imgSize == null) {
                        $formERRORS[] = '<div class="alert alert-danger">img can not be empty  </div>';
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
                            move_uploaded_file($imgTmp, "../images/partners/" . $img);


                    }
                }
                    //Insert User partner in data base

                    $stmt = $con->prepare("INSERT
                                                INTO partner
                                                ( 
                                                img
                                                
                                                
                                                )
                                VALUES (:zimg)");
                $stmt->execute(array(
                            'zimg'                      =>$img
                            
                            

                        ));

                //echo succes message
                echo '
                                <script>
                                    window.location= "partners.php?do=add";
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

            $partnerid = isset($_GET['partnerid']) && is_numeric($_GET['partnerid'] ) ?intval ($_GET['partnerid']): 0 ;
            // select all data depend on this id 
            $stmt = $con->prepare("SELECT * FROM partner WHERE id = ?  LIMIT 1");

            // excure query
            $stmt->execute(array($partnerid));

            // bring the data

            $row = $stmt->fetch();

            // The Row count

            $count = $stmt->rowCount();

            // if there is such id show the form

            if($count > 0) { ?>


<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    
        <form class="form-horizontal" action="?do=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="partnerid" value="<?php echo $partnerid; ?>" />

    



        <!-- Start partner img filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> الصورة </label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="img" class="form-control" 
                    placeholder="partner img"/>
            </div>
        </div>
        <!-- End partner img filed -->





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
            echo "<h1 class='text-center'> Update partner </h1>";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Get the variables from the form
                $partnerid              = $_POST['partnerid'];
                
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
                            
                                move_uploaded_file($imgTmp, "../images/partners/" . $img);

                        }
                }
            }

                //Update the database with this partner



                if(isset($_FILES['img']) && $_FILES['img']['size'] > 0){
                $stmt = $con->prepare("UPDATE partner SET img=? WHERE id = ?");
                $stmt->execute(array($$img, $partnerid));

                //echo succes message
                
                echo '
                                <script>
                                    window.location= "partners.php";
                                </script>
                            ';
                }else{
                    $stmt = $con->prepare("UPDATE partner SET img=? WHERE id = ?");
                $stmt->execute(array($$img, $partnerid));
    
                    //echo succes message
                    echo '
                                <script>
                                    window.location= "partners.php";
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

                        $partnerid = isset($_GET['partnerid']) && is_numeric($_GET['partnerid'] ) ?intval ($_GET['partnerid']): 0 ;
                        // select all data depend on this id 
                        $stmt = $con->prepare("SELECT * FROM partner WHERE id = ?  LIMIT 1");

                        // check if there is an id as sent or not 

                        $check = checkItem('id','partner', $partnerid);
            
                        // if there is such id show the form
            
                    if($check > 0) { 
                        $stmt = $con->prepare("DELETE FROM partner WHERE id = :zpartnerid");
                        $stmt->bindParam(":zpartnerid" , $partnerid);
                        $stmt->execute();
                        echo '
                                <script>
                                    window.location= "partners.php";
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

            $partnerid = isset($_GET['partnerid']) && is_numeric($_GET['partnerid'] ) ?intval ($_GET['partnerid']): 0 ;

            // select all data depend on this id 

            $stmt = $con->prepare("SELECT * FROM partner WHERE id = ?  LIMIT 1");

            // check if there is an id as sent or not 

            $check = checkItem('id','partner', $partnerid);

            // if there is such id show the form

        if($check > 0) { 
            $stmt = $con->prepare("UPDATE partner SET active=1 Where id = ?");

            $stmt->execute(array($partnerid));


            echo '
                                <script>
                                    window.location= "partners.php";
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