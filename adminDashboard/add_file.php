<?php 

function encrypt_file($file, $destination, $passphrase){
  $handle = fopen($file, "rb") or die("could not open the file");
  $contents = fread($handle,filesize($file));
  fclose($handle);
  $iv = substr(md5("\x18\x3C\x58".$passphrase,true),0,8);
  $key = substr(md5("\x2D\xFC\xD8".$passphrase,true).md5("\x2D\xFC\xD8".$passphrase,true),0,24);
  $opts = array('iv'=>$iv, 'key'=>$key);
  $fp = fopen($destination,'wb') or die("Could not opn file for writing");
  stream_filter_append($fp, 'mcrypt.tripledes',STREAM_FILTER_WRITE, $opts);
  fwrite($fp, $contents) or die('Could not write to file');
  fclose($fp);
  }
  function  encrypt_data ($plaintext,$key){
      $cyphertext = rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $plaintext, MCRYPT_MODE_ECB)));
  
      return $cyphertext;
  }
/*function decrypt_file($file,$passphrase){
        $iv = substr(md5("\x18\x3c\x58".$passphrase,TRUE),0,8);
 $key= substr(md5("\x2D\xFC\xD8".$passphrase,TRUE).md5("\x2D\xFC\xD8".$passphrase,TRUE),0,24);
     $opts = array('iv'=>$iv,'key'=>$key);
$fp = fopen($file, 'rb');
stream_filter_append($fp,'mdecrypt.tripledes',STREAM_FILTER_READ,$opts);
}*/
?>
<?php 
session_start();
if($_SESSION['UserStatus']=='blocked'){
      header("Location: myfiles.php?alert=blocked");  
}
$adminID=$_SESSION['loggedInID'];
echo $adminID;
$alertMessage=$fileID="";
$errorProName=$errorUploadFile="";
include 'includes/connection.php';
include 'includes/functions.php';
if(isset($_POST['add_file_btn'])){
  
        $fileName= validateFormData($_FILES['uploadfile']['name']);
        $query=" SELECT * FROM files WHERE name='$fileName'";
        $get_file=mysqli_query($conn,$query);
        if(mysqli_num_rows( $get_file ) > 0)
        {
            $errorProName="Details Are Already Submitted";
        }
    
  
    if(!$_FILES['uploadfile']['name']){
        $errorUploadFile="please add file to encrypt  ";
    } else {
        $fileUploadFile= validateFormData($_FILES['uploadfile']['name']);
    }

    if($_FILES['uploadfile']['name']){
        $target_path="encrypted/";
        $target_path=$target_path.basename($_FILES['uploadfile']['name']);
     
                $filename =$_FILES['uploadfile']['name'];
                $blowfish_key = "$2y$10$".bin2hex(openssl_random_pseudo_bytes(10));
$key= md5("fileencryptton");
        if(move_uploaded_file($_FILES['uploadfile']['tmp_name'],$target_path)){
                       $filename=$_SERVER['DOCUMENT_ROOT']."/Securityproject/admindashboard/encrypted/".$_FILES['uploadfile']['name'];
                   encrypt_file($filename,$_SERVER['DOCUMENT_ROOT']."/Securityproject/admindashboard/encrypted/".basename($_FILES['uploadfile']['name']),$blowfish_key);
            $query="INSERT INTO files (id,name,user_id)"
                . "VALUES(NULL,'$fileName','$adminID')";
            $result= mysqli_query($conn, $query);
            if($result){
                $fileID= mysqli_insert_id($conn);
                $query="INSERT INTO upload_file (id,path,file_id,secret_key)"
                    . "VALUES(NULL,'".encrypt_data($target_path,$key)."','$fileID','$blowfish_key')";
     


                $result1= mysqli_query($conn, $query);
                if($result1){
                    $alertMessage ="<div class='alert alert-success'>FIle uploaded successfily<a class='close' data-dismiss='alert'>&times;</a></div>";    
                } else {
                    echo "ERROR Add file-imf:".$query. mysqli_error($conn); 
                }
            }else {
                echo "ERROR Add file:".$query. mysqli_error($conn);
            }

        }

    } else {
        $alertMessage ="<div class='alert alert-warning'>Somthing is went wrong<a class='close' data-dismiss='alert'>&times;</a></div>";    

}}
include 'includes/header.php';
?>
<div class="container">
    <?php 
    echo $alertMessage;
    ?>
    <h1 class="lead">Add File</h1>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data" class="row">
       
       
        <div class="col-sm-8 col-sm-offset-2">
            <input type="hidden" value="1000000" name="MAX_FILE_SIZE"  class="form-control input-sm">
            <input type="file" name="uploadfile"  class="form-control input-sm">
            <P class="text-danger"><?php 
                echo $errorUploadFile;
                ?></P>
        </div>

        <div class="col-sm-8 col-sm-offset-2">
            <br>
            <a href="myfiles.php" type="button" class="btn btn-sm btn-default">Cancel</a>
            <button type="submit" class="btn btn-sm btn-warning pull-right" name="add_file_btn" v>Encrypt file</button>
        </div>
    </form>
    <br><br>


</div>

<?php
include('includes/footer.php');
?>