<?php
include './config.php';
session_start();
$user_id=$_SESSION['user_id'];
if(!isset($user_id)){
    header('location:login.php');
}
if(isset($_POST['send'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $number=$_POST['number'];
    $msg=$_POST['message'];
    $result=mysqli_num_rows(mysqli_query($conn,"Select * from `message` where  name='$name' and email='$email' and number='$number' and  message='$msg' "));
    if($result>0){
        $message[]='Message is already exist';
    }
    else{
        mysqli_query($conn,"Insert into `message` (user_id,name,number,email,message) values('$user_id','$name','$number','$email','$msg')");
          $message[]="The message is inserted successfully";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <title>Contact</title>
</head>
<body>
    <?php include './header.php' ?>
    <div class="heading">
        <h3>Contact us</h3>
        <p><a href="home.php">Home</a>/ contact</p>
</div>
<section class="contact">
<form action="" method="POST">
    <input type="text" name="name" required placeholder="Enter your Name" class="box">
    <input type="email" name="email" required placeholder="Enter your Email" class="box">
    <input type="number" name="number" required placeholder="Enter your Number" class="box">
    <textarea name="message" class="box" placeholder="enter your message" id="" cols="30" rows="10"></textarea>
    <input type="submit" value="send message" name="send" class="btn">
</form>
</section>





<?php include './footer.php'?>
    <script src="./js/script.js"></script>
</body>
</html>