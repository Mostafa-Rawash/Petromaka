<?php
    
    ob_start();
    session_start();
    $pageTitle = 'HomePage';
    include 'init.php';




    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_GET['do']) && $_GET['do'] == 'payment'){

                // Insert category page
    
            
    
    
                echo "<h1 class='text-center'>Add Rate </h1>";
                echo "<div class='container'>";
    
                    // Upload Variables 
    
    
                    // Get the variables from the form
    
                    $name                       = $_POST['name'];
                    $number                     = $_POST['number'];
                    $email                      = $_POST['email'];
                    $country                    = $_POST['country'];
                    $place                      = $_POST['place'];
                    $adress                     = $_POST['adress'];
                    $productnames               = $_POST['productnames'];
                    $totalprice                 = $_POST['totalprice'];
                    
                    // validate the FORM
                    $formERRORS = array();
    
                    if (empty($name)) {
                        $formERRORS[] = '<div class="alert alert-danger"> Name is Empty</div>';
                    }
                    if (empty($number)) {
                        $formERRORS[] = '<div class="alert alert-danger"> number is Empty</div>';
                    }
                    if (empty($country)) {
                        $formERRORS[] = '<div class="alert alert-danger"> description is Empty</div>';
                    }
                    
                    if (empty($place)) {
                        $formERRORS[] = '<div class="alert alert-danger"> productid is Empty</div>';
                    }

                    if (empty($adress)) {
                        $formERRORS[] = '<div class="alert alert-danger"> productid is Empty</div>';
                    }

                    if (empty($productnames)) {
                        $formERRORS[] = '<div class="alert alert-danger"> productid is Empty</div>';
                    }

                    if (empty($totalprice)) {
                        $formERRORS[] = '<div class="alert alert-danger"> productid is Empty</div>';
                    }
                    // loop into errors Array And Echo It
                    foreach ($formERRORS as $error) {
                        echo $error;
                    }
        
    
                    // check if there is no error Update the database
    
                    if(empty($formERRORS)){
                        //Insert User Info in data base
    
                        $stmt = $con->prepare("INSERT
                                                    INTO payments
                                                    ( name,
                                                    number,
                                                    email,
                                                    country,
                                                    place,
                                                    adress,
                                                    productnames,
                                                    totalprice
                                                    
                                                    
                                                    
                                                    )
                                    VALUES (:zname,:znumber,:zemail,:zcountry,:zplace,:zadress,:zproductnames,:ztotalprice)");
                    $stmt->execute(array(
                                'zname'             =>$name,
                                'znumber'           =>$number,
                                'zemail'            =>$email,
                                'zcountry'          =>$country,
                                'zplace'            =>$place,
                                'zadress'           =>$adress,
                                'zproductnames'     =>$productnames,
                                'ztotalprice'       =>$totalprice
                            ));
    
                    //echo succes message
                    echo '
                    <script>
                        window.location= "https://api.whatsapp.com/send?phone=+2001006329357";
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
    
            
            
        
        }
        
    

?>


    <!-- Start Cart Section -->

    <section class="cart-section">
        <div class="container">
            <div class="row">
                <h1> سلة المشتريات <i class="fa-solid fa-cart-arrow-down"></i></h1>
                <form action="?do=payment" method="POST" enctype="multipart/form-data">
                
                <div class="client-data">
                <i style="left: 12%;
    position: absolute;
    top: 37px;
    color: #000;
    font-size: 29px;
    cursor: pointer;
    z-index: 1;" class="fa fa-close close-pay-pop"></i>
                    <div class="client-form">
                        <!-- <form> -->

                        <input name="totalprice" class="hide" id="total-price-input">

                        <input name="productnames" class="hide" id="product-names-input">


                            <div class="input">
                                <label> <span>*</span> الأسم </label>
                                <input required name="name" type="text" placeholder="اسم العميل">
                            </div>

                            <div class="input special">
                                <div>
                                <label> <span>*</span> رقم الهاتف </label>
                                <input required name="number" type="number" placeholder=" رقم الهاتف">
                                </div>

                                <div>
                                <label>  البريد الالكتروني </label>
                                <input name="email" type="email" placeholder=" البريد الالكتروني ">
                                </div>
                            </div>


                            <div class="input special">
                                <div>
                                    <label> <span>*</span> البلد </label>
                                    <input required name="country" type="text" placeholder=" مثال : مصر">
                                </div>

                                <div>
                                    <label> <span>*</span>   المحافظة </label>
                                    <input required name="place" type="text" placeholder=" مثال :القاهرة ">
                                </div>
                            </div>

                            <div class="input">
                                <label>  <span>*</span>  العنوان </label>
                                <textarea name="adress" required placeholder="يرجى ادخال عنوانك بالتفصيل او قم بارسال رابط الموقع الخاص بك "></textarea>
                            </div>

                            <input type="text" class="product-form-names hidden" value="" >

                            <button type="submit">ادفع الان</button>
                        <!-- </form> -->
                    </div>
                </div>
                    <div class="cart-content">



                        <h1 style="text-align: center;font-weight: bold;color: #6c6c6c;margin-top: 80px;margin-bottom: 50px;font-size: 50px;">سلة المشتريات فارغة</h1>
                    </div>

                </form>
            </div>
        </div>
    </section>
















    <!-- End Cart Section -->





<?php

    include  $tpl ."footer.php";
    ob_end_flush();

?>