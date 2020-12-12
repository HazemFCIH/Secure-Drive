<?php 
session_start();
include 'includes/connection.php';
include 'includes/functions.php';
$userID=$_SESSION['loggedInID'];
$fileID="";
$alertMessage="";
$downhead="";
$disablel="";
$downlaodl="";
$admin_or_user="";
$adminth="";
$key=md5("fileencryptton");
function  decrypt_data ($chypertext,$key){
      $plaintext = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($chypertext),MCRYPT_MODE_ECB));
      return $plaintext;
  }
if($_SESSION['loggedInUserID']==2){
$query="SELECT upload_file.secret_key,upload_file.path,shared_files.sender_user_id,upload_file.file_id,files.name FROM upload_file,files,shared_files 
    WHERE shared_files.file_id=upload_file.file_id AND 
    upload_file.file_id=files.id AND shared_files.receiver_user_id='$userID'";
$result1=mysqli_query($conn, $query);
if($result1){
    echo 'good for you';
} else {
 echo "Error shared record: ".$query. mysqli_error($conn);   
}
}
include 'includes/header.php';
if(isset($_GET['fileid'])){
    $fileID= validateFormData($_GET['fileid']);
   $alertMessage ="   
        <div class='alert alert-danger'>
            <p>Are you sure you want to delete this file? No takes back!</p>
            <br>
            <form action='".htmlspecialchars($_SERVER['PHP_SELF'])."?id=$fileID' method='post'>
                <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Yes, delete!'>
                <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops,no thanks!
                </a>
            </form>
            </div>";
}
if(isset($_POST['confirm-delete'])){
   $fileID=$_GET['id'];
   $query="DELETE FROM shared_files WHERE (shared_files.file_id = $fileID)";
   $result= mysqli_query($conn, $query);
 
   if($result){
     header("Location:".htmlspecialchars($_SERVER['PHP_SELF'])."?alert=deleted");  
   }else {
       echo "Error updating record: ".$query. mysqli_error($conn);
   }
}
?>
<div class="container">
    <?php 
    echo $alertMessage;
    ?>
    <h1>Shared FILES</h1>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="pro">
            <table class="table table-striped table-bordered">
                <tr>
                          
                    <th>file Name</th>
                    <th>Secret key</th>
                                        <th>dycrypte</th>
                                        <th> Delete </th>
                                       
                </tr>
                <?php 
if($_SESSION['loggedInUserID']==2){
         if(mysqli_num_rows($result1)>0){
                    while ($row= mysqli_fetch_assoc($result1)){
                        echo "<tr>";
                        echo "<td>".$row['name']."</td><td>".$row['secret_key']."</td>";
                        
                        echo "<td><a href='dycrypt.php?filepath={$row['path']}&secc={$row['secret_key']}&filen={$row['name']}' type='button' class='btn btn-success btn-sm'>"
                            .'<span class="glyphicon glyphicon-edit">dycrypte</span>'
                            . '</a></td>';
                        echo "<td><a href='".htmlspecialchars( $_SERVER['PHP_SELF'] )."?fileid={$row['file_id']}' type='button' class='btn btn-danger btn-sm'>"
            .'<span class="glyphicon  glyphicon-remove">Delete</span>'
                    . '</a></td>';
                   /* echo '<td>'
                        .$downlaodl. '<td>';*/
                        echo "</tr>";

         }}else{
             $alertMessage ="<div class='alert alert-warning'>you have no files!</div>";
              echo        $alertMessage;
             
                }}
                ?>
                <tr>
                    <td colspan="7"><div class="text-center"><a href="add_file.php" type="button" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus"></span>Add File</a></div></td>
                </tr>

            </table>   
        </div>
    </div>

</div>
<?php 
include 'includes/footer.php';

?>