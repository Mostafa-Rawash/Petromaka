<?php

    // Manage workers page 
    // you can Add | Edit | Delete workers From Here

    session_start();

    $pageTitle = ' صفحة تعديل واضافة العمال ';



    if(isset($_SESSION['UserName'])){
        include 'init.php';



        $companies = getAllFrom("*","company","","","id","");
        $fields = getAllFrom("*","fields","","","id","");
        $do = isset($_GET['do'])? $_GET['do']:'manage-workers';

        // Start Manage workers Page

        if($do == 'manage-workers'){ // manage workers page 

            

            
            // select all workers 
        
        $stmt = $con->prepare("SELECT * FROM workers  ORDER BY id DESC");

        // execute to the statment
        $stmt->execute();

        // assign data come to a variable

        $workers = $stmt->fetchAll();

        if(! empty ($workers)){
        
        
        ?>



<!-- <h1 class="text-center"> Manage workers</h1> -->
<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>

<div class="board">
<div class="add-new-user">
        <a href="workers.php?do=add" class="new-memeber-btn"><i class="fa fa-plus"></i>  عامل جديد  </a>
        </div>
            <table width="100%">
                <thead>
                    <tr>
                        <td>الصورة</td>
                        <td>الاسم</td>
                        <td>رقم العامل</td>
                        <td>الموقع</td>
                        <td>حالة الحساب</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody id="workerstablebody">

                <?php if(! empty($workers)){
                    foreach($workers as $worker){
                    ?>
                    <tr>

                        <td class="people">
                            <?php 
                            echo '<img src="../workers/'. $worker['image'] .'" alt="">';
                            ?>
                        </td>

                        
                        <td class="people-dec">
                            <h5><?php echo $worker['name']; ?></h5>
                        </td>

                        <td class="people-dec">
                            <h5><?php echo $worker['idnumber']; ?></h5>
                        </td>

                        <td class="people-dec">

                            <h5><?php
                            foreach($fields as $field){
                                if($field['id'] == $worker['location']){
                                    echo $field['name']; 
                                }
                            }
                            
                            
                            
                            ?></h5>
                        </td>

                        <td class="people-dec">
                            <?php
                                if($worker['active'] == 0){
                                    echo "<h5>not Active</h5>";
                                }else{
                                    echo "<h5>Active</h5>";
                                }
                            ?>
                        </td>
                    

                        <td class="edit">
                            <?php echo "  <a href='workers.php?do=edit&workerId=" . $worker['id'] . "' class='edit-btn'><i class='fa fa-edit'></i> Edit </a>
                                <a href='workers.php?do=Delete&workerId=" . $worker['id'] . "' class='delete-btn confirm'><i class='fa fa-close'></i> Delete </a>";
                                
                                if($worker['active'] == 0){
                                    echo "<a href='workers.php?do=Activate&workerId=" . $worker['id'] . "' class='edit-btn confirm'><i class='fa fa-edit'></i> Activate </a>";
                                }
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

        
<!-- Search -->

<script src="layout/js/jquery-1.12.1.min.js"></script>
<script>
    
            $(".SearchBUtton").click(function(){
                
                let xhr = new XMLHttpRequest();
                console.log($('#searchINput').val());
                    if($('#searchINput').val() !== "0" || $('#searchINput').val() != null || $('#searchINput').val() !== "" || $('#searchINput').val() !== " "){
                    xhr.open("GET", "searchworkers.php?search=" + $('#searchINput').val(), true);
                    
                    xhr.onload = () => {
                        if (xhr.readyState == XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {

                                
                                let data = xhr.response;
                                $('#workerstablebody').empty().append(`${data}`);
                                data = [];
                            
                            
                            }
                        }
                    }
                    

                    xhr.send();
                    }
            })

            $('#searchINput').keypress(function(event){
	
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                let xhr = new XMLHttpRequest();
                console.log($('#searchINput').val());
                    if($('#searchINput').val() !== "0" || $('#searchINput').val() != null || $('#searchINput').val() !== "" || $('#searchINput').val() !== " "){
                    xhr.open("GET", "searchworkers.php?search=" + $('#searchINput').val(), true);
                    
                    xhr.onload = () => {
                        if (xhr.readyState == XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {

                                
                                let data = xhr.response;
                                $('#workerstablebody').empty().append(`${data}`);
                                data = [];
                            
                            
                            }
                        }
                    }
                    

                    xhr.send();
                    }
            }

        });

        </script>














<!--Search -->
        



<?php }else{
                echo '<div id="interface" class="container">';
                echo '<div class="nice-message"> There Is No workers To Show</div>';
                echo ' <a href="workers.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> عامل جديد  </a>';
                echo '</div>';
            }?>







<?php } elseif ($do == 'add'){?>
<!--  Add workers page -->

<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">



        <!-- Start worker Username filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> اسم تسجيل الدخول  </label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="username" class="form-control"
                    placeholder="use to login" />

            </div>
        </div>


        <!-- End worker Username filed -->





        <!-- Start worker password filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> كلمة المرور </label>
            <div class="col-sm-10 col-md-4">
                <input id="generatehere" type="password" name="password" class="form-control" 
                    placeholder="password"  />

                    <input  class="show-password-input" type="checkbox" onclick="ShowPassword()">Show Password

                <script>
                    function ShowPassword() {
                        var x = document.getElementById("generatehere");
                        if (x.type === "password") {
                            x.type = "text";
                        } else {
                            x.type = "password";
                        }
                        }


                    var password=document.getElementById("generatehere");
                    var chars = "0123456789abcdeklmnouvwxyz";
                    var passwordLength = 7;
                    var password = "";

                    for (var i = 0; i <= passwordLength; i++) {
                        var randomNumber = Math.floor(Math.random() * chars.length);
                        password += chars.substring(randomNumber, randomNumber +1);
                    }
                    document.getElementById("generatehere").value = password;
                </script>
            </div>
        </div>
        <!-- End worker password filed -->




        <!-- Start worker Description filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> اسم العامل </label>
            <div class="col-sm-10 col-md-4">
            <input type="text" name="name" class="form-control" 
                    placeholder="show in profile"  />
            </div>
        </div>
        <!-- End worker Description filed -->
        

        <!-- Start worker number filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> رقم العامل </label>
            <div class="col-sm-10 col-md-4">
                <input type="number" name="idnumber" class="form-control" 
                    placeholder="Worker number"  />
            </div>
        </div>

        <!-- End worker number filed -->


        <!-- Start worker daysoffremain filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span>  رصيد الاجازات </label>
            <div class="col-sm-10 col-md-4">
                <input type="number" name="daysoffremain" class="form-control" 
                    placeholder="رصيد الاجازات"  />
            </div>
        </div>

        <!-- End worker daysoffremain filed -->



        <!-- Start worker position filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span>  الوظيفة </label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="position" class="form-control" 
                    placeholder="وظيفة العامل"  />
            </div>
        </div>

        <!-- End worker position filed -->


        <!-- Start worker card number filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> رقم البطاقة </label>
            <div class="col-sm-10 col-md-4">
                <input type="number" name="cardnumber" class="form-control" 
                    placeholder="رقم البطاقة"  />
            </div>
        </div>

        <!-- End worker card number filed -->



        <!-- Start worker phonenumber filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> رقم الهاتف </label>
            <div class="col-sm-10 col-md-4">
                <input type="number" name="phonenumber" class="form-control" 
                    placeholder="رقم الهاتف"  />
            </div>
        </div>

        <!-- End worker phonenumber filed -->


        <!-- Start worker insnumber filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> رقم التامين </label>
            <div class="col-sm-10 col-md-4">
                <input type="number" name="insnumber" class="form-control" 
                    placeholder="رقم التامين"  />
            </div>
        </div>

        <!-- End worker insnumber filed -->


        <!-- Start worker insnumber filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span>  سعر الوجبة </label>
            <div class="col-sm-10 col-md-4">
                <input type="number" name="mealprice" class="form-control" 
                    placeholder=" سعر الوجبة"  />
            </div>
        </div>

        <!-- End worker insnumber filed -->





        <!-- Start worker company filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> اسم الشركة</label>
            <div class="col-sm-10 col-md-4">
        <select id="select-company"  required='required' name="company" class="form-control">
            <option value="0"> اختر الشركة</option>
            <?php 
                foreach($companies as $company){
                    echo '<option value="'.$company['id'].'"> '. $company['name'] .' </option>';
                }
            ?>
        </select>

        </div>
        </div>

        <script src="layout/js/jquery-1.12.1.min.js"></script>
        

        <!-- End worker compay filed -->



        <!-- Start worker Location filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> الموقع  </label>
            <div class="col-sm-10 col-md-4">
            <select id="select-fields"  required='required' name="location" class="form-control">
            <option value="0"> اختر الموقع</option>

        
            <script>
            $("#select-company").click(function(){
                
                let xhr = new XMLHttpRequest();
                console.log($(this).val());
                    if($(this).val() !== "0" || $(this).val() != null){
                    xhr.open("GET", "get-fields.php?companyid=" + $(this).val(), true);
                    
                    xhr.onload = () => {
                        if (xhr.readyState == XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {

                                
                                let data = xhr.response;
                                $('#select-fields').empty().append(`<option value=""> اختر الموقع</option>`);
                                $('#select-fields').append(`${data}`);
                                data = [];
                            
                            
                            }
                        }
                    }
                    

                    xhr.send();
                    }
            })

        </script>
                
            </select>

                    
            </div>
        </div>
        <!-- End worker Location filed -->

        


        <!-- Start worker Image filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> الصورة </label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="image" class="form-control" 
                    placeholder="worker Image"/>
            </div>
        </div>
        <!-- End worker Image filed -->


        <!-- Start worker email filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> البريد الالكتروني </label>
            <div class="col-sm-10 col-md-4">
                <input type="email" name="email" class="form-control" 
                    placeholder="worker Email"/>
            </div>
        </div>
        <!-- End worker email filed -->


    

        <!-- Start hide Field -->
        
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> حالة الحساب </label>
            <div class="col-sm-10 col-md-4">

                <select  name="active" class="form-control">
                        <option selected value="1">مفعل</option>
                        <option value="0">غير مفعل</option>
                </select>
            </div>
        </div>


        <!-- End hide  Field -->



        <!-- Start Save Button filed -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="Submit" value="اضافة العامل " class="btn btn-primary btn-lg" />
            </div>
        </div>
        <!-- End Save Button filed -->

    </form>
</div>
</section>



<?php 

        }elseif ($do == 'Insert'){

            // Insert worker page

            

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo "<h1 class='text-center'>Add worker </h1>";
            echo "<div class='container'>";

                // Upload Variables 


                // Get the variables from the form

                $username                           = $_POST['username'];
                $password                           = $_POST['password'];
                $name                               = $_POST['name'];
                $idnumber                           = $_POST['idnumber'];
                $location                           = $_POST['location'];
                $email                              = $_POST['email'];
                $position                           = $_POST['position'];
                $mealprice                          = $_POST['mealprice'];
                $cardnumber                         = $_POST['cardnumber'];
                $phonenumber                        = $_POST['phonenumber'];
                $insnumber                          = $_POST['insnumber'];
                $company                            = $_POST['company'];
                $active                             = $_POST['active'];
                $daysoffremain                      = $_POST['daysoffremain'];
                $voted                              = 0;

                // $avatar     = $_FILES['avatar'];

                if(isset($_FILES['image']) && $_FILES['image']['size'] > 0){

                
                    $imageName          = $_FILES['image']['name'];
                    $imageSize          = $_FILES['image']['size'];
                    $imageTmp           = $_FILES['image']['tmp_name'];
                    $imageType          = $_FILES['image']['type'];

                    // List of allowed files to be uploaded
                    $imageAllowedExtension = array("jpeg", "jpg", "png", "gif","webp");

                    // Get avatar Extension
                    $var= explode('.', $imageName);
                    $imageExtension = strtolower(end($var));

                }

                // validate the FORM
                $formERRORS = array();

                // if (empty($username)) {
                //     $formERRORS[] = '<div class="alert alert-danger"> Name is Empty</div>';
                // }
                // if (empty($password)) {
                //     $formERRORS[] = '<div class="alert alert-danger">Price Is Empty</div>';
                // }
                // if (empty($name)) {
                //     $formERRORS[] = '<div class="alert alert-danger">description Is Empty</div>';
                // }
                    
                // if (empty($idnumber)) {
                //     $formERRORS[] = '<div class="alert alert-danger">words Is Empty</div>';
                // }
                // if (empty($location)) {
                //     $formERRORS[] = '<div class="alert alert-danger">Sold Number Empty</div>';
                // }


                // if (empty($position)) {
                //     $formERRORS[] = '<div class="alert alert-danger">description Is Empty</div>';
                // }
                    
                // if (empty($cardnumber)) {
                //     $formERRORS[] = '<div class="alert alert-danger">words Is Empty</div>';
                // }
                // if (empty($phonenumber)) {
                //     $formERRORS[] = '<div class="alert alert-danger">Sold Number Empty</div>';
                // }

                // if (empty($insnumber)) {
                //     $formERRORS[] = '<div class="alert alert-danger">description Is Empty</div>';
                // }
                    
                // if (empty($company)) {
                //     $formERRORS[] = '<div class="alert alert-danger">words Is Empty</div>';
                // }
                

                // if (empty($active) && $active != 0) {
                //     $formERRORS[] = '<div class="alert alert-danger"> sub_cat_id Is Empty</div>';
                // }

                // if (empty($voted) && $voted != 0) {
                //     $formERRORS[] = '<div class="alert alert-danger"> sub_cat_id Is Empty</div>';
                // }
                
                if(isset($_FILES['image']) && $_FILES['image']['size'] > 0){
    
                    if (! empty($imageName) && ! in_Array($imageExtension, $imageAllowedExtension)) {
                        $formERRORS[] = '<div class="alert alert-danger">Image Extension Is Forbidden  </div>';
                    }
                    if ($imageSize > 10194304) {
                        $formERRORS[] = '<div class="alert alert-danger"> Image Is So large try smaller one  </div>';
                    }

                }



                $check = checkItem("idnumber","workers", $idnumber);

                if ($check ==1){
                    $formERRORS[] = "<div class='alert alert-danger'> هذا العامل موجود بالفعل</div> ";
                }



                // loop into errors Array And Echo It
                foreach ($formERRORS as $error) {
                    echo $error;
                }
    

                // check if there is no error Update the database

                if(empty($formERRORS)){
                    if(isset($_FILES['image']) && $_FILES['image']['size'] > 0){
                    if (!empty($imageName)) {
                        $image = rand(0, 100000) . '_' . $imageName;
                            move_uploaded_file($imageTmp, "../workers/" . $image);


                    }
                }
                    //Insert User Info in data base

                if(isset($_FILES['image']) && $_FILES['image']['size'] > 0){

                    $stmt = $con->prepare("INSERT
                                                INTO workers
                                                ( username,
                                                password,
                                                name,
                                                idnumber,
                                                location,
                                                email,
                                                position,
                                                cardnumber,
                                                phonenumber,
                                                insnumber,
                                                company,
                                                mealprice,
                                                image,
                                                active,
                                                voted,
                                                daysoffremain
                                                
                                                
                                                )
                                VALUES (:zusername,:zpassword,:zname,:zidnumber,:zlocation,:zemail,:zposition,:zcardnumber,:zphonenumber,:zinsnumber,:zcompany,:zmealprice,:zimage,:zactive,:zvoted,:zdaysoffremain)");
                $stmt->execute(array(
                            'zusername'                     =>$username,
                            'zpassword'                     =>$password,
                            'zname'                         =>$name,
                            'zidnumber'                     =>$idnumber,
                            'zlocation'                     =>$location,
                            'zemail'                        =>$email,
                            'zposition'                     =>$position,
                            'zcardnumber'                   =>$cardnumber,
                            'zphonenumber'                  =>$phonenumber,
                            'zinsnumber'                    =>$insnumber,
                            'zcompany'                      =>$company,
                            'zmealprice'                    =>$mealprice,
                            'zimage'                        =>$image,
                            'zactive'                       =>$active,
                            'zvoted'                        =>$voted,
                            'zdaysoffremain'                =>$daysoffremain
                            

                        ));

                //echo succes message
                echo '
                                <script>
                                    window.location= "workers.php?do=add";
                                </script>
                            ';
                    }

                else{
                    $stmt = $con->prepare("INSERT
                                                INTO workers
                                                ( username,
                                                password,
                                                name,
                                                idnumber,
                                                location,
                                                position,
                                                cardnumber,
                                                phonenumber,
                                                insnumber,
                                                company,
                                                mealprice,
                                                email,
                                                active,
                                                voted,
                                                daysoffremain
                                                
                                                
                                                )
                                VALUES (:zusername,:zpassword,:zname,:zidnumber,:zlocation,:zposition,:zcardnumber,:zphonenumber,:zinsnumber,:zcompany,:zmealprice,:zemail,:zactive,:zvoted,:zdaysoffremain)");
                $stmt->execute(array(
                            'zusername'                     =>$username,
                            'zpassword'                     =>$password,
                            'zname'                         =>$name,
                            'zidnumber'                     =>$idnumber,
                            'zlocation'                     =>$location,
                            'zemail'                        =>$email,
                            'zposition'                     =>$position,
                            'zcardnumber'                   =>$cardnumber,
                            'zphonenumber'                  =>$phonenumber,
                            'zinsnumber'                    =>$insnumber,
                            'zcompany'                       =>$company,
                            'zmealprice'                    =>$mealprice,
                            'zactive'                       =>$active,
                            'zvoted'                        =>$voted,
                            'zdaysoffremain'                =>$daysoffremain

                            

                        ));

                //echo succes message
                echo '
                                <script>
                                    window.location= "workers.php?do=add";
                                </script>
                            ';
                    }
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

            $workerid = isset($_GET['workerId']) && is_numeric($_GET['workerId'] ) ?intval ($_GET['workerId']): 0 ;
            // select all data depend on this id 
            $stmt = $con->prepare("SELECT * FROM workers WHERE id = ?  LIMIT 1");

            // excure query
            $stmt->execute(array($workerid));

            // bring the data

            $row = $stmt->fetch();

            // The Row count

            $count = $stmt->rowCount();

            // if there is such id show the form

            if($count > 0) { ?>


<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    
        <form class="form-horizontal" action="?do=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="workerId" value="<?php echo $workerid; ?>" />

        <!-- Start worker Username filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> اسم تسجيل الدخول  </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['username']; ?>" type="text" name="username" class="form-control"
                    placeholder="use to login" />

            </div>
        </div>


        <!-- End worker Username filed -->





        <!-- Start worker password filed -->


        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> كلمة المرور </label>
            <div class="col-sm-10 col-md-4">

        <input id="generatehere2" value="<?php echo $row['password']; ?>"  type="password" name="password" class="form-control" 
                    placeholder="password"  />

                    <input class="show-password-input" type="checkbox" onclick="ShowPassword()">Show Password

                <script>
                    function ShowPassword() {
                        var x = document.getElementById("generatehere2");
                        if (x.type === "password") {
                            x.type = "text";
                        } else {
                            x.type = "password";
                        }
                        }
                        </script>
            </div>
        </div>
        <!-- End worker password filed -->




        <!-- Start worker Description filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> اسم العامل </label>
            <div class="col-sm-10 col-md-4">
            <input type="text" value="<?php echo $row['name']; ?>" name="name" class="form-control" 
                    placeholder="show in profile"  />
            </div>
        </div>
        <!-- End worker Description filed -->




        

        <!-- Start worker position filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span>  الوظيفة </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['position'] ?>" type="text" name="position" class="form-control" 
                    placeholder="وظيفة العامل"  />
            </div>
        </div>

        <!-- End worker position filed -->


        <!-- Start worker card number filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> رقم البطاقة </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['cardnumber'] ?>" type="number" name="cardnumber" class="form-control" 
                    placeholder="رقم البطاقة"  />
            </div>
        </div>

        <!-- End worker card number filed -->



        <!-- Start worker phonenumber filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> رقم الهاتف </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['phonenumber'] ?>" type="number" name="phonenumber" class="form-control" 
                    placeholder="رقم الهاتف"  />
            </div>
        </div>

        <!-- End worker phonenumber filed -->


        <!-- Start worker insnumber filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> رقم التامين </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['insnumber'] ?>" type="number" name="insnumber" class="form-control" 
                    placeholder="رقم التامين"  />
            </div>
        </div>

        <!-- End worker insnumber filed -->



        <!-- Start worker mealprice filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span>  سعر الوجبة </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['mealprice'] ?>" type="number" name="mealprice" class="form-control" 
                    placeholder=" سعر الوجبة"  />
            </div>
        </div>

        <!-- End worker mealprice filed -->


        <!-- Start worker company filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span> اسم الشركة</label>
            <div class="col-sm-10 col-md-4">
        <select id="select-company"  required='required' name="company" class="form-control">
            <option value=""> اختر الشركة</option>
            <?php 
                foreach($companies as $company){
                    if($company['id'] == $row['company']){
                        echo '<option selected value="'.$company['id'].'"> '. $company['name'] .' </option>';
                    }else{
                        echo '<option value="'.$company['id'].'"> '. $company['name'] .' </option>';
                    }
                    
                }
            ?>
        </select>

        </div>
        </div>

        <script src="layout/js/jquery-1.12.1.min.js"></script>
        

        <!-- End worker compay filed -->



        <!-- Start worker daysoffremain filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span>  رصيد الاجازات </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['daysoffremain'] ?>" type="number" name="daysoffremain" class="form-control" 
                    placeholder="رصيد الاجازات"  />
            </div>
        </div>

        <!-- End worker daysoffremain filed -->



        <!-- Start worker Location filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span> الموقع  </label>
            <div class="col-sm-10 col-md-4">
            <select id="select-fields"  required='required' name="location" class="form-control">
                <?php 
                    foreach($fields as $field){
                        if($field['id'] == $row['location']){
                            echo '<option selected value="'. $field['id'] .'"> '. $field['name'] .' </option>';
                        }else{
                            echo '<option value="'. $field['id'] .'"> '. $field['name'] .' </option>';

                        }
                    }
                ?>
            

        
            <script>
            $("#select-company").click(function(){
                
                    let xhr = new XMLHttpRequest();
                    if($(this).val() !== "" || $(this).val() != null){
                    xhr.open("GET", "get-fields.php?companyid=" + $(this).val(), true);
                    
                    xhr.onload = () => {
                        if (xhr.readyState == XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {

                                
                                let data = xhr.response;
                                $('#select-fields').empty().append(`<option value=""> اختر الشركة</option>`);
                                $('#select-fields').append(`${data}`);
                                data = [];
                            
                            
                            }
                        }
                    }
                    

                    xhr.send();
                    }
            })

        </script>
                
            </select>

                    
            </div>
        </div>
        <!-- End worker Location filed -->

        

        <!-- Start worker number filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> <span style="color:red;" >*</span>  رقم العامل</label>
            <div class="col-sm-10 col-md-4">
                <input type="number" value="<?php echo $row['idnumber']; ?>" name="idnumber" class="form-control" 
                    placeholder="Worker number" />
            </div>
        </div>

        <!-- End worker number filed -->



        <!-- Start worker Image filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">صورة العامل </label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="image"  class="form-control" 
                    placeholder="worker Image"/>
            </div>
        </div>
        <!-- End worker Image filed -->


        <!-- Start worker email filed -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">worker Email</label>
            <div class="col-sm-10 col-md-4">
                <input type="email" value="<?php echo $row['email']; ?>" name="email" class="form-control" 
                    placeholder="worker Email"/>
            </div>
        </div>
        <!-- End worker email filed -->


    

        <!-- Start hide Field -->
        
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"><span style="color:red;" >*</span>  حالة الحساب  </label>
            <div class="col-sm-10 col-md-4">

                <select  name="active" class="form-control">
                    <?php 
                        if($row['active'] == 1){
                            echo '
                            <option selected value="1">activate</option>
                            <option value="0">deactivate</option>
                            ';
                        }else{
                            echo'
                            <option  value="1">activate</option>
                            <option selected value="0">deactivate</option>
                            ';
                            
                        }
                    ?>
                    
                </select>
            </div>
        </div>


        <!-- End hide  Field -->



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
            echo "<h1 class='text-center'> Update worker </h1>";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Get the variables from the form
                $workerid              = $_POST['workerId'];
                $username                           = $_POST['username'];
                $password                           = $_POST['password'];
                $name                               = $_POST['name'];
                $idnumber                           = $_POST['idnumber'];
                $location                           = $_POST['location'];
                $position                           = $_POST['position'];
                $cardnumber                         = $_POST['cardnumber'];
                $phonenumber                        = $_POST['phonenumber'];
                $insnumber                          = $_POST['insnumber'];
                $company                            = $_POST['company'];
                $mealprice                          = $_POST['mealprice'];
                $email                              = $_POST['email'];
                $active                             = $_POST['active'];
                $daysoffremain                      = $_POST['daysoffremain'];

                // $avatar     = $_FILES['avatar'];

                if(isset($_FILES['image']) && $_FILES['image']['size'] > 0){

                
                    $imageName          = $_FILES['image']['name'];
                    $imageSize          = $_FILES['image']['size'];
                    $imageTmp           = $_FILES['image']['tmp_name'];
                    $imageType          = $_FILES['image']['type'];

                    // List of allowed files to be uploaded
                    $imageAllowedExtension = array("jpeg", "jpg", "png", "gif","webp");

                    // Get avatar Extension
                    $var= explode('.', $imageName);
                    $imageExtension = strtolower(end($var));

                }

                // validate the FORM
                $formERRORS = array();

                // if (empty($username)) {
                //     $formERRORS[] = '<div class="alert alert-danger"> Name is Empty</div>';
                // }
                // if (empty($password)) {
                //     $formERRORS[] = '<div class="alert alert-danger">Price Is Empty</div>';
                // }
                // if (empty($name)) {
                //     $formERRORS[] = '<div class="alert alert-danger">description Is Empty</div>';
                // }
                    
                // if (empty($idnumber)) {
                //     $formERRORS[] = '<div class="alert alert-danger">words Is Empty</div>';
                // }
                // if (empty($location)) {
                //     $formERRORS[] = '<div class="alert alert-danger">Sold Number Empty</div>';
                // }

                // if (empty($position)) {
                //     $formERRORS[] = '<div class="alert alert-danger">description Is Empty</div>';
                // }
                    
                // if (empty($cardnumber)) {
                //     $formERRORS[] = '<div class="alert alert-danger">words Is Empty</div>';
                // }
                // if (empty($phonenumber)) {
                //     $formERRORS[] = '<div class="alert alert-danger">Sold Number Empty</div>';
                // }

                // if (empty($insnumber)) {
                //     $formERRORS[] = '<div class="alert alert-danger">description Is Empty</div>';
                // }
                    
                // if (empty($company)) {
                //     $formERRORS[] = '<div class="alert alert-danger">words Is Empty</div>';
                // }

                // if (empty($active) && $active != 0) {
                //     $formERRORS[] = '<div class="alert alert-danger"> sub_cat_id Is Empty</div>';
                // }

                
                if(isset($_FILES['image']) && $_FILES['image']['size'] > 0){
    
                    if (! empty($imageName) && ! in_Array($imageExtension, $imageAllowedExtension)) {
                        $formERRORS[] = '<div class="alert alert-danger">Image Extension Is Forbidden  </div>';
                    }
                    if ($imageSize > 10194304) {
                        $formERRORS[] = '<div class="alert alert-danger"> Image Is So large try smaller one  </div>';
                    }

                }



    
                // loop into errors Array And Echo It
                foreach ($formERRORS as $error) {
                    echo $error;
                }
    
                // check if there is no error Update the database

                if(empty($formERRORS)){
                    if(isset($_FILES['image']) && $_FILES['image']['size'] > 0){
                    if(isset($_FILES['image']) && $imageSize != 0){
                        if (!empty($imageName)) {
                            $image = rand(0, 100000) . '_' . $imageName;
                            
                                move_uploaded_file($imageTmp, "../workers/" . $image);

                        }
                }
            }

                //Update the database with this info



                if(isset($_FILES['image']) && $_FILES['image']['size'] > 0){
                $stmt = $con->prepare("UPDATE workers SET username=?, password=?, name= ?, idnumber= ?,position=?, cardnumber=?, phonenumber= ?, insnumber= ?, company= ?,mealprice =?,  location= ?,email = ?, image = ?,active = ?,daysoffremain =? WHERE id = ?");
                $stmt->execute(array($username, $password, $name, $idnumber,$position, $cardnumber, $phonenumber, $insnumber, $company,$mealprice, $location, $email,$image,$active,$workerid,$daysoffremain));

                //echo succes message
                
                echo '
                                <script>
                                    window.location= "workers.php";
                                </script>
                            ';
                }else{
                    $stmt = $con->prepare("UPDATE workers SET username=?, password=?, name= ?, idnumber= ?,position=?, cardnumber=?, phonenumber= ?, insnumber= ?, company= ?,mealprice =?,  location= ?,email = ?,active = ?,daysoffremain =? WHERE id = ?");
                    $stmt->execute(array($username, $password, $name, $idnumber,$position, $cardnumber, $phonenumber, $insnumber, $company,$mealprice, $location,$email,$active,$daysoffremain,$workerid));
    
                    //echo succes message
                    echo '
                                <script>
                                    window.location= "workers.php";
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

                        $workerid = isset($_GET['workerId']) && is_numeric($_GET['workerId'] ) ?intval ($_GET['workerId']): 0 ;
                        // select all data depend on this id 
                        $stmt = $con->prepare("SELECT * FROM workers WHERE id = ?  LIMIT 1");

                        // check if there is an id as sent or not 

                        $check = checkItem('id','workers', $workerid);
            
                        // if there is such id show the form
            
                    if($check > 0) { 
                        $stmt = $con->prepare("DELETE FROM workers WHERE id = :zworkerid");
                        $stmt->bindParam(":zworkerid" , $workerid);
                        $stmt->execute();
                        echo '
                                <script>
                                    window.location= "workers.php";
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

            $workerid = isset($_GET['workerId']) && is_numeric($_GET['workerId'] ) ?intval ($_GET['workerId']): 0 ;

            // select all data depend on this id 

            $stmt = $con->prepare("SELECT * FROM workers WHERE id = ?  LIMIT 1");

            // check if there is an id as sent or not 

            $check = checkItem('id','workers', $workerid);

            // if there is such id show the form

        if($check > 0) { 
            $stmt = $con->prepare("UPDATE workers SET active=1 Where id = ?");

            $stmt->execute(array($workerid));


            echo '
                                <script>
                                    window.location= "workers.php";
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