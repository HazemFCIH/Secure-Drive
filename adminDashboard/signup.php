<?php
session_start();
include('includes/connection.php');
include('includes/functions.php');

?>
<?php
$username=$fullname=$email=$password="";
$status='active';
$unameError=$fnameError=$emailError=$passwordError=$telnoError="";
if(isset($_POST['reg_user']))
{


    if(!$_POST["username"])
    {
        $unameError = "Please enter username";
    }
    else
    {
        $username = validateFormData( $_POST["username"] );
    }

    if(!$_POST["fullname"])
    {
        $fnameError = "Please enter your fullname";
    }
    else
    {
        $fullname = validateFormData( $_POST["fullname"] );

        if(!preg_match("/^[a-zA-Z ]*$/",$fullname))
        {
            $fnameError = "Please enter Only letters";
        }
    }



    if(!$_POST["email"])
    {
        $emailError = "Please enter your email";
    }
    else
    {
        $email = validateFormData( $_POST["email"] );
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            $emailError = "Invalid email format"; 
        }

    }


    if(!$_POST["password"])
    {
        $passwordError = "Please enter your password";
    }
    else
    {
        $password_unhash = validateFormData( $_POST["password"] );
        $password = password_hash($password_unhash, PASSWORD_DEFAULT);
    }

    if(!$_POST["telno"])
    {
        $telnoError = "Please enter your Telephone Number";
    }
    else
    {
        $telno = validateFormData( $_POST["telno"] );
    }

    if( $username && $fullname && $email && $password && $telno)
    {
        $query="INSERT INTO users (id, FullName, UserName, Password, status,telephone_number, email, user_type_id) VALUES (NULL, '$fullname', '$username', '$password','$status','$telno', '$email', '2')";
        $result= mysqli_query($conn,$query);
        if($result)
        {
            header("Location:index.php?alert=success");
        }
        else
        {
            echo "Error: ". $query ."<br>" .mysqli_error($conn);
        }
    }


}
mysqli_close($conn);
?>

<!DOCTYPE html><html class=''>
    <head><script src='//production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'></script>
    <meta charset='UTF-8'><meta name="robots" content="noindex">
    <link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" /><link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" /><link rel="canonical" href="https://codepen.io/Lewitje/pen/BNNJjo?limit=all&page=21&q=animation" />
    <link rel="stylesheet" type="text/css" href="css/Login.css">


        <style class="cp-pen-styles">
            @import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300);
        </style>
        <title>Welcome</title>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <h1>Welcome</h1>

                
                <form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post" action="register.php">
                    <div class="row">
                        <div class="col-md-"3>
                            <label for="username" >
                User Name:
            </label>
                        </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="username" placeholder="Enter User Name" name="username">
                <span class="error"><?php echo $unameError;?></span>
            </div>
            <div class="col-md-1">
                <i class="fa fa-lock fa-2x"></i>
            </div>
        </div>        
        <div>
            <label for="fullname" class="col-md-2">
                Full Name:
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="fullname" placeholder="Enter Full Name" name="fullname">
                <span class="error"> <?php echo $fnameError;?></span>
            </div>
            <div class="col-md-1">
                <i class="fa fa-lock fa-2x"></i>
            </div>
        </div>
        <div>
            <label for="emailaddress" class="col-md-2">
                Email address:
            </label>
            <div class="col-md-9">
                <input type="email" class="form-control" id="emailaddress" placeholder="Enter email address" name="email">
                <span class="error"><?php echo  $emailError;?></span>
                <p class="help-block">
                    Example: yourname@domain.com
                </p>
            </div>
            <div class="col-md-1">
                <i class="fa fa-lock fa-2x"></i>
            </div>
        </div>
        <div>
            <label for="password" class="col-md-2">
                Password:
            </label>
            <div class="col-md-9">
                <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
                <span class="error"> <?php echo $passwordError;?></span>
                <p class="help-block">
                    Min: 6 characters (Alphanumeric only)
                </p>
            </div>
            <div class="col-md-1">
                <i class="fa fa-lock fa-2x"></i>
            </div>
        </div>
        <div>
            <label for="Telephone" class="col-md-2">
                Telephone Number:
            </label>
            <div class="col-md-9">
                <input type="tel" class="form-control" id="Telephone"  name="telno">
                <span class="error"><?php echo $telnoError;?></span>
            </div>
            <div class="col-md-1">
                <i class="fa fa-lock fa-2x"></i>
            </div>
        </div>    
        <div class="row">
            <div class="col-md-6">
                <button type="submit" class="btn btn-info" name="reg_user">
                    Register
                </button> 
            </div>
            <div class="col-md-6">
                <a href="index.php" class="btn btn-danger" name="reg_user">
                 back
               </a> 
            </div>
        </div>
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
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script><script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script > $("#login-button").click(function(event){
                event.preventDefault();

                $('form').fadeOut(500);
                $('.wrapper').addClass('form-success');
            });
            //# sourceURL=pen.js
        </script>
    </body></html>
