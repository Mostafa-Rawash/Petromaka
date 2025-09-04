<?php
    ob_start();

    session_start();

    $pageTitle = 'Profile';

    include 'init.php';

    if (isset($_SESSION['username'])) {

        $UserNameNow = $_SESSION['username'];
        $workers = getAllFrom("*","workers","where idnumber = '$UserNameNow'","","id","");
        $fields = getAllFrom("*","fields","","","id","");
        $companies = getAllFrom("*","company","","","id","");
        $mealprice = 0;
        foreach($workers as $worker){
            $mealprice =intval($worker['mealprice']);
        }
    }

    if($_SERVER ['REQUEST_METHOD'] =='POST'){
        if (isset($_POST['update-image'])) {
            $useriddd = $_SESSION['ID'];
            // $image     = $_FILES['image'];
            $imageName = $_FILES['image']['name'];
            $imageSize = $_FILES['image']['size'];
            $imageTmp  = $_FILES['image']['tmp_name'];
            $imageType = $_FILES['image']['type'];

            // List of allowed files to be uploaded
            $imageAllowedExtension = array("jpeg", "jpg", "png", "gif");
            // Get image Extension
            $varrr= explode('.', $imageName);
            $imageExtension = strtolower(end($varrr));

            if (isset($imageName)) {
                if (! empty($imageName) && ! in_Array($imageExtension, $imageAllowedExtension)) {
                    $formERRORS[] = '<div class="alert alert-danger">This Extension is not <strong>Allowed</strong></div>';
                }
                if ($imageSize > 5194304) {
                    $formERRORS[] = '<div class="alert alert-danger">Profile photo can not be larger than <strong> 5MB </strong></div>';
                }
            }


            if (empty($formERRORS)) {
                if (!empty($imageName)) {
                    $image = rand(0, 100000) . '_' . $imageName;
                    move_uploaded_file($imageTmp, "workers/" . $image);
                }
                //Update User photo in data base

                if ($info['img'] != 'default.jpg') {
                    unlink('workers/'. $info['img']);
                }

                $stmt = $con->prepare("UPDATE 
                                    workers 
                                SET
                                    image =?
                                WHERE 
                                    id = ?");
                $stmt->execute(array($image, $useriddd));

                //Echo succes message
                header("Refresh:0");
            }
        }
            
        
    }

    if(isset($_SESSION['username'])){


    ?>
    <!-- Start Pop for user profile photo -->

    <?php 
        foreach($workers as $worker){
            echo '
            <div class="popup popuppopup" id="popup-1">
        <div class="overlay"></div>
        <div class="contentt">
            <div  class="close-btn"><i id="close-edit-photo-popup" class="fa fa-close"></i></div>
            <h1>Edit Photo</h1>
            <div class="wrapper">
                <div class="image">
                    <img src="workers/'. $worker['image'] .' " alt="">
                </div>
                <div class="content-2">
                    <div class="icon"><i class="fa fa-cloud-upload" aria-hidden="true"></i></div>
                    <div class="text">No File Choosen , yet !</div>
                </div>
                <div id="cancel-btn"><i class="fa fa-times"></i></div>
                <div class="file-name">File name here</i></div>

            </div>
            <form action="'.$_SERVER['PHP_SELF'] .'" method="POST" enctype="multipart/form-data">
                <input name="image" id="default-btn" type="file" hidden>
                <label onclick = "defaultBtnAction()" id="custome-btn">Choose a File</label>
                <button name="update-image" class="save-btn" type="submit">Save</button>
            </form>
        </div>
        </div>
            ';
        }
    
    ?>
        
        <!-- End pop Up -->

        <?php 

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['update-user-info'])) {

                // Get the variables from the form

                    $id = $_SESSION['ID'];
                    $email = $_POST['email'];


                    $email = htmlspecialchars_decode(trim($email));
                    // password Trick

                    // condition ? true : false;
                    $pass = empty($_POST['newpassword']) ?  $_POST['oldpassword'] : $_POST['newpassword'];

                    $pass = htmlspecialchars_decode(trim($pass));
                    
                    // validate the FORM
                    $formERRORS = array();

                    if(isset($email))
                    {
                        $filterdemail= filter_var($email, FILTER_SANITIZE_EMAIL);
                        $email = $filterdemail;

                    }

                    if (empty($email)) {
                        $formERRORS[] = '<div class="alert alert-danger">Email cant be EMpty</div>';
                    }

                    // loop into errors Array And Echo It

                    foreach ($formERRORS as $error) {
                        echo $error;
                    }

                    // check if there is no error Update the database

                    if (empty($formERRORS)) {

                    
                //Update the database with this info

                        $stmt = $con->prepare("UPDATE workers SET email=?, password= ?  WHERE id = $id");
                        $stmt->execute(array( $email, $pass));

                        //echo succes message

                        $theMsg =  "";

                        header("Refresh:0");
                    }
                }
            }


            


        
        ?>


        <!-- Start Pop for user profile info -->

        <?php 
        foreach($workers as $worker){

            echo '
            <div class="popup popuppopup" id="popup-2">
            <div class="overlay"></div>
            <div class="contentt">
                <div  class="close-btn"><i id="edit-user-info-close" class="fa fa-close"></i></div>
                <h1>Edit User Settings</h1>
                <form class="user-settings-edit-form" action="'.$_SERVER['PHP_SELF'].'" method="POST" enctype="multipart/form-data">
                
                    <label>Edit Password</label>
                    <input type="hidden" name="oldpassword" value="'. $worker['password'] .'" />
                    <input type="password" name="newpassword" class="form-control" autocomplete="new-password"
                        placeholder="Leave Blank if you don\'t want to change" /> 
                    <label>Edit Email</label>
                    <input name="email" type="email" value="'. $worker['email'] .'"> 
                    <button name="update-user-info"  class="save-user-info" type="submit">Save</buttonn>
                </form>
            </div>
            </div>
            ';
        }

        ?>
        
        <!-- End pop Up -->

        <?php 
        foreach($workers as $worker){

            $fieldname = "";
            $companyname = "";

            
            foreach($fields as $field){
                if($field['id'] == $worker['location']){
                    $fieldname .= $field['name'];
                }
            }

            foreach($companies as $company){
                if($company['id'] == $worker['company']){
                    $companyname .= $company['name'];
                }
            }



            echo'
            <div class="profile-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-sm-12">
                    <div class="profile-settings">
                        <a class="back-home" href="index.php"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
                        <div class="user-photo">
                            <img src="workers/'.$worker['image'].'" alt="my photo">
                            <a id="edit-photo-popup" class="edit-photo"><i class="fa fa-camera" aria-hidden="true"></i></a>
                            

                        </div>

                        
                        <div class="user-info">
                            <h2>'.$worker['name'].'</h2>
                            <h5>'.$worker['email'].'</h5>
                        

                            <button class="worker-details-down">   <i class="fa-solid fa-chevron-down"></i>   معلومات الموظف</button>

                            <ul class="worker-details">
                                <li>
                                    <h2 style="color:#bd9100" >'.$worker['idnumber'].'</h2> : رقم العامل 
                                </li>

                                <li>
                                    <h2 style="color:#bd9100" >'.$worker['position'].'</h2> : الوظيفة  
                                </li>

                                <li>
                                    <h2 style="color:#bd9100" >'.$worker['cardnumber'].'</h2> : رقم البطاقة  
                                </li>

                                <li>
                                    <h2 style="color:#bd9100" >'.$worker['phonenumber'].'</h2> : رقم الهاتف  
                                </li>


                                <li>
                                    <h2 style="color:#bd9100" >'.$worker['insnumber'].'</h2> :  الرقم التاميني  
                                </li>

                                <li>
                                    <h2 style="color:#bd9100" >'. $companyname.'</h2> : الشركة  
                                </li>

                                <li>
                                    <h2 style="color:#bd9100" >'.$fieldname.'</h2> : الموقع  
                                </li>

                                <li>
                                <h2 style="color:#bd9100" >'.$worker['daysoffremain'].'</h2> :  رصيد الاجازات  
                            </li>
                            </ul>
                        </div>





                        <div class="settings">
                            <a id="edit-user-info-open"><i class="fa fa-cog" aria-hidden="true"></i> الاعدادات</a>
                            <a href="#"><i class="fa fa-info" aria-hidden="true"></i> الاحداث</a>
                            <a href="#"><i class="fa fa-question" aria-hidden="true"></i> الاسالة</a>
                            <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحة الرئيسية</a>
                            <a href="Logout.php"><i class="fa-solid fa-power-off"></i>  تسجيل الخروج</a>

                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-sm-12">
                    <div  class="top">
                        <h1>بيان المرتبات</h1>

                        
                                ';

                                $WorkerID = $worker['id'];

                                $salaries = getAllFrom("*","salaries","where workerid = $WorkerID ","","id","DESC");
                                foreach($salaries as $salary){

                                    $salaryf = intval($salary['salary']);
                                    $transportation = intval($salary['transportation']);
                                    $nightshift = intval($salary['nightshift']);
                                    $loans = intval($salary['loans']);
                                    $others = intval($salary['others']);
                                    $discounts =intval($salary['discounts']);
                                    
                                    $eatnumber =intval($salary['eatnumber']);
                                    echo '
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="salary-table">
                                        <div class="header">
                                            <h1><span class="year">'. $salary['year'] .'</span> <span class="month">'. $salary['month'] .'</span></h1>
        
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </div>
        
                                        <div class="tables">


                                        <div>
                                            <table>
                                            <tr>
                                        <td>عدد ايام العمل</td>
                                        <td>'. $salary['workdays'] .'</td>
                                    </tr>
                                    <tr>
                                        <td> الساعات الاضافية</td>
                                        <td>'. $salary['addhours'] .'</td>
                                    </tr>
                                    <tr>
                                        <td>عدد الوجبات</td>
                                        <td>'. $salary['eatnumber'] .'</td>
                                    </tr>

                                    <tr>
                                        <td>  عدد ايام الاجازات  </td>
                                        <td>'. $salary['offdays'] .'</td>
                                    </tr>

                                    <tr>
                                    <td>  سعر الوجبة </td>
                                    <td>'. $mealprice .'</td>
                                </tr>
                                            </table>
                                        
                                        </div>



                                        <div>

                                        <table>
                                        <tr>
                                            <th colspan="2">المستحقات</th>
                                            
                                        </tr>
                                        <tr>
                                            <th> البيان </th>
                                            <th> المبلغ </th>
                                        </tr>
                                        <tr>
                                            <td>المرتب</td>
                                            <td>'. $salary['salary'] .'</td>
                                        </tr>
                                        <tr>
                                            <td>بدل الانتقال</td>
                                            <td>'. $salary['transportation'] .'</td>
                                        </tr>
                                        <tr>
                                            <td>بدل السهر</td>
                                            <td>'. $salary['nightshift'] .'</td>
                                        </tr>

                                        <tr>
                                            <td>بدل وجبات</td>
                                            <td>'. ($eatnumber * $mealprice) .'</td>
                                        </tr>

                                        <tr>
                                            <td>اجمالي المستحقات</td>
                                            <td>'. ($salaryf + $transportation + $nightshift + ($eatnumber * $mealprice)) .'</td>
                                        </tr>
                                        <tr>
                                        <th> البيان </th>
                                        <th> المبلغ </th>
                                    </tr>
                                    
    
                                        <tr class="total-salary">
                                            <td> صافي الأجر</td>
                                            <td>'. (($salaryf + $transportation + $nightshift + ($eatnumber * $mealprice)) - ($others + $loans + $discounts)) .'</td>
                                        </tr>
                                    </table>
    
                                    <table>
                                        <tr>
                                            <th colspan="2">الأستقطاعات</th>
                                            
                                        </tr>
                                        <tr>
                                            <th> البيان </th>
                                            <th> المبلغ </th>
                                        </tr>
                                        <tr>
                                            <td>خصومات</td>
                                            <td>'. $salary['discounts'] .'</td>
                                        </tr>
                                        <tr>
                                            <td>سداد قرض</td>
                                            <td>'. $salary['loans'] .'</td>
                                        </tr>
                                        <tr>
                                            <td>اخرى</td>
                                            <td>'. $salary['others'] .'</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>اجمالي الأستقطاعات</td>
                                            <td>'. ($others + $loans + $discounts) .'</td>
                                        </tr>


                                    </table>


                                    </div>
                                    </div>
                                    </div>
                        </div>
    
                                    
                                    ';
                                }
                                
                                echo '
                            
                        
                    </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
            
            ';
        }
        ?>

    







    <?php

    }else{
        header('Location: login.php');
        exit();
    }
?>
    <script src="layout/js/profile-page.js"></script>

<?php
    include  $tpl ."footer.php";
    ob_end_flush();

?>