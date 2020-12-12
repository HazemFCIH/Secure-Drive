<?php 
$server = "localhost";
$username ="root";
$password ="";
$db ="security";
// create a connection
$conn = mysqli_connect($server, $username, $password, $db);
// check connection
if(!$conn){
    die("connection failed: ". mysqli_connect_error() );

} else {
//echo "connected succesfully v1v1";
}
?>