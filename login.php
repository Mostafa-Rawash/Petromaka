<?php


    session_start();
    $noNavbar ='';
    $pageTitle = 'login';

    ?>

<script src="https://www.google.com/recaptcha/enterprise.js?render=6Lc9CPYhAAAAAPJYidyFLFRrSnPEHbOJQkozR90R"></script>
<script>
grecaptcha.enterprise.ready(function() {
    grecaptcha.enterprise.execute('6Lc9CPYhAAAAAPJYidyFLFRrSnPEHbOJQkozR90R', {action: '<?php echo $_SERVER['PHP_SELF']?>'}).then(function(token) {
       ...
    });
});
</script>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>


<?php 



    if(isset($_SESSION['username'])){
        echo "<script>window.location='profile.php'</script>"; //rediredt to the dashboard if iam already loged in before
    }
    include 'init.php';

    // check if the user coming from https post Request

    if($_SERVER ['REQUEST_METHOD'] =='POST'){

        function CheckCaptcha($userResponse){
            $fields_string = '';
            $fields = array(
                'secret' =>'6Lcn-fYhAAAAAP6GuFzFjjowgff6K-V8YR6KCmIT',
                'response' => $userResponse
            );

            foreach($fields as $key=>$value)
            $fields_string .= $key . '=' . $value . '&';
            $fields_string = rtrim($fields_string, '&');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

            $res = curl_exec($ch);
            curl_close($ch);

            return json_decode($res, true);
        }

        $result = checkCaptcha($_POST['g-recaptcha-response']);

        $workerid = $_POST['workerid'];
        $password = $_POST['password'];
        

        $workerid = htmlspecialchars_decode(trim($workerid));
        $password = htmlspecialchars_decode(trim($password));

        $workerid = intval($workerid);
        // make the passwords invisble

        // check if the user in database or not

        $stmt = $con->prepare("SELECT 
                                    *
                                    FROM 
                                        workers 
                                    WHERE 
                                        idnumber = ?  
                                    AND 
                                        password = ? 
                                    
                                    LIMIT 1");

        $stmt->execute(array($workerid , $password));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        

        //check if count >0 this mean the database contain record about this username

        // if($result['success']){

        if($count > 0){


            $_SESSION ['username'] = $row['idnumber'];
            $IncreasecurVisitors = $con->prepare("UPDATE stats SET number = number + 1 Where name ='currentvisit'");
            $IncreasecurVisitors->execute();

             //register sessoon name
            $_SESSION['ID'] = $row['id']; //register session ID
            echo "<script>window.location='profile.php'</script>"; // redirect to dashboard page
            exit();

            
        }else{
            echo"<div class='error-message'><h1>Check your user name or password</h1></div>";


        }

        
    // }else{
    //     echo "<script>alert('Please check Im not a Ropot')</script>";
    // }

    }
?>




<div class="login-page">


<div class="container">
    <div class="row">
        <div class="form-content">
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">

            <img src="images/default.png">

            <div class="input-div">
                <label>  الرقم التعريفي للعامل </label>
                <input type="number" required name="workerid">
            </div>

            <div class="input-div">
                <label> كلمة المرور</label>
                <input id="showme" type="password" required name="password">

                <div>
                <input class="show-password-input" type="checkbox" onclick="ShowPassword()">Show Password
                </div>
                <script>
                    function ShowPassword() {
                        var x = document.getElementById("showme");
                        if (x.type === "password") {
                            x.type = "text";
                        } else {
                            x.type = "password";
                        }
                        }
                        </script>
            </div>

            <div class="button-div">
                <button type="submit">تسجيل الدخول</button>
                <button type="button" onclick="backhome();"> <i class="fa-solid fa-left-long"></i> الرجوع</button>
                
            </div>

            <div class="g-recaptcha" data-sitekey="6Lcn-fYhAAAAAP6_e-ypI0kxO3wpBVJ6eA447LUl"></div>

            
            </form>
        </div>
    </div>
</div>

</div>




<?php include  $tpl ."footer.php";?>