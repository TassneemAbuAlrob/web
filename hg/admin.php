<?php

session_start();
try {
    $conn = new mysqli('localhost', 'root', '', 'plants');
}
catch
(Exception $e) {
}

if(isset($_POST['add_product'])){

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'proimages/'.$product_image;

    if(empty($product_name) || empty($product_price) || empty($product_image)){
        $message[] = 'please fill out all';
    }else{
        $insert = "INSERT INTO products( price,pro_name, image) VALUES( '$product_price','$product_name', '$product_image')";
        $upload = mysqli_query($conn,$insert);
        if($upload){
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'new product added successfully';
        }else{
            $message[] = 'could not add the product';
        }
    }

};

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE pro_id = $id");
    header('location:admin.php');
};

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="adminstyle.css">
    <script>


        function userprofile()
        {
            window.open("adminProfile.php","blank");
        }
        function logout()
        {
            window.open("logout.php","blank");
        }

        function admincart()
        {
            window.open("displayCart.php","blank");

        }

    </script>

</head>
<body>

<?php

if(isset($message)){
    foreach($message as $message){
        echo '<span class="message">'.$message.'</span>';
    }
}

?>

<header>
    <div class="header-1">

        <div class="share">
            <span> follow us : </span>
            <a href="https://www.facebook.com/Oxygen-108399974868189/" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
        </div>

        <div class="call">
            <span> call us : </span>
            <a href="#">+972568770927</a>
        </div>

    </div>

    <div class="header-2">

        <a href="#" class="logo"> <i class="fab fa-envira"></i> OXYGEN </a>



    </div>
    <div class="header-3">
    <div id="menu-bar" class="fas fa-bars"></div>

        <nav class="navbar">

        </nav>

    <div class="icons">
        <a href="#" class="fas fa-shopping-cart" onclick="admincart()"></a>
        <a href="#" class="fas fa-user-circle" onclick="userprofile()"></a>
        <a href="#" class="fa fa-times" onclick="logout()"></a>

    </div>

    </div>

</header>
<div class="container">

    <div class="admin-product-form-container">

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <h3>Products</h3>
            <input type="text" placeholder="enter product name" name="product_name" class="box">
            <input type="number" placeholder="enter product price" name="product_price" class="box">
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
            <input type="submit" class="btn" name="add_product" value="add product">
        </form>

    </div>

    <?php

    $select = mysqli_query($conn, "SELECT * FROM products");

    ?>
    <div class="product-display">
        <table class="product-display-table">
            <thead>
            <tr>
                <th>product image</th>
                <th>product name</th>
                <th>product price</th>
                <th>action</th>
            </tr>
            </thead>
            <?php while($row = mysqli_fetch_assoc($select)){ ?>
                <tr>
                    <td><img src="proimages/<?php echo $row['image']; ?>" height="100" alt=""></td>
                    <td><?php echo $row['pro_name']; ?></td>
                    <td>$<?php echo $row['price']; ?></td>
                    <td>
                        <a href="admin_update.php?edit=<?php echo $row['pro_id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
                        <a href="admin.php?delete=<?php echo $row['pro_id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</div>
<div class="cart-btn">
    <a href="mainAdmin.php" class="btn ">Back to Main Profile</a>
</div>

</body>
</html>