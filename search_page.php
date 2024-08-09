<?php
include './config.php';
session_start();
$user_id=$_SESSION['user_id'];
if(!isset($user_id)){
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <title>Search page</title>
</head>
<body>
    <?php include './header.php' ?>
    <div class="heading">
   <h3>search page</h3>
   <p> <a href="home.php">home</a> / search </p>
</div>
<section class="search-form">
    <form action="" method="POST">
    <input type="text" name="search" placeholder="search products..." class="box">
    <input type="submit" name="submit" value="search" class="btn">
    </form>

</section>
<?php
if(isset($_POST['submit'])){
    $search_item=$_POST["search"];
    $result=mysqli_query($conn,'select * from `products` where name like "%search_item%"') or die("Query failed");
    if(mysqli_num_rows($result)>0){
while($row=mysqli_fetch_assoc($result)){
?>
<form action="" method="post" class="box">
<img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="" class="image">
      <div class="name"><?php echo $fetch_product['name']; ?></div>
      <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
      <input type="number"  class="qty" name="product_quantity" min="1" value="1">
      <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
      <input type="submit" class="btn" value="add to cart" name="add_to_cart">

</form>



<?php
}
}
else{
    echo "<p class='empty'></p>";
}
}

?>

<?php include './footer.php'?>
    <script src="./js/script.js"></script>
</body>
</html>