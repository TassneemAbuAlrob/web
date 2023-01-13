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
        mysqli_query($conn, "INSERT INTO cart (mem_id, pro_name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
        $message[] = 'product added to cart!';
    }

};

//contact US
if(isset($_POST['btn-send']))
{
    $UserName = $_POST['UName'];
    $email = $_POST['email'];
    $Subject = $_POST['subject'];
    $Msg = $_POST['message'];

    $to = $email;

    $Msg = "Name: {$UserName} Email: {$email} Subject: {$Subject}  Message: " . $Msg;

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: bravecoderofficial@gmail.com';

    $mail = mail($to,$Subject,$Msg,$headers);

    if ($mail) {
        echo "<script>alert('Mail Send.');</script>";
    }else {
        echo "<script>alert('Mail Not Send.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Oxygen</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">
    <script>
        function windoeopen()
        {
          window.open("procart.php","blank");
        }

        function userprofile()
        {
            window.open("userProfile.php","blank");
        }

        function logout()
        {
            window.open("logout.php","blank");
        }

        function cart()
        {
            window.open("procart.php","blank");
        }

    </script>

</head>
<body>



<!-- header section starts  -->


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

            <a href="#home">home</a>
            <a href="#about">About Us</a>
            <a href="#contact">contact</a>
            <a href="#review">Review</a>


        </nav>

        <div class="icons">
            <a href="#" class="fas fa-shopping-cart"onclick="cart()"></a>
            <a href="#" class="fas fa-user-circle" onclick="userprofile()"></a>
            <a href="#" class="fa fa-times" onclick="logout()"></a>

        </div>

    </div>

</header>

<!-- header section ends -->

<!-- home section starts  -->

<section class="home" id="home">

    <div class="swiper-container home-slider">

        <div class="swiper-wrapper">

            <div class="swiper-slide">
                <div class="box" style="background: url(pexels-scott-webb-311458.jpg);">
                    <div class="content">
                        <h3>Home Plant</h3>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="box" style="background: url(p1.jpg);">
                    <div class="content">
                        <h3>Office Plant </h3>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="box" style="background: url(fruiting.jpg);">
                    <div class="content">
                        <h3>Street Plant</h3>
r                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="box" style="background: url(giftcover.jpg);">
                    <div class="content">
                        <h3>Gift Plant</h3>
                    </div>
                </div>
            </div>

        </div>

        <div class="swiper-pagination"></div>
    </div>
</section>



    <div class="container">


        <div class="products">

            <h1 class="heading">latest products</h1>

            <div class="box-container">

                <?php
                $select_product = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                if(mysqli_num_rows($select_product) > 0){
                    while($fetch_product = mysqli_fetch_assoc($select_product)){
                        ?>
                        <form method="post" class="box" action="">
                            <img src="proimages/<?php echo $fetch_product['image']; ?>" alt="">
                            <div class="name"><?php echo $fetch_product['pro_name']; ?></div>
                            <div class="price">$<?php echo $fetch_product['price']; ?></div>
                            <input type="number" min="1" name="product_quantity" value="1">
                            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $fetch_product['pro_name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                            <input type="submit" value="add to cart" name="add_to_cart" class="btn" onclick="windoeopen()">
                        </form>
                        <?php
                    };
                };
                ?>

            </div>

        </div>


        <div class="container">
            <div class="pots">

                <h1 class="heading">Pots</h1>

                <div class="box-container">

                    <?php
                    $select_product = mysqli_query($conn, "SELECT * FROM `pots`") or die('query failed');
                    if(mysqli_num_rows($select_product) > 0){
                        while($fetch_product = mysqli_fetch_assoc($select_product)){
                            ?>
                            <form method="post" class="box" action="">
                                <img src="pot/<?php echo $fetch_product['image']; ?>" alt="">
                                <div class="name"><?php echo $fetch_product['pro_name']; ?></div>
                                <div class="price">$<?php echo $fetch_product['price']; ?></div>
                                <input type="number" min="1" name="product_quantity" value="1">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $fetch_product['pro_name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                                <input type="submit" value="add to cart" name="add_to_cart" class="btn"onclick="windoeopen()">
                            </form>
                            <?php
                        };
                    };
                    ?>

                </div>

            </div>




        <div class="container">
            <div class="fertilizer">

                <h1 class="heading">Fertilizer</h1>

                <div class="box-container">

                    <?php
                    $select_product = mysqli_query($conn, "SELECT * FROM `fertilizer`") or die('query failed');
                    if(mysqli_num_rows($select_product) > 0){
                        while($fetch_product = mysqli_fetch_assoc($select_product)){
                            ?>
                            <form method="post" class="box" action="">
                                <img src="fertilizers/<?php echo $fetch_product['image']; ?>" alt="">
                                <div class="name"><?php echo $fetch_product['pro_name']; ?></div>
                                <div class="price">$<?php echo $fetch_product['price']; ?></div>
                                <input type="number" min="1" name="product_quantity" value="1">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $fetch_product['pro_name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                                <input type="submit" value="add to cart" name="add_to_cart" class="btn"onclick="windoeopen()">
                            </form>
                            <?php
                        };
                    };
                    ?>


                </div>

            </div>


            <div class="container">
                <div class="equipment">

                    <h1 class="heading">Equipments</h1>

                    <div class="box-container">
                        <div class="box-container">

                            <?php
                            $select_product = mysqli_query($conn, "SELECT * FROM `equipment`") or die('query failed');
                            if(mysqli_num_rows($select_product) > 0){
                                while($fetch_product = mysqli_fetch_assoc($select_product)){
                                    ?>
                                    <form method="post" class="box" action="">
                                        <img src="equipment/<?php echo $fetch_product['image']; ?>" alt="">
                                        <div class="name"><?php echo $fetch_product['pro_name']; ?></div>
                                        <div class="price">$<?php echo $fetch_product['price']; ?></div>
                                        <input type="number" min="1" name="product_quantity" value="1">
                                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['pro_name']; ?>">
                                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                                        <input type="submit" value="add to cart"  name="add_to_cart" class="btn"onclick="windoeopen()">
                                    </form>
                                    <?php
                                };
                            };
                            ?>

                    </div>

                </div>

                <!-- review section starts  -->

                <section class="review" id="review">

                    <h1 class="heading"> customer's <span>review</span> </h1>

                    <div class="box-container-review">

                        <div class="box-review">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p>I made a purchase from this app as a gift for my mum on Mother's Day and it was really a great experience, thank you so much!!.</p>
                            <div class="user">
                                <img src="pic-1.png" alt="">
                                <div class="user-info">
                                    <h3>john deo</h3>
                                    <span>happy customer</span>
                                </div>
                            </div>
                            <span class="fas fa-quote-right"></span>
                        </div>

                        <div class="box-review">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <p> I ordered twice from here, the first was for one of the rare flowers, the second was for a citrus fertilizer, but unfortunately it did not suit everything in my garden, I think the problem is with the way I use it and not with the product.</p>
                            <div class="user">
                                <img src="pic-2.png" alt="">
                                <div class="user-info">
                                    <h3>Amanda</h3>
                                    <span>happy customer</span>
                                </div>
                            </div>
                            <span class="fas fa-quote-right"></span>
                        </div>

                        <div class="box-review">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <p>I ordered pots, but unfortunately I received two of them and they are damaged.</p>
                            <div class="user">
                                <img src="pic-3.png" alt="">
                                <div class="user-info">
                                    <h3>Marchos</h3>
                                    <span>happy customer</span>
                                </div>
                            </div>
                            <span class="fas fa-quote-right"></span>
                        </div>

                    </div>

                </section>

                <!-- review section ends -->

                    <!-- about section starts  -->

                    <section class="about" id="about">

                        <h1 class="heading"> <span> about </span> us </h1>

                        <div class="row">

                            <div class="video-container">
                                <video src="images/Pexels Videos .mp4" loop autoplay muted></video>
                                <h3>best flower sellers</h3>
                            </div>

                            <div class="content">
                                <h3>why choose us?</h3>,
                                <p>Our application is characterized by ease of use and access, it is available online, and the user can easily choose what he wants and see the prices of all available things, and we also give him the ability to delete and add!
                                    We provide everything you could need from fertilizers, agricultural equipment, and pots.
                                    Thus, our application is fully integrated!!</p>
                            </div>

                        </div>

                    </section>

                    <!-- about section ends -->

                    <!-- contact section starts  -->

                    <section class="contact" id="contact">

                        <h1 class="heading">get in touch</h1>

                        <div class="row">
                            <iframe class ="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3375.119118467623!2d35.2183914151235!3d32.22795898114132!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151ce1a4057bc2b1%3A0x37cadbaf1603e397!2sAn-Najah%20National%20University!5e0!3m2!1sen!2s!4v1651873764966!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                            <form action="index.php" method="post" autocomplete="off">


                                <div class="inputBox">
                                    <input type="text" name="UName" required>
                                    <label>Name</label>
                                </div>
                                <div class="inputBox">
                                    <input type="email" name="email" required>
                                    <label>Email</label>
                                </div>
                                <div class="inputBox">
                                    <input type="text" name="subject" required>
                                    <label>Subject</label>
                                </div>
                                <div class="inputBox">
                                    <textarea name="message"  id="message" cols="30" rows="10" ></textarea>
                                    <label>Message</label>
                                </div>

                                <input type="submit" value="send message" class="btn" name="btn-send">

                            </form>

                        </div>

                    </section>

                    <!-- contact section ends -->
                    <!-- footer section starts  -->

                    <section class="footer">

                        <div class="box-container">

                            <div class="box">
                                <h3>about us</h3>
                                <p>
                                    Our store was established 10 years ago, in 2012, it was initially a simple store inside our house and visitors come to buy from it,
                                    after that we developed it to comply with modern technology.
                                </p>
                            </div>
                            <div class="box">
                                <h3>branch locations</h3>
                                <a href="#">india</a>
                                <a href="#">USA</a>
                                <a href="#">japan</a>
                                <a href="#">france</a>
                            </div>
                            <div class="box">
                                <h3>quick links</h3>
                                <a href="#home">home</a>
                                <a href="#about">about</a>
                                <a href="#contact">contact</a>
                                <a href="#review">review</a>

                            </div>
                            <div class="box">
                                <h3>follow us</h3>
                                <a href="https://www.facebook.com/Oxygen-108399974868189/">facebook</a>
                                <a href="#">twitter</a>
                                <a href="#">instagram</a>
                                <a href="#">linked</a>
                            </div>

                        </div>

                        <h1 class="credit"> created by <span> Tassneem & Alaa </span> | all rights reserved! </h1>

                    </section>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="script.js"></script>

</body>
</html>
