<?php
session_start();
include('includes/connection.php');
include('includes/functions.php');
$hashpass="";

if( isset( $_POST['login']) )
{
    $formEmail= validateFormData($_POST['email']);
    $formPass= validateFormData($_POST['password']);
    include('includes/connection.php');
    $query="SELECT id,UserName,password,status,user_type_id FROM users WHERE email='$formEmail'";
    $result = mysqli_query($conn, $query);
    if( mysqli_num_rows( $result )>0)
    {
        while ($row= mysqli_fetch_assoc($result))
        {
        $_SESSION['loggedInUser']= $row['UserName'];
         $_SESSION['loggedInID']= $row['id'];
         $_SESSION['loggedInUserID']=$row['user_type_id'];
         $_SESSION['UserStatus']=$row['status'];
        $userID=$row['user_type_id'];
        $hashpass=$row['password'];
        }
        if(password_verify($formPass, $hashpass))
        {
        header("Location: myfiles.php?id=$userID");
        }else{
              $loginError= "<div class='alert alert-danger'>Wrong password . Try again.</div>";
        } 
    }else
    {

        $loginError= "<div class='alert alert-danger'>Wrong username/password combination. Try again.</div>";
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html><html class=''>
    <head><script src='//production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'></script>
    <meta charset='UTF-8'><meta name="robots" content="noindex">
    <link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" /><link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" /><link rel="canonical" href="https://codepen.io/Lewitje/pen/BNNJjo?limit=all&page=21&q=animation" />
    <link rel="stylesheet" type="text/css" href="css/Login.css">


        <style class="cp-pen-styles">
            @import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300);
        </style>
        <title>Welcome to SecureMyFile</title>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <h1>Welcome to SecureMyFile</h1>

                <?php
                if(!empty($loginError))
                {
                    echo $loginError;
                }
                ?>
                <form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF']);?>" class="form-inline" method="post">
                    <div class="form-group">
                        <label for="login-email" class="sr-only"></label>
                        <input type="text" class="form-control"  id="login-email" placeholder="Email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="login-password" class="sr-only"></label>
                        <input type="password" class="form-control"  id="login-password" placeholder="Password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary" name="login">Login</button>
                    <br>
                    <br>
                    <p>if you don't have an account <a href="signup.php" class="sign up ">Sign up from here</a></p>
                </form>
                
            </div>

            <ul class="bg-bubbles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
        <script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script><script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script > $("#login-button").click(function(event){
                event.preventDefault();

                $('form').fadeOut(500);
                $('.wrapper').addClass('form-success');
            });
            //# sourceURL=pen.js
        </script>
    </body></html>
