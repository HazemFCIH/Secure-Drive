
<?php 
function decrypt_file($file,$passphrase){
  $iv = substr(md5("\x18\x3C\x58".$passphrase,true),0,8);
  $key = substr(md5("\x2D\xFC\xD8".$passphrase,true).md5("\x2D\xFC\xD8".$passphrase,true),0,24);
  $opts = array('iv'=>$iv, 'key'=>$key);
  $fp = fopen($file,'r+');
  stream_filter_append($fp, 'mdecrypt.tripledes', STREAM_FILTER_READ, $opts);
  $data = rtrim(stream_get_contents($fp));//trims off null padding
  fclose($fp);
  $fp = fopen($file,'w');
   fwrite($fp,"". $data) or die('Could not write to file');
     fclose($fp);
  //return $fp;
}
session_start();
$userID=$_SESSION['loggedInID'];

$alertMessage=$productID=$disablel=$downlaodl="";
$seckey="";
include 'includes/connection.php';
include 'includes/functions.php';
$filepath=$_GET['filepath'];
//echo $filepath;
$filen=$_GET['filen'];
$secc=$_GET['secc'];
if(isset($_POST['dycrypt_btn'])){
    if($_POST['seckey']){
    $seckey=validateFormData($_POST['seckey']);
    if(isset($filepath)){
   copy($filepath,'dycrypted/' .$filen);
   if($seckey==$secc){
   decrypt_file('dycrypted/'.$filen,$seckey);
   $disablel="disabled";
    $downlaodl="<a download='{$_GET['filen']}' href='dycrypted/{$_GET['filen']}' type='submit' name='down_btn' class='btn btn-success btn-sm'> <span class='glyphicon glyphicon-download'>Download</span></a>";
    /*if(isset($_POST['down_btn'])){
    unlink('dycrypted/'.$filen);}*/
   }else {
       $alertMessage="<div class='alert alert-warning'>please insert a correct key first<a class='close' data-dismiss='alert'>&times;</a></div>";
       
   }
//$downhead="<th>download</th>"; 
    
}
    }
 else {
        $alertMessage="<div class='alert alert-warning'>please insert key first<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
    
}
include 'includes/header.php';
?>
<div class="container">
    <?php 
    echo $alertMessage;
    ?>
    <h1 class="lead">Add File</h1>
    
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?filepath={$_GET['filepath']}&filen={$_GET['filen']}&secc={$_GET['secc']}";?>" method="post" enctype="multipart/form-data" class="row">
       
       
        <div class="col-sm-8 col-sm-offset-2">
               <input type="text" class="form-control" id="secret key" placeholder="write your secret key" name="seckey">
            
        </div>

        <div class="col-sm-8 col-sm-offset-2">
            <br>
            <a href="myfiles.php" type="button" class="btn btn-sm btn-default">Cancel</a>
            <button type="submit" class="btn btn-sm btn-warning pull-right" name="dycrypt_btn" <?php
                        echo $disablel;
            ?>>Dycrypte file</button>
            <?php
            echo $downlaodl;
            ?>
        </div>
        
    </form>
    <br><br>


</div>

<?php
include('includes/footer.php');
?>