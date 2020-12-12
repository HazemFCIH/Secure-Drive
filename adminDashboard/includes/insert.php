<?php

include('connection.php');

if(mysqli_query($conn,$query_user))
{
    echo "success";
}
else
{
    echo "Error: ". $query_user ."<br>" .mysqli_error($conn);
}

if(mysqli_query($conn,$query_date))
{
    echo "success";
}
else
{
    echo "Error: ". $query_user ."<br>" .mysqli_error($conn);
}
?>