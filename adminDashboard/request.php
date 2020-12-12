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
        <th>accept</th>
        <th>Delete</th>";
$query="SELECT users.UserName,users.FullName,request.id ,request.sender_id,request.reciever_id FROM request 
    INNER JOIN users ON request.sender_id =users.id WHERE request.reciever_id='$userid'";
$result1= mysqli_query($conn, $query);
if(isset($_GET['delid'])){
    $DelID= validateFormData($_GET['delid']);
   $alertMessage ="   
        <div class='alert alert-danger'>
            <p>Are you sure you want to delete this request? No takes back!</p>
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
   $query="DELETE FROM request WHERE id=('$DelID')";
   $result= mysqli_query($conn, $query);
   if($result){
     header("Location:".htmlspecialchars($_SERVER['PHP_SELF'])."?alert=deleted");  
   }else {
       echo "Error updating record: ".$query. mysqli_error($conn);
   }
}
if(isset($_GET['reqsid'])){
  $ReqsId=validateFormData($_GET['reqsid']);  
           $query="INSERT INTO approved (id,sender, reciever)"
                    . "VALUES(NULL,$ReqsId,$userid)";
                     $result1= mysqli_query($conn, $query);
                if($result1){
                    $DelID=$_GET['reqdid'];
                          $query="DELETE FROM request WHERE id=('$DelID')";
   $result= mysqli_query($conn, $query);
   if($result){
     header("Location:".htmlspecialchars($_SERVER['PHP_SELF'])."?alert=accept");  
   }else {
       echo "Error delete record: ".$query. mysqli_error($conn);
   }
                } else {
                    echo "ERROR requst-imf:".$query. mysqli_error($conn); 
                }
    
}
if(isset($_GET['alert'])){
    if($_GET['alert']=='deleted'){
     $alertMessage="<div class='alert alert-warning'>requset  deleted!<a class='close' data-dismiss='alert'>&times;</a></div>";   
} else if($_GET['alert']=='accept'){
   $alertMessage="<div class='alert alert-success'>user is accpted!<a class='close' data-dismiss='alert'>&times;</a></div>";       
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
               echo "<td><a href='".htmlspecialchars( $_SERVER['PHP_SELF'] )."?reqsid={$row['sender_id']}&reqdid={$row['id']}' type='button' class='btn btn-success btn-sm'>"
            .'<span class="glyphicon glyphicon-edit`">accept</span>'
                    . '</a></td>';
            echo "<td><a href='".htmlspecialchars( $_SERVER['PHP_SELF'] )."?delid={$row['id']}' type='button' class='btn btn-danger btn-sm'>"
            .'<span class="glyphicon glyphicon-edit`">Delete</span>'
                    . '</a></td>';
            echo "</tr>";
            
        }
            
        }else {
            echo "<div class='alert alert-warning'>you have no users</div>";
    }}
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