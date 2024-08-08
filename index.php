<?php
include("database.php");

$sql="INSERT INTO users(user,password) VALUES ('Spongebob')";
try{mysqli_connect($conn,$sql);
    echo "user is now registered";

}
catch(mysqli_sqli_exception){
    echo " could not connected";
}
mysqli query($conn,$sql);
mysqli_close($conn);
?>