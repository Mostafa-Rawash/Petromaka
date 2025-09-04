<?php
    
    ob_start();
    session_start();
    $pageTitle = 'HomePage';
    include 'init.php';



    
    if($_SERVER ['REQUEST_METHOD'] =='GET'){

        if(isset($_GET['productid'])){

            $productid = $_GET['productid'];

                $products = getAllFrom("*","products","where id = $productid","","id","");
                $rates = getAllFrom("*","rates","where item_id = $productid","and activate = 1","id","");
            
            
        }

    }



    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_GET['do']) && $_GET['do'] == 'addrate'){

                // Insert category page
    
            
    
    
                echo "<h1 class='text-center'>Add Rate </h1>";
                echo "<div class='container'>";
    
                    // Upload Variables 
    
    
                    // Get the variables from the form
    
                    $name                       = $_POST['name'];
                    $number                     = $_POST['number'];
                    $stars                      = $_POST['stars'];
                    $description                = $_POST['description'];
                    $active                     = 0;
                    $productid                  = $_POST['productid'];
                    
                    // validate the FORM
                    $formERRORS = array();
    
                    if (empty($name)) {
                        $formERRORS[] = '<div class="alert alert-danger"> Name is Empty</div>';
                    }
                    if (empty($number)) {
                        $formERRORS[] = '<div class="alert alert-danger"> number is Empty</div>';
                    }
                    if (empty($stars)) {
                        $formERRORS[] = '<div class="alert alert-danger"> stars is Empty</div>';
                    }
                    if (empty($description)) {
                        $formERRORS[] = '<div class="alert alert-danger"> description is Empty</div>';
                    }
                    
                    if (empty($productid)) {
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
                                                    INTO rates
                                                    ( name,
                                                    number,
                                                    stars,
                                                    description,
                                                    activate,
                                                    item_id
                                                    
                                                    
                                                    
                                                    )
                                    VALUES (:zname,:znumber,:zstars,:zdescription,:zactivate,:zitem_id)");
                    $stmt->execute(array(
                                'zname'             =>$name,
                                'znumber'           =>$number,
                                'zstars'            =>$stars,
                                'zdescription'      =>$description,
                                'zactivate'         =>$active,
                                'zitem_id'          =>$productid
                            ));
    
                    //echo succes message
                    echo '
                    <script>
                        window.location= "product.php?productid='.$productid.'";
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

    <!-- Start Product Section -->

    <section class="product-section">
        <div class="container">
            <div class="row">

            <?php 
                foreach($products as $product){
                    echo '
                    
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                    <div id="'. $product['id'] .'" class="product item">
                        <h1>'. $product['name'] .'</h1>
                        <h2><span class="currency">EGP</span> <span class="default-price">'. $product['price'] .'</span></h2>

                        <h3>موصفات الزيت</h3>

                        <p>'. $product['description'] .'</p>

                        <h4> كلمات دلالية</h4>

                        <div class="search-words">
                            <span><i class="fa-solid fa-tag"></i>'. $product['words'] .'</span>

                            
                        </div>


                        <div class="buying-numbers">
                            <span class="numbers">مرة</span><span class="numbers">'. $product['buynumbers'] .'</span> <span>تم شراءه</span><i class="fa-solid fa-fire"></i>
                        </div>

                        <div class="order-form">

                            <form action="" method="">
                                <div class="quantity">
                                    <div class="counter">
                                        <button  type="button" class="minus">
                                            -
                                        </button>
                                        <input type="number" class="input-counter" value="1">
                                        <button type="button" class="plus">+</button>
                                    </div>

                                    <div class="price">
                                        <span></span>
                                        <span class="price"><span class="currency">EGP</span><span class="total-default-price">252</span></span>
                                        <span>السعر</span>
                                    </div>

                                    <button class="add-product-to-cart" type="button">اضافة للسلة</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>


                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="product">
                        <img src="products/'. $product['image'] .'">
                    </div>
                </div>
            </div>
                    
                    
                    
                    
                    
                    ';
                }

            ?>





               





        </div>
    </section>


    <!-- End Product Section -->















    <!-- Start Product-rating Section -->

    <section class="product-rating">
        <div class="container">
            <div class="row">
                <div class="rating-content">
                    <h1>قيم تجربتك في شراء المنتج</h1>



                    <form  action="?do=addrate" method="POST" enctype="multipart/form-data">
                        
                    <?php 
                        foreach($products as $product){
                            echo '
                            <input value ="'. $product['id'] .'"  required name="productid" type="number" class="hide">
                            ';
                        }
                    ?>
                        <div class="data">
                            <input required name="number" type="number" placeholder="ادخل رقم الهاتف">
                            <input required name="name" type="text" placeholder="ادخل اسمك">
                        </div>

                        <div class="rating-stars">

                            <div class="rate">
                                <label for="fivestar">
                                    <i class="fa-solid fa-star"></i>
                                </label>

                                <label for="fourstar">
                                    <i class="fa-solid fa-star"></i>
                                </label>
                                <label for="threestar">
                                    <i class="fa-solid fa-star"></i>
                                </label>
                                <label for="twostar">
                                    <i class="fa-solid fa-star"></i>
                                </label>

                                <label for="onestar">
                                    <i class="fa-solid fa-star"></i>
                                </label>






                            </div>

                            <div class="hidden">
                                <input required value="5" type="radio" name="stars" id="onestar">
                                <input value="4"  type="radio" name="stars" id="twostar">
                                <input value="3"  type="radio" name="stars" id="threestar">
                                <input value="2"  type="radio" name="stars" id="fourstar">
                                <input value="1"  type="radio" name="stars" id="fivestar">
                            </div>
                        </div>

                        <div class="message-input">
                            <textarea required name="description" class="message">

                            </textarea>
                        </div>

                        <button type="submit">ارسال</button>
                    </form>
                </div>
            </div>
        </div>
    </section>




    <!-- End Product-rating Section -->



    <!-- Start Reviews-show Section -->

    <section class="reviews-show">
        <div class="container">
            <div class="row">



            <?php 
            
                foreach($rates as $rate){
                    echo '
                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                    <div class="review-show-content">
                        <div class="header">
                            <h1>'. $rate['name'] .'</h1>
                            <ul>
                            ';
                            for($i = 0;$i< $rate['stars'];$i++){
                                echo '<li>
                                <i class="fa-solid fa-star"></i>
                                </li>';
                            }
                                
                        
                                echo '
                            </ul>
                        </div>

                        <div class="description">
                            <p>
                            '. $rate['description'] .'
                            </p>
                        </div>
                    </div>
                </div>



                    ';
                }
            ?>

                

                </div>
            </div>
        </div>
    </section>




    <!-- End Reviews-show Section -->






<?php

    include  $tpl ."footer.php";
    ob_end_flush();

?>