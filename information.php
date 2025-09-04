<?php
    
    ob_start();
    session_start();
    $pageTitle = 'HomePage';
    include 'init.php';


    if(isset($_GET['infoid'])){
        $infoid = $_GET['infoid'];

        $stmt = $con->prepare("SELECT * FROM information where id = $infoid  ORDER BY id DESC");

        // execute to the statment
        $stmt->execute();

        // assign data come to a variable

        $information = $stmt->fetchAll();

        if(! empty ($information)){

            foreach($information as $info){

                echo '
                                
                <section class="information-page">

                <div class="container">
                    <div class="row">

                        <div class="share-buttons">
                            <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=https://petromaka.com/'.  $_SERVER['PHP_SELF']  .'?infoid=' . $info['id'] . '" target="_blank">
                                مشاركة عبر فيسبوك <i class="fa-brands fa-facebook-f"></i>
                            </a>

                            <a class="twitter" href="http://twitter.com/share?url=https://petromaka.com/'.  $_SERVER['PHP_SELF']  .'?infoid=' . $info['id'] . '" target="_blank">
                            مشاركة عبر تويتر <i class="fa-brands fa-twitter"></i>
                        </a>
                        </div>
                        <div class="header">
                            <h1> '. $info['name'] .' </h1>
                        </div>

                        <img src="images/landing/'. $info['img'] .'">

                        <div class="description">
                            <p>
                            '. $info['description'] .'
                            </p>
                        </div>

                    </div>
                </div>

                </section>


                ';
            }


            


        }


    }


?>








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