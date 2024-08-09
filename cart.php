<?php
include './config.php';
session_start();
$user_id=$_SESSION['user_id'];
if(!isset($user_id)){
    header('location:login.php');
}

if(isset($_POST['update_cart'])){
    $update_id=$_POST['cart_id'];
$result=mysqli_query($conn,"Update  `cart` set quantity='$cart_quantity' where id='$update_id'");
header("location:cart.php");
}

if(isset($_GET['delete'])){
    $delete_id=$_GET['delete'];
$result=mysqli_query($conn,"Delete from `cart` where id='$delete_id'");
header("location:cart.php");
}
if(isset($_GET['delete_all'])){
    $result=mysqli_query($conn,"Delete from `cart` where id='$user_id'");
    header("location:cart.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <title>Cart</title>
</head>
<body>

    <?php include './header.php' ?>
    <div class="heading">
   <h3>Shopping cart</h3>
   <p> <a href="home.php">home</a> / cart </p>
</div>
<section class="shopping-cart">
    <h1 class="title">Products Added</h1>
    <div class="box-container">
    <?php
   $grand_total=0;
   $select_cart=mysqli_query($conn,"Select * from `cart` where user_id='$user_id'") or die("Query failed..");
   if(mysqli_num_rows($select_cart)>0){
    while($row=mysqli_fetch_assoc($select_cart)){
        ?>
        <div class="box">
   <a href="cart.php?delete=<?php echo $row['id'];?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
<img src="./uploaded_img/<?php echo $row['image']?>">
<div class="name"><?php echo $row['name']?></div>
<div class="price"><?php echo $row['price']?></div>
<form action="" method="post">
    <input type="hidden" name="cart_id" value="<?php echo $row['id']?>">
    <?php echo $row['quantity'] ?>
    
    <input type="number" min="1" name="cart_quantity" value="<?php echo $row['quantity'] ?> " >
    <input type="submit" name="update_cart" value="update" class="option-btn">
</form>
<div class="sub-total">sub total : <span>$<?php echo $sub_total= ($row['quantity']*$row['price']) ;?>/-</span></div>
        </div>

        <?php
        $grand_total+=$sub_total;
    }
   }
   else{
    echo '<p class="empty"></p>';
   }
?>/*
    </div>
   <!-- <div style="margin-top:2rem;text-align:center">
        <a href="cart.php?delete_all" class="delete-btn
            <?php echo ($grand_total>1)?"":'disabled'?>" onclick="return confirm('delete all from cart?')"> 
            DELETE ALL 
        
        </a>
    </div>
    <div class="cart-total">
        <p>grand Total : <span>$<?php echo $grand_total ?>/=</span></p>
        <div class="flex">
            <a href="shop.php" class="option-btn">Continue Shopping</a>
        <a href="checkout.php" class="btn<?php echo($grand_total>1)?"":'disabled'; ?>">Proceed to checkout</a>
        </div>
    </div>
</section>-->

<?php include './footer.php'?>
    <script src="./js/script.js"></script>
</body>
</html>