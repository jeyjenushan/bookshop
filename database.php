<?php

$db_server="localhost";
$db_user="root";
$db_pass="";
$db_name="businessdb";
$conn="";

try{
    if($conn=mysqli_connect($db_server,
    $db_user,
    $db_pass,
    $db_name));

}
catch(mysqli_sqli_exception){
    echo "not connected";
}

$conn=mysqli_connect($db_server,
                     $db_user,
                     $db_pass,
                     $db_name);
if($conn){
    echo"you are connected! <br>";

}
else{
    echo "you are not connected!<br>";
}
?>