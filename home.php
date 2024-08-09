<?php
include './config.php';
session_start();
$user_id=$_SESSION['user_id'];
if(!isset($user_id)){
    header('location:login.php');
}
if(isset($_POST['add_to_cart'])){
    $product_name=$_POST['product_name'];
    $product_price=$_POST['product_price'];
    $product_quantity=$_POST["product_quantity"];
    $product_image=$_POST["product_image"];
    $check_cart_numbers=mysqli_num_rows(mysqli_query($conn,"Select * from `cart` where name='$product_name' and user_id='$user_id' "));
    if($check_cart_numbers>0){
$message[]='already added to cart!';
    }
    else{
$insert_cart=mysqli_query($conn,"Insert into `cart` (user_id,name,price,quantity,image) values('$user_id','$product_name','$product_price',' $product_quantity','$product_image')");
$message[] = 'product added to cart!';
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
    <title>Home</title>
</head>
<body>
    <?php include './header.php' ?>
    <section class="home">
        <div class="content">
 <h3>Hand Picked Book to your door.</h3>
 <p>Lorem ipsum, dolor sit amet consectetur
     adipisicing elit. Minima illum id obcaecati 
     neque inventore. Aspernatur rerum blanditiis
      dolores molestias repellendus libero labor
    e! Illum qui numquam optio aspernatur eum. 
    Vero, quo.</p>
    <a href="about.php" class="white-btn">Dicover More</a>

        </div>
    </section>
    <section class="products">
        
   <h1 class="title">latest products</h1>
        <div class="box-container">
<?php
$selected_product=mysqli_query($conn,'Select * from `products` ') or die('query failed');
if(mysqli_num_rows($selected_product)>0){
    while($fetched_products=mysqli_fetch_assoc($selected_product)){
?>
<div class="box">
    <form action="" method="POST">
    <img class="image" src="uploaded_img/<?php  echo $fetched_products['image']?>" alt="">
    <div class="name"><?php echo $fetched_products['name']?></div>
    <div class="price"><?php echo $fetched_products['price']?></div>
    <input type="number" name="product_quantity" value=1 min=1 class="qty">
    <input type="hidden" value="<?php echo $fetched_products['name'] ?>" name="product_name">
    <input type="hidden" value="<?php echo $fetched_products['price'] ?>" name="product_price">
    <input type="hidden" value="<?php echo $fetched_products['image'] ?>" name="product_image">
    <input type="submit" value="add to cart" class="btn" name="add_to_cart">
    
    </form>
</div>
    
    <?php
    
    }

}
else{
    echo '<p class="empty">No Products added yet</p>';
}
?>
 </div>

 <div class="load-more" style="margin-top: 2rem; text-align:center">
<a href="shop.php" class="option-btn">Load More</a>
 </div>
    </section>
    <section class="about">
        <div class="flex">
            <div class="image">
                <img src="images/about-img.jpg" alt="">
            </div>
            <div class="content">
            <h3>about us</h3>
         <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit quos enim minima ipsa dicta officia corporis ratione saepe sed adipisci?</p>
         <a href="about.php" class="btn">read more</a>
            </div>
        </div>
    </section>

    <section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque cumque exercitationem repellendus, amet ullam voluptatibus?</p>
      <a href="contact.php" class="white-btn">contact us</a>
   </div>

</section>


<?php include './footer.php'?>
    <script src="./js/script.js"></script>
</body>
</html>