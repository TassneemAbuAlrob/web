<?php

session_start();
try {
    $conn = new mysqli('localhost', 'root', '', 'plants');
}
catch
(Exception $e) {
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
    <link rel="stylesheet" href="admin.css">
    <script>
        function windoeopen1()
        {
            window.open("admin.php","blank");
        }
        function windoeopen2()
        {
            window.open("adminPots.php","blank");
        }
        function windoeopen3()
        {
            window.open("adminfertilizers.php","blank");
        }
        function windoeopen4()
        {
            window.open("equipmentadmin.php","blank");
        }




    </script>




</head>
<body>


<a href="#" id="product" onclick="windoeopen1()">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    Products
</a>
<a href="#" id="pot"onclick="windoeopen2()">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    Pots
</a>
<a href="#" id="flz" onclick="windoeopen3()">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    Fertilizer
</a>
<a href="#" id="equ"  onclick="windoeopen4()">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    Equipment
</a>


</body>
</html>