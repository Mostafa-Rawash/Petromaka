<?php
    
    ob_start();
    session_start();
    $pageTitle = 'HomePage';
    include 'init.php';


    if($_SERVER ['REQUEST_METHOD'] =='GET'){

        if(isset($_GET['subcatid'])){

            $subcategoryid = $_GET['subcatid'];



            $subcategory = getAllFrom("*","subcategories","where id= $subcategoryid","","id","");

            if(isset($_GET['orderbysells'])){
                $products = getAllFrom("*","products","where sub_cat_id = $subcategoryid","","buynumbers","DESC");
            }else if(isset($_GET['lowerprice'])){
                $products = getAllFrom("*","products","where sub_cat_id = $subcategoryid","","price","ASC");
            }else if(isset($_GET['higherprice'])){
                $products = getAllFrom("*","products","where sub_cat_id = $subcategoryid","","price","DESC");
            }
            
            else{
                $products = getAllFrom("*","products","where sub_cat_id = $subcategoryid","","id","");
            }

            
        }

    }

?>



    <!-- Start Categories Section -->

    <section class="categories">
        <div class="container">

        <?php 
            foreach($subcategory as $category){
                echo '
                <div class="row">


                <div class="new-products">


                    <div class="category-header">
                        <h1>'.$category['name'].'</h1>

                        <button class="open-products-order">
                            ترتيب 
                            <i class="fa-solid fa-arrow-up-wide-short"></i>
                        </button>

                        <ul class="order-products">
                                    <li>
                                    <a href="products.php?subcatid='.$category['id'].'&orderbysells=yes">الاكثر مبيعا   <i class="fa-solid fa-circle-dot"></i></a>
                                    </li>

                                    <li>
                                    <a href="products.php?subcatid='.$category['id'].'&lowerprice=yes">  من الاقل سعرا للاعلى <i class="fa-solid fa-circle-dot"></i> </a>
                                    </li>
                                    <li>
                                    <a href="products.php?subcatid='.$category['id'].'&higherprice=yes"> من الاعلى سعرا للاقل  <i class="fa-solid fa-circle-dot"></i></a>
                                    </li>
                            </ul>
                    </div>

                    <div class="category-body">

                
                ';

                foreach($products as $product){
                    echo'
                    

                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="item">
                        <a href="product.php?productid='. $product['id'] .'"><img src="products/'. $product['image'] .'"></a>

                        <h1>'. $product['name'] .'</h1>

                        <div class="price-tag">
                            <span class="price">'. $product['price'] .' </span> <span class="currency"> EG</span>
                        </div>

                        <button class="add-to-cart">
                            اضافة للسلة
                            <i class="fa-solid fa-cart-arrow-down"></i>
                        </button>
                    </div>
                </div>


                    ';
                }

                echo '
                
                </div>
                </div>
            </div>

                ';
            }
        ?>


        </div>
    </section>






    <!-- End Categories Section -->







<?php
    

    include  $tpl ."footer.php";
    ob_end_flush();

?>