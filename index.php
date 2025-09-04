<?php

ob_start();
session_start();
$pageTitle = 'HomePage';
include 'init.php';


include("simple_html_dom.php");

// $html = file_get_html('https://www.cbe.org.eg/ar/EconomicResearch/Statistics/Pages/ExchangeRatesListing.aspx');
?>
<!-- <marquee onmouseover="this.stop();" onmouseout="this.start();">
    <?php
    // foreach($html->find('tbody tr') as $element){
    //     echo " <a  href='#'> ". $element->first_child()->next_sibling()->next_sibling()->plaintext ." سعر الشراء  ". $element->first_child()->next_sibling()->plaintext ." سعر البيع  ". $element->first_child()->plaintext ."  </a>";
    // }
    ?>
</marquee> -->
<!-- Start information Section -->
<section id="programs-section" class="free-programs-videos">
    <div class="programs-container">
        <div class="main-video">
            <?php
            $mainvideos = getAllFrom("*", "information", "where number = 1", "", "id", "");
            foreach ($mainvideos as $mainvideo) {
                echo '
                <div class="video">
                        <img src="images/landing/' . $mainvideo['img'] . '">
                            <h3> <a class="title" href="information.php?infoid=' . $mainvideo['id'] . '"> ' . $mainvideo['name'] . ' </a></h3>
                </div>
                ';
            }
            ?>
        </div>
        <div class="video-list">

            <?php

            $information = getAllFrom("*", "information", "where number < 6", "", "id", "");

            foreach ($information as $info) {
                echo '
                    <div class="vid">
                    <img src="images/landing/' . $info['img'] . '">
                        <h3 class="title">  <a class="title" href="information.php?infoid=' . $info['id'] . '">  ' . $info['name'] . ' </a> </h3>
                    </div>
                    ';
            }
            ?>
        </div>
    </div>

</section>


<!-- End Information Section -->

<!-- Start About Section -->

<section id="about" class="about">
    <div class="container">
        <div class="row">
            <?php
            $aboutus = getAllFrom("*", "aboutus", "", "", "id", "");

            foreach ($aboutus as $about) {
                echo '
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                <div class="about-content">
                    <div>
                        <h1> شركتنا  <span> عن </span></h1>
                        <span class="line"></span>
                    </div>

                    <h2> ' . $about['header'] . '  </h2>

                    <p>' . $about['description'] . '  </p>

                    <div class="icons">
                        <img src="images/icons/icon-1.png.webp">

                        <img src="images/icons/icon-2.png.webp">

                        <img src="images/icons/icon-3.png.webp">
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                <div class="about-image">
                    <div></div>
                    <img src="images/' . $about['img'] . '">
                </div>
            </div>
                    ';
            }
            ?>

        </div>
    </div>
