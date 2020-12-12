<?php 
session_start();
$alertMessage="";
$admin_or_user="";
$status=$upid="";

include('includes/connection.php');
include 'includes/functions.php';
$userid =$_SESSION['loggedInID'];
if($_SESSION['loggedInUserID']==1){
    $admin_or_user=" <th>Full name</th>
        <th>UserName</th>
        <th>Telephone number</th>
        <th>email</th>
        <th>status</th>
        <th>Delete</th>";
$query="SELECT * FROM users WHERE user_type_id=2 ";
$result1= mysqli_query($conn, $query);
if(isset($_GET['id'])){
    $userID= validateFormData($_GET['id']);
   $alertMessage ="   
        <div class='alert alert-danger'>
            <p>Are you sure you want to delete this user? No takes back!</p>
            <br>
            <form action='".htmlspecialchars($_SERVER['PHP_SELF'])."?id=$userID' method='post'>
                <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Yes, delete!'>
                <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops,no thanks!
                </a>
            </form>
            </div>";
}
if(isset($_POST['confirm-delete'])){
   
   $query="DELETE FROM users WHERE id=('$userID')";
   $result= mysqli_query($conn, $query);
   if($result){
     header("Location:".htmlspecialchars($_SERVER['PHP_SELF'])."?alert=deleted");  
   }else {
       echo "Error updating record: ".$query. mysqli_error($conn);
   }
}
if(isset($_GET['alert'])){
    if($_GET['alert']=='deleted'){
     $alertMessage="<div class='alert alert-warning'>user is deleted!<a class='close' data-dismiss='alert'>&times;</a></div>";   
} else if ($_GET['alert']=='blocked'){
    $alertMessage="<div class='alert alert-warning'>user is blocked!<a class='close' data-dismiss='alert'>&times;</a></div>";     
 }else if($_GET['alert']=='active'){
   $alertMessage="<div class='alert alert-success'>user is activeted!<a class='close' data-dismiss='alert'>&times;</a></div>";       
 }
    }
if(isset($_GET['status'])){
   if($_GET['status']=='active'){
    $upid=$_GET['userid'];
    $query="UPDATE users SET users.status = 'blocked' WHERE users.id = {$upid};";
$result= mysqli_query($conn, $query);
if($result){
      header("Location:".htmlspecialchars($_SERVER['PHP_SELF'])."?alert=blocked");  
   
    
}else {
   echo "Error updating record: ".$query. mysqli_error($conn);  
}
   } else if($_GET['status']=='blocked'){
           $upid=$_GET['userid'];
        $query="UPDATE users SET users.status = 'active' WHERE users.id = {$upid};";
$result= mysqli_query($conn, $query);
if($result){
     header("Location:".htmlspecialchars($_SERVER['PHP_SELF'])."?alert=active");  
}else {
   echo "Error updating record: ".$query. mysqli_error($conn);  
}   
   }
    
}

    }else if($_SESSION['loggedInUserID']==2){
    $query="SELECT users.FullName,users.UserName,users.id FROM users WHERE user_type_id=2 AND users.id !='$userid'";
$result= mysqli_query($conn, $query);
if($result)
{
    echo 'good for you';
} else {
   echo "ERROR users-imf:".$query. mysqli_error($conn);   
}
        $admin_or_user=" <th>Full name</th>
        <th>UserName</th>
        <th>Requst</th>";
        if(isset($_GET['reqid'])){
            $ruserid=$_GET['reqid'];
                $query="INSERT INTO request (id,sender_id, reciever_id)"
                    . "VALUES(NULL,$userid,$ruserid)";
                     $result1= mysqli_query($conn, $query);
                if($result1){
                    $alertMessage ="<div class='alert alert-success'>requst sent successfully <a class='close' data-dismiss='alert'>&times;</a></div>";    
                } else {
                    echo "ERROR requst-imf:".$query. mysqli_error($conn); 
                }
        }
}


include('includes/header.php');
?>
<div class="container">
    <?php 
    echo $alertMessage;
    ?>
   <table class="table table-striped table-bordered">
    <tr>
       <?php 
           echo $admin_or_user;
       ?>
    </tr>
    <?php 
    if($_SESSION['loggedInUserID']==1){
    if(mysqli_num_rows($result1)>0){
        while ($row= mysqli_fetch_assoc($result1)){
            echo "<tr>";
            echo "<td>".$row['FullName']."</td><td>".$row['UserName']."</td><td>".$row['telephone_number']."</td><td>".$row['email']."</td>";
            if($row['status']=='active'){
            echo "<td><a href='".htmlspecialchars( $_SERVER['PHP_SELF'] )."?status={$row['status']}&userid={$row['id']}' type='button' class='btn btn-success btn-sm'>"
            .'<span class="glyphicon glyphicon-edit`">'.$row["status"].'</span>'
            . '</a></td>';
            
            }else if($row['status']=='blocked'){
                    echo "<td><a href='".htmlspecialchars( $_SERVER['PHP_SELF'] )."?status={$row['status']}&userid={$row['id']}' type='button' class='btn btn-warning btn-sm'>"
            .'<span class="glyphicon glyphicon-edit`">'.$row["status"].'</span>'
            . '</a></td>';
                
            }
            echo "<td><a href='".htmlspecialchars( $_SERVER['PHP_SELF'] )."?id={$row['id']}' type='button' class='btn btn-danger btn-sm'>"
            .'<span class="glyphicon glyphicon-edit`">Delete</span>'
                    . '</a></td>';
            echo "</tr>";
            
        }
            
        }else {
            echo "<div class='alert alert-warning'>you have no users</div>";
    }}else if($_SESSION['loggedInUserID']==2){
         if(mysqli_num_rows($result)>0){
        while ($row= mysqli_fetch_assoc($result)){  
         echo "<tr>";    
         echo "<td>".$row['FullName']."</td><td>".$row['UserName']."</td>";
             echo "<td><a href='".htmlspecialchars( $_SERVER['PHP_SELF'] )."?reqid={$row['id']}' type='button' class='btn btn-primary btn-sm'>" 
                    .'<span class="glyphicon glyphicon-chevron-right"></span>'
                    . 'Add User</a></td>';
                         echo "</tr>";

         
            
        }
        }  else {
            echo "<div class='alert alert-warning'>you have no users to requst</div>";
    }
    }
        mysqli_close($conn);
    ?>
  
    <tr>
       <!-- <td colspan="7"><div class="text-center"><a href="add_user.php" type="button" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus"></span> Add user</a></div></td>-->
    </tr>
</table>
</div>
<?php 
include 'includes/footer.php';
?>