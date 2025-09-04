<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="شركة مكة للمقاولات العمومية">
    <meta name="keywords" content="تعد من الشركات الرائدة فى مجال توريد العمالة وتوريد المعدات الثقيلة والمولدات وتجهيز مواقع الحفر الخاصة لتنصيب البراريم لشركات الأنتاج">
    <meta property="og:description" content=" تعد من الشركات الرائدة فى مجال توريد العمالة وتوريد المعدات الثقيلة والمولدات وتجهيز مواقع الحفر الخاصة لتنصيب البراريم لشركات الأنتاج شركة مكة للمقاولات العمومية  ">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title> شركة بترو مكة </title>

    <!-- Styles -->

    <link rel="styleSheet" href="<?php echo $css; ?>normalize.css">
    <link rel="styleSheet" href="<?php echo $css; ?>all.min.css">
    <link rel="styleSheet" href="<?php echo $css; ?>bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>slick.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>swiper-bundle.min.css" />

    <link rel="styleSheet" href="<?php echo $css; ?>style22.css">

    <link rel="styleSheet" href="<?php echo $css; ?>front.css">



    <!-- FontAwesome Cdn -->
    <link rel="stylesheet" href="<?php echo $css; ?>aos.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="fonts/HelveticaNeueLT Arabic 55 Roman.css" />

</head>

<body>



<div class="loading">
    <div class="spinner"></div>
</div>


<!-- Start navbar Section -->



    
<nav>
        <div class="upper-nav">
            <div class="container">
                <div class="row">
                    <div class="upper-content">

                    
                        <?php 
                        $UserNameNow = $_SESSION['username'];
                        $workers = getAllFrom("*","workers","where idnumber = '$UserNameNow'","","id","");


                        if(isset($_SESSION['username'])){
                            foreach($workers as $worker){
                                echo'
                                <div class="left">
                                <a href="profile.php"> الملف الشخصي <img src="workers/'. $worker['image'] .'"></a>
                                </div>
                                ';
                            }
                            
                            }else{
                                echo' <div class="left">
                                <a href="profile.php">تسجيل الدخول <i class="fa-solid fa-user"></i></a>
                            </div>';
                            }
                            ?>
                        

                        <div class="right">
                            <h2>: تابعنا على </h2>
                            <ul>
                                <li>
                                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                </li>

                                <li>
                                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                </li>

                                <li>
                                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lower-nav">
        <div class="container">
                <div class="row">
            <div class="lower-content">
                <div class="nav-elements">
                    <ul>
                        <li><a href="index.php">الصفحة الرئيسية</a></li>
                        <li><a href="#service"> الخدمات</a></li>
                        <li><a href="#about"> عن الشركة</a></li>
                        <li><a href="#contact"> تواصل معنا</a></li>
                        <li><a href="#workers"> عن الموظفين</a></li>
                    </ul>
                    <a href="#">أحصل على الدعم <i class="fa-solid fa-phone"></i></a>
                </div>

                <div class="nav-btn">
                        <button class="open-nav"><i class="fa-solid fa-bars-staggered"></i></button>
                </div>

                <div class="logo">
                    <img src="images/logo.png">
                </div>
            </div>
        </div>
        </div>
        </div>
</nav>



<div class="mobile-nav">
        <ul>
            <i class="close-nav fa-solid fa-xmark"></i>
                <li><a href="index.php">الصفحة الرئيسية</a></li>
                <li><a href="#service"> الخدمات</a></li>
                <li><a href="#about"> عن الشركة</a></li>
                <li><a href="#contact"> تواصل معنا</a></li>
                <li><a href="#workers"> عن الموظفين</a></li>
            

        </ul>
    </div>







<!-- End navbar Section -->


<?php 

$IncreaseVisitors = $con->prepare("UPDATE stats SET number = number + 1 Where name ='visitors'");
$IncreaseVisitors->execute();






?>
