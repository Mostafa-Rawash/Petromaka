<?php
    
    ob_start();
    session_start();
    $pageTitle = 'HomePage';
    include 'init.php';


    $search = trim($_GET["search"]);



    $query = $con -> prepare("SELECT * FROM products WHERE name like '%{$search}%' OR words like '%{$search}%'OR description like '%{$search}%'");
    $query -> execute(array());

    $control = $query -> fetchAll(PDO::FETCH_OBJ);
    $count = $query -> rowCount();

    if($count > 0){

        echo '<section class="categories">
        <div class="container">';

        

                echo '
                <div class="row">


                <div class="new-products">



                    <div class="category-body">

                
                ';

                foreach($control as $product){
                    echo'
                    

                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="item">
                        <a href="product.php?productid='. $product->id .'"><img src="products/'. $product->image .'"></a>

                        <h1>'. $product->name.'</h1>

                        <div class="price-tag">
                            <span class="price">'. $product->price .' </span> <span class="currency"> EG</span>
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

        else{
            echo '
            <h1 style="height: 35vh;
    text-align: center;
    font-size: 80px;
    font-weight: 800;
    color: #b3b3b3;
    margin-top: 94px;"> لا توجد نتائج بحث</h1>';
        }
        ?>


        </div>
    </section>









            <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({
        offset:200,
        delay:100,
        duration:1000,}
    );
</script>




<?php

    include  $tpl ."footer.php";
    ob_end_flush();

?>