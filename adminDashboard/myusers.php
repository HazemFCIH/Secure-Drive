<?php 
session_start();
$alertMessage="";
$status=$upid="";
include('includes/connection.php');
include 'includes/functions.php';
$userid =$_SESSION['loggedInID'];
if($_SESSION['loggedInUserID']==2){
    $admin_or_user=" <th>Full name</th>
        <th>UserName</th>
        <th>send</th>
        <th>Delete</th>";
$query="SELECT users.UserName,users.FullName,approved.id ,approved.sender,approved.reciever "
        . "FROM approved INNER JOIN users ON approved.sender =users.id WHERE approved.reciever='$userid'";
$result1= mysqli_query($conn, $query);
$query1="SELECT users.UserName,users.FullName,approved.id ,approved.sender,approved.reciever "
        . "FROM approved INNER JOIN users ON approved.reciever =users.id WHERE approved.sender='$userid'";
$result2= mysqli_query($conn, $query1);
if(isset($_GET['delid'])){
    $DelID= validateFormData($_GET['delid']);
   $alertMessage ="   
        <div class='alert alert-danger'>
            <p>Are you sure you want to delete this user? No takes back!</p>
            <br>
            <form action='".htmlspecialchars($_SERVER['PHP_SELF'])."?delid=$DelID' method='post'>
                <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Yes, delete!'>
                <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops,no thanks!
                </a>
            </form>
            </div>";
}
if(isset($_POST['confirm-delete'])){
    $DelID= $_GET['delid'];
   $query="DELETE FROM approved WHERE id=('$DelID')";
   $result= mysqli_query($conn, $query);
   if($result){
     header("Location:".htmlspecialchars($_SERVER['PHP_SELF'])."?alert=deleted");  
   }else {
       echo "Error updating record: ".$query. mysqli_error($conn);
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
    if($_SESSION['loggedInUserID']==2){
    if(mysqli_num_rows($result1)>0){
        while ($row= mysqli_fetch_assoc($result1)){
            echo "<tr>";
            echo "<td>".$row['FullName']."</td><td>".$row['UserName']."</td>";
               echo "<td><a href='myfiles.php?appid={$row['sender']}' type='button' class='btn btn-primary btn-sm'>"
            .'<span class="glyphicon glyphicon-edit`"></span>'
                    . 'send file</a></td>';
            echo "<td><a href='".htmlspecialchars( $_SERVER['PHP_SELF'] )."?delid={$row['id']}' type='button' class='btn btn-danger btn-sm'>"
            .'<span class="glyphicon glyphicon-edit`"></span>'
                    . 'Delete</a></td>';
            echo "</tr>";
            
        }
            
        }else {
            echo "<div class='alert alert-warning'>No one accpted your request</div>";
    }
      if(mysqli_num_rows($result2)>0){
        while ($row= mysqli_fetch_assoc($result2)){
            echo "<tr>";
            echo "<td>".$row['FullName']."</td><td>".$row['UserName']."</td>";
               echo "<td><a href='myfiles.php?appid={$row['reciever']}' type='button' class='btn btn-primary btn-sm'>"
            .'<span class="glyphicon glyphicon-edit`"></span>'
                    . 'send file</a></td>';
            echo "<td><a href='".htmlspecialchars( $_SERVER['PHP_SELF'] )."?delid={$row['id']}' type='button' class='btn btn-danger btn-sm'>"
            .'<span class="glyphicon glyphicon-edit`"></span>'
                    . 'Delete</a></td>';
            echo "</tr>";
            
        }
            
        }else {
            echo "<div class='alert alert-warning'>No one sent you a requst</div>";
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