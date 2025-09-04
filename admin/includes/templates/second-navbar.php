<?php 
if (isset($_SESSION['UserName'])) {
    $adminid = $_SESSION['ID'];
}

    ?>




<div class="navigation">
            <div class="n1">
                <div>
                    <i id="menu-btn" class="fa fa-bars"></i>
                </div>
                <div class="search">
                    <i class="SearchBUtton fa fa-search"></i>
                    <input id="searchINput" type="text" placeholder="search" name="search">
                </div>
            </div>

            <div class="profile">
                <i class="fa fa-bell"></i>
            </div>
        </div>
        <h3 class="i-name">
            <?php echo $pageTitle; ?>
        </h3>