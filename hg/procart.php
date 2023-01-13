<?php

session_start();
try {
    $conn = new mysqli('localhost', 'root', '', 'plants');
}
catch
(Exception $e) {
}
$user_id = $_SESSION['user_id'];
if(!isset($user_id)){
    header('location:login.php');
};
if(isset($_POST['add_to_cart'])){

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE pro_name = '$product_name' AND mem_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($select_cart) > 0){
        $message[] = 'product already added to cart!';
    }else{
        mysqli_query($conn, "INSERT INTO `cart`(mem_id, pro_name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
        $message[] = 'product added to cart!';
    }

};

if(isset($_POST['update_cart'])){
    $update_quantity = $_POST['cart_quantity'];
    $update_id = $_POST['cart_id'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
    $message[] = 'cart quantity updated successfully!';
}

if(isset($_GET['remove'])){
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
    header('location:procart.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `cart` WHERE mem_id = '$user_id'") or die('query failed');
    header('location:procart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shopping-cart</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">

    </head>

    <body>

    <?php
    if(isset($message)){
        foreach($message as $message){
            echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
        }
    }
    ?>
    <div class="container">
    <div class="shopping-cart">

        <h1 class="heading">shopping cart</h1>

        <table>
            <thead>
            <th>image</th>
            <th>name</th>
            <th>price</th>
            <th>quantity</th>
            <th>total price</th>
            <th>action</th>
            </thead>
            <tbody>
            <?php
            $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE mem_id = '$user_id'") or die('query failed');
            $grand_total = 0;
            if(mysqli_num_rows($cart_query) > 0){
                while($fetch_cart = mysqli_fetch_assoc($cart_query)){
                    ?>
                    <tr>
                        <td><img src="images/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
                        <td><?php echo $fetch_cart['pro_name']; ?></td>
                        <td>$<?php echo $fetch_cart['price']; ?>/-</td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                                <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                                <input type="submit" name="update_cart" value="update" class="option-btn">
                            </form>
                        </td>
                        <td>$<?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></td>
                        <td><a href="procart.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('remove item from cart?');">remove</a></td>
                    </tr>
                    <?php
                    $grand_total += $sub_total;
                }
            }else{
                echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
            }
            ?>
            <tr class="table-bottom">
                <td colspan="4">grand total :</td>
                <td>$<?php echo $grand_total; ?></td>
                <td><a href="procart.php?delete_all" onclick="return confirm('delete all from cart?');" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">delete all</a></td>
            </tr>
            </tbody>
        </table>

        <div class="cart-btn">
            <a href="#" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
        </div>
        <div class="cart-btn">
            <a href="index.php" class="btn ">Back to Main Profile</a>
        </div>

    </div>

    </div>


    </body>
    </html>


