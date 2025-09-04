<?php
    
    ob_start();
    session_start();
    $pageTitle = 'HomePage';
    include 'init.php';

    
include("simple_html_dom.php"); 

$html = file_get_html('https://www.cbe.org.eg/ar/EconomicResearch/Statistics/Pages/ExchangeRatesListing.aspx');
?>



<!-- Start Infp page Section -->

<section class="info-page">
    <div class="container">
        <div class="row">
            <div class="info-content">
                <h1> هذا النص يمكن استبداله باي نص من اختيارك </h1>
                <img src="images/landing/oil.jpg">

                <p>  هذا النص يمكن استبداله باي نص من اختيارك  هذا النص يمكن استبداله باي نص من اختيارك  هذا النص يمكن استبداله باي نص من اختيارك  هذا النص يمكن استبداله باي نص من اختيارك  هذا النص يمكن استبداله باي نص من اختيارك  هذا النص يمكن استبداله باي نص من اختيارك  هذا النص يمكن استبداله باي نص من اختيارك  هذا النص يمكن استبداله باي نص من اختيارك  </p>
            </div>
        </div>
    </div>
</section>










<!-- End Infp page Section -->











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