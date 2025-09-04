<?php
    
    ob_start();
    session_start();
    $pageTitle = 'HomePage';
    include 'init.php';


?>

<!-- Start Side Bar Section -->

<section class="side-bar">
    <div class="bar-content">
        <div class="header">
        <i class="close-side-nav las la-times"></i>
            <h1>اول دليل يجمع جميع المتاجر السعودية والعالمية والخدمات في مكان واحد</h1>
            
        </div>
        <div class="body">
            <ul>
                <li><a href="index.php">الرئيسية</a><i class="las la-home"></i></li>
                <li><a href="#">سياسة الخصوصية</a><i class="las la-file-alt"></i></li>
                <li><a href="#">شروط الموقع</a><i class="las la-file-alt"></i></li>
                <li><a href="#">اتصل بنا</a><i class="las la-envelope"></i></li>
            </ul>
        </div>
    </div>
</section>


<!-- End Side Bar Section -->

<!-- Start navbar Section -->
<nav >
        
            <div class="upper-nav">
                <a class="search" href="#"><i class="las la-search"></i></a>
                <a class="logo"   href="index.php"><img src="photos/logo.png" alt="logo"/></a> 
                <a class="hotpages" href="#"><i class="las la-fire-alt"></i></a>
            </div>
            <div class="lower-nav">
                <a class="open-side-nav">
                <i class="las la-bars"></i><span>القائمة</span>
                </a>
                <a class="middle-lower-nav" href="add-ad.php">
                    اضف متجرك
                </a>
                <a class="active" href="#">
                <i class="las la-home"></i><span>الرئيسية</span>
                </a>

            </div>
        
</nav>




<!-- End navbar Section -->

<!-- Start Tools Section -->
    <section class="tools">
        <div class="tools-container">
            <div class="tool">
                <h1>مواقيت الصلاة</h1>
                <a target="_blank" href="http://www.ummulqura.org.sa/"><img class="image-tool" src="photos/toolsimages/750586.png"/></a>
            </div>

            <div class="tool">
                <h1>التقويم</h1>
                <a  target="_blank" href="https://hijri-gregorian.com/"><img class="image-tool" src="photos/toolsimages/820249.png"/></a>
            </div>


            <div class="tool">
                <h1>التوقيت العالمي</h1>
                <a target="_blank" href="https://www.timeanddate.com/worldclock/"><img class="image-tool" src="photos/toolsimages/866589.png"/></a>
            </div>


            <div class="tool">
                <h1>الترجمة</h1>
                <a  target="_blank" href="https://translate.google.com/"><img class="image-tool" src="photos/toolsimages/889973.png"/></a>
            </div>

            <div class="tool">
                <h1>سرعة النت</h1>
                <a  target="_blank" href="https://www.speedtest.net/"><img class="image-tool" src="photos/toolsimages/658240.png"/></a>
            </div>

            <div class="tool">
                <h1>حاسبة</h1>
                <a  target="_blank" href="https://www.calculator.net/"><img class="image-tool" src="photos/toolsimages/993873.png"/></a>
            </div>

            <div class="tool">
                <h1>تحويل العملة</h1>
                <a  target="_blank"  href="https://www.xe.com/currencyconverter/"><img class="image-tool" src="photos/toolsimages/196147.png"/></a>
            </div>

            <div class="tool">
                <h1>طقس</h1>
                <a  target="_blank" href="https://www.msn.com/ar-sa/weather"><img class="image-tool" src="photos/toolsimages/279225.png"/></a>
            </div>

            <div class="tool">
                <h1>تداول</h1>
                <a  target="_blank" href="https://www.saudiexchange.sa/wps/portal/tadawul/home/"><img class="image-tool" src="photos/toolsimages/889973.png"/></a>
            </div>

            <div class="tool">
                <h1>خرائط جوجل</h1>
                <a target="_blank" href="https://www.google.com/maps"><img class="image-tool" src="photos/toolsimages/138191.png"/></a>
            </div>
        </div>
    </section>


<!-- End Tools Section -->

