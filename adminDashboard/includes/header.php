<?php 
if(!$_SESSION['loggedInUser']){
     header("Location: index.php");
 } else {
     
 $lipa='';
 $typeHeader='';
$user =$_SESSION['loggedInUser'];

 }
 if(!$_SESSION['loggedInUserID']==NULL){
     if($_SESSION['loggedInUserID']==2){
         $typeHeader='<a class="navbar-brand" href="../admindashboard/myfiles.php">User Panel</a>';
     //<li><a href="add_user.php"><i class="fa fa-bullseye"></i>Add users</a></li>
     $lipa=' <li >
                <li><a href="myfiles.php"><i class="fa fa-bullseye"></i>my files</a></li>
                        <li><a href="shared_files.php"><i class="fa fa-bullseye"></i>Shared files</a></li>
                <li><a href="add_file.php"><i class="fa fa-bullseye"></i>upload file</a></li>                            
<li><a href="users.php"><i class="fa fa-bullseye"></i>requst users</a></li>
<li><a href="request.php"><i class="fa fa-bullseye"></i>My requests</a></li>
<li><a href="myusers.php"><i class="fa fa-bullseye"></i>my users</a></li>
';
     
     
 }else if($_SESSION['loggedInUserID']==1){
             $typeHeader='<a class="navbar-brand" href="../admindashboard/myfiles.php">Admin Panel</a>';
                $lipa=' <li >
                <li><a href="myfiles.php"><i class="fa fa-bullseye"></i>all files</a></li>
                <li><a href="add_file.php"><i class="fa fa-bullseye"></i>upload file</a></li>                            
                                <li><a href="users.php"><i class="fa fa-bullseye"></i>all users</a></li>';
     
 }}
 else {
     header("Location: index.php") ;   
}
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Dark Admin</title>

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="css/local.css" />


    <!-- you need to include the shieldui css and js assets in order for the charts to work -->
    <link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light-bootstrap/all.min.css" />
    <link id="gridcss" rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/dark-bootstrap/all.min.css" />

</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
            echo $typeHeader;
            ?>
   
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
        
        
            <ul id="active" class="nav navbar-nav side-nav">
               
    
                   <?php 
                   echo $lipa;
                   ?>
 </ul>
           
            <ul class="nav navbar-nav navbar-right navbar-user">
                <li class="dropdown user-dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $user;?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="profile.php"><i class="fa fa-user"></i> Profile</a></li>
                    
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-power-off"></i> Log Out</a></li>

                    </ul>
                </li>
                <li class="divider-vertical"></li>
           
            </ul>
        </div>
    </nav>