</section>
<!-- End About Section -->
<!-- Start Last Projects Section -->
<section class="last-project">
    <div class="container">
        <div class="row">
            <div class="header">
                <h1> أعمالنا <span>اخر</span></h1>
                <span></span>
            </div>
            <div class="body">
                <?php
                $lastworks = getAllFrom("*", "lastwork", "where number < 4", "", "id", "");
                foreach ($lastworks as $lastwork) {
                    echo '
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="project">
                            <img src="images/' . $lastwork['img'] . '">
                            <div class="portfolio-overley">
                                <h3><a href="#"> ' . $lastwork['projectname'] . ' </a></h3>
                                <div class="portfolio-tags"> ' . $lastwork['companyname'] . ' </div>
                            </div>
                        </div>
                    </div>
                    ';
                }
                ?>
                <?php
                $lastworksmini = getAllFrom("*", "lastwork", "where number > 3", "", "id", "");
                foreach ($lastworksmini as $lastwork) {
                    echo '
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="project">
                            <img src="images/' . $lastwork['img'] . '">
                            <div class="portfolio-overley">
                                <h3><a href="#"> ' . $lastwork['projectname'] . ' </a></h3>
                                <div class="portfolio-tags"> ' . $lastwork['companyname'] . ' </div>
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
<!-- Ebd Last Projects Section -->
<!-- Start Our Partners Section -->

<div class="partners-section">
    <div class="over-lay"></div>
    <div class="text">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="partners-text">
                <div class="partners-text-slider">
                    <div class="slider">
                        <?php
                        $clientwords = getAllFrom("*", "clientword", "", "", "id", "");

                        foreach ($clientwords as $clientword) {
                            echo '
                    
                    <div class="slide">
                        <div>
                            <p> ' . $clientword['description'] . ' </p>
                            <div class="user-info">
                                <img src="images/' . $clientword['img'] . '">
                                <div>
                                    <h1>' . $clientword['name'] . '</h1>
                                    <h2>' . $clientword['postition'] . '</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="partners-img">

                <?php

                $partners = getAllFrom("*", "partner", "", "", "id", "");

                foreach ($partners as $partner) {
                    echo '
                    
                    <img src="images/partners/' . $partner['img'] . '">
                    ';
                }
                ?>


            </div>
        </div>



    </div>



</div>

<!-- End Our Partners Section -->

<!-- Start Special worker section -->

<section id="worker" class="special-worker">
    <div class="container">
        <div class="row">
            <div class="header">
                <h1>الموظف <span>المثالي</span></h1>
                <span></span>

                <h2>المرشحون الامثل للقب الموظف المثالي</h2>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="worker">
                    <div class="worker-name">
                        <h1>اسم العامل</h1>
                        <h2>عامل</h2>

                    </div>
                    <img src="workers/team01.png">
                    <a href="#">تصويت</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="worker">
                    <div class="worker-name">
                        <h1>اسم العامل</h1>
                        <h2>عامل</h2>

                    </div>
                    <img src="workers/team02.png">
                    <a href="#">تصويت</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="worker">
                    <div class="worker-name">
                        <h1>اسم العامل</h1>
                        <h2>عامل</h2>
                    </div>
                    <img src="workers/team03.png">
                    <a href="#">تصويت</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="worker">
                    <div class="worker-name">
                        <h1>اسم العامل</h1>
                        <h2>عامل</h2>

                    </div>
                    <img src="workers/team04.png">
                    <a href="#">تصويت</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Special worker section -->
<!--Counters-->
<?php

$statsExp = getAllFrom("*", "stats", "where name = 'expyears'", "", "id", "");
$statsproj = getAllFrom("*", "stats", "where name = 'doneprojects'", "", "id", "");
$statscur = getAllFrom("*", "stats", "where name = 'currentvisit'", "", "id", "");
$statsvis = getAllFrom("*", "stats", "where name = 'visitors'", "", "id", "");

?>

<section style="margin-top:50px;background-color: #0c005b;" class="section bg-image-2">
    <div class="container section-md">
        <div id="counters" class="row row-30 text-center">
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <div class="counter-classic">
                    <div class="counter-classic-number"><span
                            class="icon-lg novi-icon offset-right-10 mercury-icon-time"></span><span
                            class="counter text-white" data-targetnum="<?php foreach ($statsExp as $number) {
                                echo $number['number'];
                            } ?>" data-speed="2000"><?php foreach ($statsExp as $number) {
                                 echo $number['number'];
                             } ?></span>
                    </div>
                    <div class="counter-classic-title">سنين الخبرة</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <div class="counter-classic">
                    <div class="counter-classic-number"><span
                            class="icon-lg novi-icon offset-right-10 mercury-icon-folder"></span><span
                            class="counter text-white" data-targetnum="<?php foreach ($statsproj as $number) {
                                echo $number['number'];
                            } ?>" data-speed="2000"><?php foreach ($statsproj as $number) {
                                 echo $number['number'];
                             } ?></span><span class="symbol text-white">+</span>
                    </div>
                    <div class="counter-classic-title">مشاريع منجزة</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <div class="counter-classic">
                    <div class="counter-classic-number"><span
                            class="icon-lg novi-icon offset-right-10 mercury-icon-globe"></span><span
                            class="counter text-white" data-targetnum="<?php foreach ($statscur as $number) {
                                echo $number['number'];
                            } ?>" data-speed="2000"><?php foreach ($statscur as $number) {
                                 echo $number['number'];
                             } ?></span>
                    </div>
                    <div class="counter-classic-title"> زوار الحاليين</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <div class="counter-classic">
                    <div class="counter-classic-number"><span
                            class="icon-lg novi-icon offset-right-10 mercury-icon-group"></span><span
                            class="counter text-white" data-targetnum="<?php foreach ($statsvis as $number) {
                                echo $number['number'];
                            } ?>" data-speed="2000"><?php foreach ($statsvis as $number) {
                                 echo $number['number'];
                             } ?></span>
                    </div>
                    <div class="counter-classic-title">زوار المواقع</div>
                </div>
            </div>
        </div>
    </div>
</section>


<!--Counters-->
<!-- Start Banners Section -->
<div id="service" class="banners">
    <h1 id="products-header">خدماتنا</h1>
    <div class="row">


        <?php

        $services = getAllFrom("*", "services", "", "", "id", "");

        foreach ($services as $service) {
            echo '
                    
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                        <div  class="banners-content">
                            
                            <img src="images/' . $service['img'] . '">
                            <div class="banner-text ">
                                <h1>  ' . $service['header'] . ' </h1>
                                <p> ' . $service['description'] . ' </p>
                                <a href="https://api.whatsapp.com/send?phone=01009183522"> تواصل معنا </a>

                            </div>

                        </div>
                    </div>
                    ';
        }
        ?>



    </div>
</div>



<!-- End Banners Section-->




<!-- Start Contact Us Section -->


<div class="call-wrap" id="contact">
    <div class="container">
        <h1> معنا<span>تواصل </span></h1>
        <div class="row">
            <div class="col-md-6">
                <div class="overview-info">
                    <div class="callus">
                        <h2>تواصل معنا اليوم</h2>
                        <div class="call-text"><span>201009183522+ </span> 24 / 7 </div>
                    </div>
                    <p> هذا النص يمكن استبداله باي نص تريد فهو مجرد نص تجريبي هذا النص يمكن استبداله باي نص تريد فهو
                        مجرد نص تجريبي هذا النص يمكن استبداله باي نص تريد فهو مجرد نص تجريبي </p>
                </div>
            </div>
            <div class="col-md-6">
                <form>
                    <div class="contactForm formwrap">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="الاسم الاول" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="الاسم الثاني" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="phone" placeholder="رقم الهاتف" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="email" placeholder="البريد الالكتروني"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="الرسالة"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn" value="ارسال">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- End Contact us Section -->




<!-- Start Ad Section -->


<!-- 

<section style="margin-bottom:0;" class="ads-slider">
    <div class="slider">
        <div class="slide">
            <a href="#">
                <img src="images/ads/ad1.webp">
            </a>
        </div>

        <div class="slide">
            <a href="#">
                <img src="images/ads/ad2.png">
            </a>
        </div>
    </div>
</section> -->



<!-- End Ad Section -->



<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({
        offset: 200,
        delay: 100,
        duration: 1000,
    }
    );
</script>
<?php

include $tpl . "footer.php";
ob_end_flush();

?>