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
$sendth="";
$send="";
$row="";
$key=md5("fileencryptton");
function  decrypt_data ($chypertext,$key){
      $plaintext = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($chypertext),MCRYPT_MODE_ECB));
      return $plaintext;
  }
if($_SESSION['loggedInUserID']==1){
    $query1="SELECT files.id,files.name,files.user_id,upload_file.secret_key,upload_file.path FROM upload_file 
    INNER JOIN files ON upload_file.file_id =files.id ";    
$result_admin=mysqli_query($conn, $query1);
$admin_or_user='<th>User id</th>';

}

else if ($_SESSION['loggedInUserID']==2) {
$query="SELECT files.id,files.name,upload_file.secret_key,upload_file.path FROM upload_file 
    INNER JOIN files ON upload_file.file_id =files.id 
    WHERE files.user_id='$userID'";
$result5=mysqli_query($conn, $query);
$admin_or_user='<th>delete</th>';

}
include 'includes/header.php';
if(isset($_GET['fileid'])){
    $fileID= validateFormData($_GET['fileid']);
   $alertMessage ="   
        <div class='alert alert-danger'>
            <p>Are you sure you want to delete this client? No takes back!</p>
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
   $query="DELETE FROM upload_file WHERE (upload_file.file_id = $fileID)";
   $result= mysqli_query($conn, $query);
   $query2="DELETE FROM files WHERE (files.id = $fileID)";
   $result1= mysqli_query($conn, $query2);
   if($result & $result1){
     header("Location:".htmlspecialchars($_SERVER['PHP_SELF'])."?alert=deleted");  
   }else {
       echo "Error updating record: ".$query. mysqli_error($conn);
   }
}
if(isset($_GET['alert'])){
    if ($_GET['alert']=='blocked'){
    $alertMessage="<div class='alert alert-danger'>you are blocked from the admin<a class='close' data-dismiss='alert'>&times;</a></div>";     
 }
}
if(isset($_GET['appid'])){
  $sendth="<th>Share</th>";  
}
if(isset($_GET['fileshid'])){
    $appid=$_GET['appid'];
    $shareFile=$_GET['fileshid'];
    $query="INSERT INTO shared_files (id, file_id,sender_user_id,receiver_user_id)"
                . "VALUES(NULL,'$shareFile','$userID','$appid')";
    $result=mysqli_query($conn, $query);
    if($result){
    $alertMessage="<div class='alert alert-success'>file have been sent successfully<a class='close' data-dismiss='alert'>&times;</a></div>";          
    }else {
     echo "Error updating record: ".$query. mysqli_error($conn);   
    }
    
}
/*if(isset($_GET['filepath'])){
   copy($_GET['filepath'],'dycrypted/' .$_GET['filen']);
   decrypt_file('dycrypted/'.$_GET['filen'],$_GET['secc']);
//$downhead="<th>download</th>"; 
   // $disablel="disabled";
    //$downlaodl="<a download='{$_GET['filen']}' href='dycrypted/{$_GET['filen']}' type='button' class='btn btn-success btn-sm'> <span class='glyphicon glyphicon-download'>Download</span></a>";
}*/
?>
<div class="container">
    <?php 
    echo $alertMessage;
    ?>
    <h1>FILES</h1>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="pro">
            <table class="table table-striped table-bordered">
                <tr>
                           
                    <th>file Name</th>
                    <th>Secret key</th>
                                        <th>dycrypte</th>
 <?php 
  echo $admin_or_user;
                     echo $sendth;
 ?>                                
                   

                    
                </tr>
                <?php 
                if($_SESSION['loggedInUserID']==1){
                         if(mysqli_num_rows($result_admin)>0){
                    while ($row= mysqli_fetch_assoc($result_admin)){
                        echo "<tr>";
                        echo "<td>{$row['user_id']}</td>";
                        echo "<td>".$row['name']."</td><td>".$row['secret_key']."</td>";
                        
                        echo "<td><a href='dycrypt.php?filepath={$row['path']}&secc={$row['secret_key']}&filen={$row['name']}' type='button' class='btn btn-success btn-sm'>"
                            .'<span class="glyphicon glyphicon-edit">dycrypte</span>'
                            . '</a></td>';
                 
                        echo "</tr>";
}    
                    
                    
                }
                }else{
         if(mysqli_num_rows($result5)>0){
                    while ($row= mysqli_fetch_assoc($result5)){
                        echo "<tr>";
                        echo "<td>".$row['name']."</td><td>".$row['secret_key']."</td>";
                        
                        echo "<td><a href='dycrypt.php?filepath=".decrypt_data($row['path'],$key)."&secc={$row['secret_key']}&filen={$row['name']}' type='button' class='btn btn-success btn-sm'>"
                            .'<span class="glyphicon glyphicon-edit">dycrypte</span>'
                            . '</a></td>';
                        echo "<td><a href='".htmlspecialchars( $_SERVER['PHP_SELF'] )."?fileid={$row['id']}' type='button' class='btn btn-danger btn-sm'>"
            .'<span class="glyphicon  glyphicon-remove">Delete</span>'
                    . '</a></td>';
                   /* echo '<td>'
                        .$downlaodl. '<td>';*/
                        if(isset($_GET['appid'])){
                            $appid=$_GET['appid'];
                        echo  "<td><a href='".htmlspecialchars( $_SERVER['PHP_SELF'] )."?fileshid={$row['id']}&appid={$appid}' type='button' class='btn btn-primary btn-sm'>"
            .'<span class="glyphicon  glyphicon-edit">share</span>'
                    . '</a></td>';}
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