<!-- Start Hot Websites Section -->
<div class="container">
    <section class="hot-websites">
        <div class="row">


        <?php
            $allEtisaWebsites = getAllFrom("*", "websites", " WHERE Approve = 1", "AND views >= 5", "id", "ASC");
            foreach ($allEtisaWebsites as $website) {
                echo '
                <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4">
                <div class="hot-content">
                    <h1><i class="las la-eye"></i> '. $website['views'] .'</h1>
                    <a href="websites.php?websiteId='. $website['id'] .'&WebsiteType='. $website['WebsiteType'] .'"><img  src="uploads/'. $website['WebsitePhoto'] .'"></a>
                </div>
            </div>
                '; 
            }
            ?>

<?php
            $allEtisaWebsites = getAllFrom("*", "websites", " WHERE Approve = 1", "AND views >= 5", "id", "ASC");
            foreach ($allEtisaWebsites as $website) {
                echo '
                <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4">
                <div class="hot-content">
                    <h1><i class="las la-eye"></i> '. $website['views'] .'</h1>
                    <a href="websites.php?websiteId='. $website['id'] .'&WebsiteType='. $website['WebsiteType'] .'"><img  src="uploads/'. $website['WebsitePhoto'] .'"></a>
                </div>
            </div>
                '; 
            }
            ?>

<?php
            $allEtisaWebsites = getAllFrom("*", "websites", " WHERE Approve = 1", "AND views >= 5", "id", "ASC");
            foreach ($allEtisaWebsites as $website) {
                echo '
                <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4">
                <div class="hot-content">
                    <h1><i class="las la-eye"></i> '. $website['views'] .'</h1>
                    <a href="websites.php?websiteId='. $website['id'] .'&WebsiteType='. $website['WebsiteType'] .'"><img  src="uploads/'. $website['WebsitePhoto'] .'"></a>
                </div>
            </div>
                '; 
            }
            ?>

<?php
            $allEtisaWebsites = getAllFrom("*", "websites", " WHERE Approve = 1", "AND views >= 5", "id", "ASC");
            foreach ($allEtisaWebsites as $website) {
                echo '
                <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4">
                <div class="hot-content">
                    <h1><i class="las la-eye"></i> '. $website['views'] .'</h1>
                    <a href="websites.php?websiteId='. $website['id'] .'&WebsiteType='. $website['WebsiteType'] .'"><img  src="uploads/'. $website['WebsitePhoto'] .'"></a>
                </div>
            </div>
                '; 
            }
            ?>


<?php
            $allEtisaWebsites = getAllFrom("*", "websites", " WHERE Approve = 1", "AND views >= 5", "id", "ASC");
            foreach ($allEtisaWebsites as $website) {
                echo '
                <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4">
                <div class="hot-content">
                    <h1><i class="las la-eye"></i> '. $website['views'] .'</h1>
                    <a href="websites.php?websiteId='. $website['id'] .'&WebsiteType='. $website['WebsiteType'] .'"><img  src="uploads/'. $website['WebsitePhoto'] .'"></a>
                </div>
            </div>
                '; 
            }
            ?>



<?php
            $allEtisaWebsites = getAllFrom("*", "websites", " WHERE Approve = 1", "AND views >= 5", "id", "ASC");
            foreach ($allEtisaWebsites as $website) {
                echo '
                <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4">
                <div class="hot-content">
                    <h1><i class="las la-eye"></i> '. $website['views'] .'</h1>
                    <a href="websites.php?websiteId='. $website['id'] .'&WebsiteType='. $website['WebsiteType'] .'"><img  src="uploads/'. $website['WebsitePhoto'] .'"></a>
                </div>
            </div>
                '; 
            }
            ?>


<?php
            $allEtisaWebsites = getAllFrom("*", "websites", " WHERE Approve = 1", "AND views >= 5", "id", "ASC");
            foreach ($allEtisaWebsites as $website) {
                echo '
                <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4">
                <div class="hot-content">
                    <h1><i class="las la-eye"></i> '. $website['views'] .'</h1>
                    <a href="websites.php?websiteId='. $website['id'] .'&WebsiteType='. $website['WebsiteType'] .'"><img  src="uploads/'. $website['WebsitePhoto'] .'"></a>
                </div>
            </div>
                '; 
            }
            ?>
        

        </div>
    </section>

        </div>

<!-- End Hot Websites Section -->
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