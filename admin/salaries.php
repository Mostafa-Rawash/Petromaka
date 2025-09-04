<?php

    // Manage salaries page 
    // you can Add | Edit | Delete salaries From Here

    session_start();

    $pageTitle = ' تعديل واضافة المرتبات ';

    if(isset($_SESSION['UserName'])){
        include 'init.php';

        $do = isset($_GET['do'])? $_GET['do']:'manage-salaries';

        // Start Manage salaries Page

        if($do == 'manage-salaries'){ // manage salaries page 

            

            // select all salaries 
            
        $MonthNow =  date('F', strtotime("-1 month"));
        $stmt = $con->prepare("SELECT * FROM salaries where month = '$MonthNow' and year = date('Y') ORDER BY id DESC");
        $stmt2 = $con->prepare("SELECT * FROM workers  ORDER BY name ASC");
        $stmt3 = $con->prepare("SELECT * FROM  salaries where month != '$MonthNow'  ORDER BY id DESC");

        // execute to the statment
        $stmt->execute();
        $stmt2->execute();
        $stmt3->execute();

        // assign data come to a variable

        $salaries = $stmt->fetchAll();
        $workers = $stmt2->fetchAll();
        $salariesold = $stmt3->fetchAll();

        if(! empty ($salaries) || ! empty ($salariesold) ){
        
        
        ?>

<!-- <h1 class="text-center"> Manage salaries</h1> -->
<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>

<div class="board">
<div class="add-new-user">
        <a href="salaries.php?do=add" class="new-memeber-btn"><i class="fa fa-plus"></i>  اضافة جديد </a>
        </div>
            <table width="100%">
                <thead>
                    <tr>
                        <td>اسم العامل</td>
                        <td>رقم العامل</td>
                        <td> المرتب  </td>
                        <td> صافي الاجر </td>
                        <td></td>
                    </tr>
                </thead>
                <tbody id="salriestablebody">

                <tr><td colspan="4"> <h1 style="    text-align: center;
    font-weight: 700;
    font-size: 22px;
    margin-top: 35px;
    margin-bottom: 30px;">رواتب التاريخ الحالي</h1></td></tr>

                <?php if(! empty($salaries)){
                    foreach($salaries as $salary){
                    ?>
                    <tr>

                    <?php

                    foreach($workers as $worker){

                        if($salary['workerid'] == $worker['id']){
                            echo'
                            <td class="people-dec">
                            <h5> '. $worker['name'] .'</h5>
                        </td>
                            ';
                        }
                    }

                    ?>


            <?php

                    foreach($workers as $worker){

                        if($salary['workerid'] == $worker['id']){
                            echo'
                            <td class="people-dec">
                            <h5> '. $worker['idnumber'] .'</h5>
                        </td>
                            ';
                        }
                    }

                    ?>

                        
                        <td class="people-dec">
                            <h5><?php echo $salary['salary']; ?></h5>
                        </td>


                        <td class="people-dec">
                            <h5><?php echo ( (intval($salary['salary']) + intval($salary['transportation']) + intval($salary['nightshift']))  -   (intval($salary['discounts']) + intval($salary['loans']) + intval($salary['others']))) ; ?></h5>
                        </td>

                        <td class="edit">
                            <?php echo "  <a href='salaries.php?do=edit&salaryId=" . $salary['id'] . "' class='edit-btn'><i class='fa fa-edit'></i> Edit </a>
                                <a href='salaries.php?do=Delete&salaryId=" . $salary['id'] . "' class='delete-btn confirm'><i class='fa fa-close'></i> Delete </a>";
                                
                                    ?>
                        </td>

                    </tr>
                    
                <?php 
                }
            }
            ?>
        <tr> <td colspan="4"> <h1 style="    text-align: center;
    font-weight: 700;
    font-size: 22px;
    margin-top: 35px;
    margin-bottom: 30px;">رواتب التواريخ السابقة </h1></td></tr>
            
        <?php if(! empty($salariesold)){
                    foreach($salariesold as $salary){
                    ?>
                    <tr>

                    <?php

                    foreach($workers as $worker){

                        if($salary['workerid'] == $worker['id']){
                            echo'
                            <td class="people-dec">
                            <h5> '. $worker['name'] .'</h5>
                        </td>
                            ';
                        }
                    }

                    ?>

                    <?php

                    foreach($workers as $worker){

                        if($salary['workerid'] == $worker['id']){
                            echo'
                            <td class="people-dec">
                            <h5> '. $worker['idnumber'] .'</h5>
                        </td>
                            ';
                        }
                    }

                    ?>

                        
                        <td class="people-dec">
                            <h5><?php echo $salary['salary']; ?></h5>
                        </td>


                        <td class="people-dec">
                            <h5><?php echo ( (intval($salary['salary']) + intval($salary['transportation']) + intval($salary['nightshift']))  -   (intval($salary['discounts']) + intval($salary['loans']) + intval($salary['others']))) ; ?></h5>
                        </td>

                        <td class="edit">
                            <?php echo "  <a href='salaries.php?do=edit&salaryId=" . $salary['id'] . "' class='edit-btn'><i class='fa fa-edit'></i> Edit </a>
                                <a href='salaries.php?do=Delete&salaryId=" . $salary['id'] . "' class='delete-btn confirm'><i class='fa fa-close'></i> Delete </a>";
                                
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
                    xhr.open("GET", "searchsalaries.php?search=" + $('#searchINput').val(), true);
                    
                    xhr.onload = () => {
                        if (xhr.readyState == XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {

                                
                                let data = xhr.response;
                                $('#salriestablebody').empty().append(`${data}`);
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
                    xhr.open("GET", "searchsalaries.php?search=" + $('#searchINput').val(), true);
                    
                    xhr.onload = () => {
                        if (xhr.readyState == XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {

                                
                                let data = xhr.response;
                                $('#salriestablebody').empty().append(`${data}`);
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
                echo '<div class="nice-message"> لا توجد بيانات لعرضها</div>';
                echo ' <a href="salaries.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> اضافة مرتب جديد </a>';
                echo '</div>';
            }?>







<?php } elseif ($do == 'add'){?>
<!--  Add salaries page -->

<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">



        <!-- Start MainCategory Name filed -->
        <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">  اسم العامل </label>
                <div class="col-sm-10 col-md-4">
                

                        <select name="workerid" class="form-control" >
                            <option value="">اختر العامل</option>
                            <?php
                             $workers = getAllFrom("*","workers","","","name","ASC");
                                foreach( $workers as $worker){
                                    echo '<option value="'.$worker['id'].'">'.$worker['name'].'</option>';
                                }
                            
                            ?>
                        </select>

                </div>
            </div>
            <!-- End MainCategory Name filed -->



        <!-- Start discounts filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">  الخصومات </label>
            <div class="col-sm-10 col-md-4">
                <input type="number"  value="0" name="discounts" class="form-control"
                    placeholder="الخصومات" />

            </div>
        </div>

        <!-- End discounts filed -->


        <!-- Start loans filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">  سداد القروض </label>
            <div class="col-sm-10 col-md-4">
                <input type="number" value="0" name="loans" class="form-control" 
                    placeholder=" سداد القروض " />

            </div>
        </div>

        <!-- End loans filed -->


        <!-- Start others filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">   اخرى </label>
            <div class="col-sm-10 col-md-4">
                <input type="number" value="0" name="others" class="form-control"
                    placeholder="اخرى" />

            </div>
        </div>

        <!-- End others filed -->


        
        <!-- Start salary filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">   المرتب </label>
            <div class="col-sm-10 col-md-4">
                <input type="number" name="salary" class="form-control" 
                    placeholder=" المرتب " />

            </div>
        </div>

        <!-- End salary filed -->


        <!-- Start workdays filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> ايام العمل </label>
            <div class="col-sm-10 col-md-4">
                <input type="number" name="workdays" class="form-control" 
                    placeholder=" ايام العمل  " />

            </div>
        </div>

        <!-- End workdays filed -->

        <!-- Start  addhours filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">  ساعات اضافية </label>
            <div class="col-sm-10 col-md-4">
                <input type="number" name="addhours" class="form-control" 
                    placeholder="  ساعات اضافية  " />

            </div>
        </div>

        <!-- End addhours filed -->

        <!-- Start eatnumber filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">   عدد الوجبات </label>
            <div class="col-sm-10 col-md-4">
                <input type="number" name="eatnumber" class="form-control"
                    placeholder=" المرتب " />

            </div>
        </div>

        <!-- End eatnumber filed -->

        <!-- Start offdays filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">   عدد ايام الاجازات </label>
            <div class="col-sm-10 col-md-4">
                <input type="number" name="offdays" class="form-control"
                    placeholder="  عدد ايام الاجازات  " />

            </div>
        </div>

        <!-- End offdays filed -->


        <!-- Start transportation filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">   بدل الأنتقال </label>
            <div class="col-sm-10 col-md-4">
                <input type="number"  value="0" name="transportation" class="form-control"
                    placeholder=" بدل الأنتقال  " />

            </div>
        </div>

        <!-- End transportation filed -->


        <!-- Start nightshift filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">  بدل السهر  </label>
            <div class="col-sm-10 col-md-4">
                <input type="number"  value="0" name="nightshift" class="form-control"
                    placeholder=" بدل السهر  " />

            </div>
        </div>

        <!-- End nightshift filed -->


        <!-- Start year  filed -->
        <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">  اختر السنة </label>
                <div class="col-sm-10 col-md-4">
                

                        <select name="year" class="form-control" >

                            <option value="">اختر السنة</option>
                             <option value="2015"> 2015 </option>
                            <option value="2016"> 2016 </option>
                            <option value="2017"> 2017 </option>
                            <option value="2018"> 2018 </option>
                            <option value="2019"> 2019 </option>
                            <option value="2020"> 2020 </option>
                            <option value="2021"> 2021 </option>
                            <option value="2022"> 2022 </option>
                            <option value="2023"> 2023 </option>
                            <option value="2024"> 2024 </option>
                            <option value="2025"> 2025 </option>
                            <option value="2026"> 2026 </option>
                            <option value="2027"> 2027 </option>

                        </select>

                </div>
            </div>
            <!-- End year  filed -->


            <!-- Start month  filed -->
        <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">  اختر الشهر </label>
                <div class="col-sm-10 col-md-4">
                

                        <select name="month" class="form-control" >

                            <option value="">اختر السنة</option>
                            <option value="January"> يناير  </option>
                            <option value="February"> فبراير  </option>
                            <option value="March"> مارس  </option>
                            <option value="April"> أبريل  </option>
                            <option value="May"> مايو  </option>
                            <option value="June"> يونيو  </option>
                            <option value="July"> يوليو  </option>
                            <option value="August"> أغسطس  </option>
                            <option value="September"> سبتمبر </option>
                            <option value="October"> أكتوبر </option>
                            <option value="November "> نوفمبر </option>
                            <option value="December"> ديسمبر </option>

                        </select>

                </div>
            </div>
            <!-- End month  filed -->



    





        <!-- Start Save Button filed -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="Submit" value="Add salary" class="btn btn-primary btn-lg" />
            </div>
        </div>
        <!-- End Save Button filed -->

    </form>
</div>
</section>



<?php 

        }elseif ($do == 'Insert'){

            // Insert salary page

            

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo "<h1 class='text-center'> اضافة مرتب جديد </h1>";
            echo "<div class='container'>";

                // Upload Variables 


                // Get the variables from the form

                $discounts                      = $_POST['discounts'];
                $loans                          = $_POST['loans'];
                $others                         = $_POST['others'];
                $salary                         = $_POST['salary'];
                $transportation                 = $_POST['transportation'];
                $nightshift                     = $_POST['nightshift'];
                $workerid                       = $_POST['workerid'];
                $year                           = $_POST['year'];
                $month                          = $_POST['month'];
                $workdays                       = $_POST['workdays'];
                $addhours                       = $_POST['addhours'];
                $eatnumber                      = $_POST['eatnumber'];
                $offdays                        = $_POST['offdays'];
                
                // validate the FORM
                $formERRORS = array();

        
                
                // if (empty($salary)) {
                //     $formERRORS[] = '<div class="alert alert-danger"> salary is Empty</div>';
                // }
        

                
                // if (empty($workerid)) {
                //     $formERRORS[] = '<div class="alert alert-danger"> workerid is Empty</div>';
                // }

                // if (empty($year)) {
                //     $formERRORS[] = '<div class="alert alert-danger"> year is Empty</div>';
                // }

                // if (empty($month)) {
                //     $formERRORS[] = '<div class="alert alert-danger"> month is Empty</div>';
                // }

                
                // loop into errors Array And Echo It
                foreach ($formERRORS as $error) {
                    echo $error;
                }
    

                // check if there is no error Update the database

                if(empty($formERRORS)){
                    //Insert User Info in data base

                    $stmt = $con->prepare("INSERT
                                                INTO salaries
                                                ( discounts,
                                                loans,
                                                others,
                                                salary,
                                                transportation,
                                                nightshift,
                                                workerid,
                                                year,
                                                month,
                                                workdays,
                                                addhours,
                                                eatnumber,
                                                offdays
                                                )
                                VALUES (:zdiscounts,:zloans,:zothers,:zsalary,:ztransportation,:znightshift,:zworkerid,:zyear,:zmonth,:zworkdays,:zaddhours,:zeatnumber,:zoffdays)");
                $stmt->execute(array(
                            'zdiscounts'            => $discounts,
                            'zloans'                => $loans,
                            'zothers'               => $others,
                            'zsalary'               => $salary,
                            'ztransportation'       => $transportation,
                            'znightshift'           => $nightshift,
                            'zworkerid'             => $workerid,
                            'zyear'                 => $year,
                            'zmonth'                => $month,
                            'zworkdays'              => $workdays,
                            'zaddhours'              => $addhours,
                            'zeatnumber'             => $eatnumber,
                            'zoffdays'               => $offdays
                            

                        ));

                //echo succes message
                echo '
                                <script>
                                    window.location= "salaries.php";
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

            $salaryid = isset($_GET['salaryId']) && is_numeric($_GET['salaryId'] ) ?intval ($_GET['salaryId']): 0 ;
            // select all data depend on this id 
            $stmt = $con->prepare("SELECT * FROM salaries WHERE id = ?  LIMIT 1");

            // excure query
            $stmt->execute(array($salaryid));

            // bring the data

            $row = $stmt->fetch();

            // The Row count

            $count = $stmt->rowCount();

            // if there is such id show the form

            if($count > 0) { ?>


<section id="interface">
<?php include  $tpl.'second-navbar.php'; ?>
    
        <form class="form-horizontal" action="?do=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="salaryId" value="<?php echo $salaryid; ?>" />

        
        <!-- Start MainCategory Name filed -->
        <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">  اسم العامل </label>
                <div class="col-sm-10 col-md-4">
                

                        <select name="workerid" class="form-control">
                            <option value="">اختر العامل</option>
                            <?php

                            $workers = getAllFrom("*","workers","","","name","ASC");
                                foreach( $workers as $worker){
                                    if($worker['id'] == $row['workerid']){
                                        echo '<option selected value="'.$worker['id'].'">'.$worker['name'].'</option>';
                                    }else{
                                        echo '<option value="'.$worker['id'].'">'.$worker['name'].'</option>';
                                    }
                                    
                                }
                            
                            ?>
                        </select>

                </div>
            </div>
            <!-- End MainCategory Name filed -->



        <!-- Start discounts filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">  الخصومات </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['discounts']; ?>" type="number" name="discounts" class="form-control" 
                    placeholder="الخصومات" />

            </div>
        </div>

        <!-- End discounts filed -->


        <!-- Start loans filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">  سداد القروض </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['loans']; ?>" type="number" name="loans" class="form-control" 
                    placeholder=" سداد القروض " />

            </div>
        </div>

        <!-- End loans filed -->


        <!-- Start others filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">   اخرى </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['others']; ?>" type="number" name="others" class="form-control" 
                    placeholder="اخرى" />

            </div>
        </div>

        <!-- End others filed -->


        
        <!-- Start salary filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">   المرتب </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['salary']; ?>" type="number" name="salary" class="form-control"
                    placeholder=" المرتب " />

            </div>
        </div>

        <!-- End salary filed -->


        <!-- Start transportation filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">   بدل الأنتقال </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['transportation']; ?>" type="number" name="transportation" class="form-control" 
                    placeholder=" بدل الأنتقال  " />

            </div>
        </div>

        <!-- End transportation filed -->


        <!-- Start nightshift filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">  بدل السهر  </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['nightshift']; ?>" type="number" name="nightshift" class="form-control" 
                    placeholder=" بدل السهر  " />

            </div>
        </div>

        <!-- End nightshift filed -->


        <!-- Start year  filed -->
        <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">  اختر السنة </label>
                <div class="col-sm-10 col-md-4">
                

                        <select name="year" class="form-control">

                        
                            <option selected value="<?php echo $row['year']; ?>"> <?php echo $row['year']; ?></option>

                            <option value="">اختر السنة</option>
                            <option value="2015"> 2015 </option>
                            <option value="2016"> 2016 </option>
                            <option value="2017"> 2017 </option>
                            <option value="2018"> 2018 </option>
                            <option value="2019"> 2019 </option>
                            <option value="2020"> 2020 </option>
                            <option value="2021"> 2021 </option>
                            <option value="2022"> 2022 </option>
                            <option value="2023"> 2023 </option>
                            <option value="2024"> 2024 </option>
                            <option value="2025"> 2025 </option>
                            <option value="2026"> 2026 </option>
                            <option value="2027"> 2027 </option>

                        </select>

                </div>
            </div>
            <!-- End year  filed -->


            <!-- Start month  filed -->
        <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">  اختر الشهر </label>
                <div class="col-sm-10 col-md-4">
                

                        <select name="month" class="form-control" >

                        <option selected value="<?php echo $row['month']; ?>"><?php echo $row['month']; ?> </option>

                            <option value="">اختر السنة</option>
                            <option value="January"> يناير  </option>
                            <option value="February"> فبراير  </option>
                            <option value="March"> مارس  </option>
                            <option value="April"> أبريل  </option>
                            <option value="May"> مايو  </option>
                            <option value="June"> يونيو  </option>
                            <option value="July"> يوليو  </option>
                            <option value="August"> أغسطس  </option>
                            <option value="September"> سبتمبر </option>
                            <option value="October"> أكتوبر </option>
                            <option value="November "> نوفمبر </option>
                            <option value="December"> ديسمبر </option>

                        </select>

                </div>
            </div>
            <!-- End month  filed -->



            

        <!-- Start workdays filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> ايام العمل </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['workdays']; ?>" type="number" name="workdays" class="form-control" 
                    placeholder=" ايام العمل  " />

            </div>
        </div>

        <!-- End workdays filed -->

        <!-- Start  addhours filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">  ساعات اضافية </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['addhours']; ?>" type="number" name="addhours" class="form-control" 
                    placeholder="  ساعات اضافية  " />

            </div>
        </div>

        <!-- End addhours filed -->

        <!-- Start eatnumber filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">   عدد الوجبات </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['eatnumber']; ?>" type="number" name="eatnumber" class="form-control"
                    placeholder=" المرتب " />

            </div>
        </div>

        <!-- End eatnumber filed -->

        <!-- Start offdays filed -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">    عدد ايام الاجازات </label>
            <div class="col-sm-10 col-md-4">
                <input value="<?php echo $row['offdays']; ?>" type="number" name="offdays" class="form-control" 
                    placeholder="  عدد ايام الاجازات  " />

            </div>
        </div>

        <!-- End offdays filed -->






    <!-- Start Save Button filed -->
    <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="Submit" value="Update" class="btn btn-primary btn-lg" />
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
            echo "<h1 class='text-center'> تعديل المرتب  </h1>";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Get the variables from the form
                $salaryid              = $_POST['salaryId'];
                $discounts                      = $_POST['discounts'];
                $loans                          = $_POST['loans'];
                $others                         = $_POST['others'];
                $salary                         = $_POST['salary'];
                $transportation                 = $_POST['transportation'];
                $nightshift                     = $_POST['nightshift'];
                $workerid                       = $_POST['workerid'];
                $year                           = $_POST['year'];
                $month                          = $_POST['month'];
                $workdays                       = $_POST['workdays'];
                $addhours                       = $_POST['addhours'];
                $eatnumber                      = $_POST['eatnumber'];
                $offdays                        = $_POST['offdays'];
                
                // validate the FORM
                $formERRORS = array();

                
                // if (empty($salary)) {
                //     $formERRORS[] = '<div class="alert alert-danger"> salary is Empty</div>';
                // }
                
                // if (empty($workerid)) {
                //     $formERRORS[] = '<div class="alert alert-danger"> workerid is Empty</div>';
                // }

                // if (empty($year)) {
                //     $formERRORS[] = '<div class="alert alert-danger"> year is Empty</div>';
                // }

                // if (empty($month)) {
                //     $formERRORS[] = '<div class="alert alert-danger"> month is Empty</div>';
                // }
                // loop into errors Array And Echo It
                foreach ($formERRORS as $error) {
                    echo $error;
                }
    
                // check if there is no error Update the database

                if(empty($formERRORS)){
                    

                //Update the database with this info

                $stmt = $con->prepare("UPDATE salaries SET discounts=?,loans=?,others=?,salary=?,transportation=?,nightshift=?,workerid=?,year=?,month=?,workdays=?,addhours=?,eatnumber=?,offdays=? WHERE id = ?");
                $stmt->execute(array($discounts,$loans,$others,$salary,$transportation,$nightshift,$workerid,$year,$month,$workdays,$addhours,$eatnumber,$offdays,$salaryid));

                //echo succes message
                
                echo '
                                <script>
                                    window.location= "salaries.php";
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

                        $salaryid = isset($_GET['salaryId']) && is_numeric($_GET['salaryId'] ) ?intval ($_GET['salaryId']): 0 ;
                        // select all data depend on this id 
                        $stmt = $con->prepare("SELECT * FROM salaries WHERE id = ?  LIMIT 1");

                        // check if there is an id as sent or not 

                        $check = checkItem('id','salaries', $salaryid);
            
                        // if there is such id show the form
            
                    if($check > 0) { 
                        $stmt = $con->prepare("DELETE FROM salaries WHERE id = :zsalaryid");
                        $stmt->bindParam(":zsalaryid" , $salaryid);
                        $stmt->execute();
                        echo '
                                <script>
                                    window.location= "salaries.php";
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

            $salaryid = isset($_GET['salaryId']) && is_numeric($_GET['salaryId'] ) ?intval ($_GET['salaryId']): 0 ;

            // select all data depend on this id 

            $stmt = $con->prepare("SELECT * FROM salaries WHERE id = ?  LIMIT 1");

            // check if there is an id as sent or not 

            $check = checkItem('id','salaries', $salaryid);

            // if there is such id show the form

        if($check > 0) { 
            $stmt = $con->prepare("UPDATE salaries SET Approve=1 Where id = ?");

            $stmt->execute(array($salaryid));


            echo '
                                <script>
                                    window.location= "salaries.php";
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