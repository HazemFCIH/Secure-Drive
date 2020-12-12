<?php
session_start();

include('includes/header.php');
include('includes/connection.php');
include('includes/functions.php');
$id=$username=$fullname=$email=$telephone_number="";
$uname=$_SESSION['loggedInUser'];
$query="SELECT * FROM users WHERE UserName='$uname'";
$result = mysqli_query($conn,$query);

mysqli_close($conn);
?>
<table class="table table-striped table-borderd">
    <tr>
        <th>ID</th>
        <th>UserName</th>
        <th>FullName</th>
        <th>email</th>
        <th>Telephone Number</th>
    </tr>
    <?php
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            echo "<tr>";
            echo "<td>" . $row{'id'} . "</td><td>" . $row{'FullName'} . "</td><td>" . $row{'email'} . "</td><td>"
                . $row{'telephone_number'} . "</td><td>" . $row{'UserName'}  . "</td>";
        }
    }

    ?>
</table>
<?php include('includes/footer.php');?>