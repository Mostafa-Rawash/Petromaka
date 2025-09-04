<?php

    ob_start();  //out put buffering start
    

    session_start();
    if(isset($_SESSION['UserName'])){
    $pageTitle = 'لوحة التحكم';

        include 'init.php';

        $Workers = $con->prepare("SELECT * From workers");
        

        $Workers->execute();
        



        $WorkersData = $Workers->fetchAll();

        $WorkersCount = $Workers->rowCount();
        

        ?>


    <section id="interface">
    <?php include  $tpl.'second-navbar.php'; ?>

        <div class="values">
            <div class="val-box">
            <a href="workers.php"><i class="las la-globe"></i></a>
                <div>
                    <h3>
                        <?php
                        echo $WorkersCount;
                        ?>
                    </h3>
                    <span>العاملين </span>
                </div>
            </div>


        </div>

        <div class="board">
            <table width="100%">
                <thead>
                <tr>
                        <td>الصورة</td>
                        <td>الاسم</td>
                        <td>رقم العامل</td>
                        <td>الموقع</td>
                        <td>حالة الحساب</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>

                <?php if(! empty($WorkersData)){
                    foreach($WorkersData as $worker){
                    ?>
                    <tr>

                        

                    <td class="people">
                            <?php 
                            echo '<img src="../workers/'. $worker['image'] .'" alt="">';
                            ?>
                        </td>

                        
                        <td class="people-dec">
                            <h5><?php echo $worker['name']; ?></h5>
                        </td>

                        <td class="people-dec">
                            <h5><?php echo $worker['idnumber']; ?></h5>
                        </td>

                        <td class="people-dec">
                            <h5><?php echo $worker['location']; ?></h5>
                        </td>

                        <td class="people-dec">
                            <?php
                                if($worker['active'] == 0){
                                    echo "<h5> غير مفعل </h5>";
                                }else{
                                    echo "<h5>مفعل</h5>";
                                }
                            ?>
                        </td>

                        <td class="edit">
                            <?php echo '<a href="workers.php?do=edit&workerId=' . $worker['id'] . '">Edit</a>'; ?>
                        </td>

                    </tr>
                <?php 
                }
            }
            ?>

                </tbody>
            </table>
        </div>
    </section>





<?php



        // end dashboard page

        include  $tpl ."footer.php";

}else{
    header ('location: index.php');
    exit();
}

ob_end_flush();
?>