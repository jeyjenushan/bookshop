<?php
include './config.php';
session_start();
$admin_id=$_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:login.php');
}
if(isset($_POST['add_product'])){
    $name=$_POST['name'];
    $price=$_POST['price'];
    $product_image=$_FILES['productimage']['name'];
    $product_image_size=$_FILES['productimage']['size'];
    $product_image_tmp=$_FILES['productimage']['tmp_name'];
    $image_folder="./uploaded_img/".$product_image;
    $selected_product_name=mysqli_query($conn,"Select * from `products` where name='$name'") or die("Query failed");
    if(mysqli_num_rows($selected_product_name)>0){
        $message[]="Product name already exissts";
}
else{
    $add_product_query=mysqli_query($conn,"Insert into `products` (name,price,image) values('$name','$price','$product_image') ") or die("Query failed");
    if($add_product_query){
        if( $product_image_size>2000000){
            $message[]="Image size is too large";
        }
        else{
        move_uploaded_file($product_image_tmp,$image_folder);
        $message[]="product added successfully";
        }
    }
    else{
        $message[]="product could not be added ";
    }

}
}
//delete prodducts
if(isset($_GET['delete'])){
    $deleted_id=$_GET['delete'];
    $deleted_img_query=mysqli_query($conn,"SELECT * FROM `products` where id=$deleted_id");
    $fetch_delete_image=mysqli_fetch_assoc($deleted_img_query);
    unlink('uploaded_img/'.$fetch_delete_image['image']);
    mysqli_query($conn,"DELETE FROM `products` where id='$deleted_id'") or die('query failed');
    header("location:admin_products.php");
}
//update products

if(isset($_POST['updated_product'])){
    $update_p_id=$_POST['update_p_id'];

    $updated_name=$_POST["update_name"];
    $updated_price=$_POST["update_price"];
    mysqli_query($conn,"UPDATE `products` SET name='$updated_name',price='$updated_price' where id='$update_p_id'") or die("query failed");
    $update_image=$_FILES['update_img']['name'];
    $update_image_tmp_name=$_FILES['update_img']['tmp_name'];
    $update_image_size=$_FILES['update_img']['size'];
    $update_folder='uploaded_img/'.$update_image;
    $update_old_image=$_POST['update_old_image'];
    if(!empty($update_image)){
        if($update_image_size >2000000){
            $message[]="Image file size is too large";
        }
        else{
            mysqli_query($conn,"UPDATE `products` SET image='$update_image' where id=$update_p_id") or die("query failed");  
            move_uploaded_file($update_image_tmp_name,$update_folder);
            unlink('upload_img/'.$update_old_image);
        }
    }
    header('location:admin_products.php');

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/admin_style.css">
</head>
<body>
    <?php
include 'admin_header.php';
    ?>
<!--product crud system start-->
<!--add products-->
<section class="add-products">
    <h1 class="title">Shop Products</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <h3>Add Products</h3>
        <input type="text" name="name" class="box" placeholder="Enter your product name" required>
        <input type="number"min=0  name="price" class="box" placeholder="Enter your price" required>
        <input type="file" name="productimage" class="box" placeholder="Enter your product image" required>
        <input type="submit" name="add_product" class=" btn" value="ADD PRODUCT" required>
    </form>
</section>
<!--show products-->
<section class="show-products">
    <div class="box-container">
      <?php
      $select_products=mysqli_query($conn,"SELECT * FROM `products`") or die("Query failed");
      if(mysqli_num_rows($select_products)>0){
        while($fetch_products=mysqli_fetch_assoc($select_products)){
     ?>
     <div class="box">
        <img src="uploaded_img/<?php echo $fetch_products['image'] ?>">
       <div class="name"><?php echo $fetch_products['name'] ?></div> 
        <div class="price"><?php echo "$". $fetch_products['price'] ."/-" ?></div>
        <a href="admin_products.php?update=<?php echo $fetch_products['id']?>" class="option-btn">Update</a>
        <a href="admin_products.php?delete=<?php echo $fetch_products['id']?>" class="delete-btn" onclick="return confirm('Delete this product?')">Delete</a> 
    </div>
            <?php
        }

      }
      else{
        echo '<p class="empty">No product added yet!</p>';
      }
      ?>
    </div>
</section>
<!--update produts-->
<section class="edit-product-form">
<?php
if(isset($_GET['update'])){
    $updated_id=$_GET['update'];
    $update_query=mysqli_query($conn,"SELECT * FROM `products` where id ='$updated_id'") or die("Query failed");
if(mysqli_num_rows($update_query)>0){
    while($fetch_update=mysqli_fetch_assoc($update_query)){
?>
<form action="" method="POST" enctype='multipart/form-data'>
<input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id'] ?>">
<input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image'] ?>">


    <img src="uploaded_img/<?php echo $fetch_update['image'] ?>">
    <input type="text" name="update_name" class="box" placeholder="Enter Product Name"  value="<?php echo $fetch_update['name']?>">
    <input type="number" name="update_price" min='0' class="box" placeholder="Enter Product Price"   value="<?php echo $fetch_update['price']?>">
   <input type="file" class="box" name="update_img" >
   <input type="submit" value="UPDATE" name="updated_product" class="btn">
   <input type="reset" value="CANCEL" id="close-update" class="option-btn">
</form>
<?php
    }
}
}
else{
    echo '<script>document.querySelector(".edit-product-form").style.display="none";</script>';

}
?>

</section>

<!--product crud system ends-->



    <!--customer add js file-->
    <script src="./js/admin_script.js"></script>

</body>
</html>