<?php

session_start();
$noNavbar = '';
$pageTitle = 'login';



if (isset($_SESSION['UserName'])) {
    header('location: dashboard.php'); //rediredt to the dashboard if iam already loged in before
}
include 'init.php';
include $tpl . 'header.php';

// check if the user coming from https post Request

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $UserName = $_POST['user'];
    $password = $_POST['pass'];

    $UserName = htmlspecialchars_decode(trim($UserName));
    $password = htmlspecialchars_decode(trim($password));
    // make the passwords invisble

    // check if the user in database or not

    $stmt = $con->prepare("SELECT 
                                    id, username , password 
                                    FROM 
                                        admin 
                                    WHERE 
                                        username = ?  
                                    AND 
                                        password = ? 
                                    
                                    LIMIT 1");

    $stmt->execute(array($UserName, $password));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();


    //check if count >0 this mean the database contain record about this username

    if ($count > 0) {

        $_SESSION['UserName'] = $UserName; //register sessoon name
        $_SESSION['ID'] = $row['id']; //register session ID
        header('Location: dashboard.php'); // redirect to dashboard page
        exit();


    } else {
        echo "<div class='error-message'><h1>Check your user name or password</h1></div>";
    }

}
?>
<div class="login-admin-page">
<div class="center">
    <h1>Admin | Login</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="txt_field">
            <input type="text" name="user"  required autocomplete="off">
            <span></span>
            <label>Username</label>
        </div>
        <div class="txt_field">
            <input type="password" name="pass" required autocomplete="new-password">
            <span></span>
            <label>Password</label>
        </div>
        <div class="pass">Forgot Password? </div>
        <input type="submit"  value="Login">
    </form>

</div>

</div>



<?php include $tpl . "footer.php"; ?>