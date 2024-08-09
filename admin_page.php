<?php
include './config.php';
session_start();
$admin_id=$_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Admin panel</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/admin_style.css">
</head>
<body>
    <?php
include 'admin_header.php';
    ?>
    <!--admin dashboard section starts-->
    <section class="dashboard">
        <h1 class="title">Dashboard</h1>
        <div class="box-container">

            <!--pending orders-->
            <div class="box">
<?php
$total_pendings=0;
$select_pending=mysqli_query($conn,'Select total_price from `orders` where payment_status="pending"') or die("query failed");

if(mysqli_num_rows($select_pending)>0){
while($fetch_pendings=mysqli_fetch_assoc($select_pending)){
    $total_price=$fetch_pendings['total_price'];
    $total_pendings += $total_price;
}}
?>
<h3><?php echo $total_pendings; ?></h3>
<p>total pendings</p>
            </div>

            <!--completed order-->
            <div class="box">
<?php
$total_completed=0;
$select_complete=mysqli_query($conn,'Select total_price from `orders` where payment_status = "completed" ') or die("query failed");

if(mysqli_num_rows($select_complete)>0){
while($fetch_completed=mysqli_fetch_assoc($select_complete)){
    $total_price=$fetch_completed['total_price'];
    $total_completed += $total_price;
}}
?>
<h3><?php echo $total_completed ?></h3>
<p>completed payments</p>
            </div>

            <!--orders-->
            <div class="box">
                <?php
       $selected_orders=mysqli_query($conn,'Select * from `orders` ') or die('query failed');
       $number_of_orders=mysqli_num_rows($selected_orders);
                ?>
                <h3><?php echo $number_of_orders ?></h3>
                <p>Order Placed</p>
            </div>

            <!--products-->
            <div class="box">
                <?php
       $selected_products=mysqli_query($conn,'Select * from `products` ') or die('query failed');
       $number_of_products=mysqli_num_rows($selected_products);
                ?>
                <h3><?php echo $number_of_products ?></h3>
                <p>Products added</p>
            </div>

<!--users numbers-->
            <div class="box">
                <?php
       $selected_users=mysqli_query($conn,'Select * from `users` where user_type="user"') or die('query failed');
       $number_of_users=mysqli_num_rows($selected_users);
                ?>
                <h3><?php echo $number_of_users ?></h3>
                <p>Users added</p>
            </div>
            <!--admin number-->
            <div class="box">
                <?php
       $selected_admin=mysqli_query($conn,'Select * from `users` where user_type="admin"') or die('query failed');
       $number_of_admins=mysqli_num_rows($selected_admin);
                ?>
                <h3><?php echo $number_of_admins ?></h3>
                <p>Normal admin</p>
            </div>
                        <!--total user number-->
                        <div class="box">
                <?php
       $selected_user=mysqli_query($conn,'Select * from `users` ') or die('query failed');
       $number_of_users=mysqli_num_rows($selected_user);
                ?>
                <h3><?php echo $number_of_users ?></h3>
                <p>Total users</p>
            </div>
                                    <!--total message number-->
                                    <div class="box">
                <?php
       $selected_message=mysqli_query($conn,'Select * from `message` ') or die('query failed');
       $number_of_messages=mysqli_num_rows($selected_message);
                ?>
                <h3><?php echo $number_of_messages ?></h3>
                <p>Total messages</p>
            </div>





        </div>
    </section>

    <!--admin dashboard section ends-->
    
    <!--customer add js file-->
    <script src="./js/admin_script.js"></script>

</body>
</html>