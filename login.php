<?php

include "./config.php";
@session_start();


//INSERT THE DATA
if(isset($_POST['submit'])){
    $useremail=$_POST['email'];
    $userpassword=md5($_POST['password']);
    //CHECK THE USER AVAILABE OR NOT
    $select_users=mysqli_query($conn,"Select * from `users` where email='$useremail' and password='$userpassword'");
    if(mysqli_num_rows($select_users)>0){
      $row=mysqli_fetch_assoc($select_users);
      if($row['user_type'] === 'admin'){
        echo $row['name'];
        $_SESSION['admin_name']=$row['name'];
        $_SESSION['admin_email']=$row['email'];
        $_SESSION['admin_id']=$row['id'];
       header('location:admin_page.php');
      }
    elseif($row['user_type']  === 'user'){
      $_SESSION['user_name']=$row['name'];
      $_SESSION['user_email']=$row['email'];
      $_SESSION['user_id']=$row['id'];
      header('location:home.php');

    }
  }

    else{
        $message[]='incorrect email or password!';
}}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!--font awesome cdn inks-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

<?php
if(isset($message)){
    foreach($message as $message){
      
        echo '
        <div class="message">
        <span>'.$message.'</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>
        ';
    }
}

?>




    <div class="form-container">
        <form action="" method="post">
            <h3>Login Now</h3>
       
        <input type="email" name="email" placeholder="Ener your email" class="box" required>
        <input type="password" name="password" placeholder="Enter your password" class="box" required> 

    <input type="submit" name="submit" value="Login Now" class="btn">
    <p>Don't you have an account? <a href="register.php">Register now</a> </p>
    </form>
    </div>
    
</body>
</html>