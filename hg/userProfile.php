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
if(isset($_POST['done'])) {
    $update_Name = $_POST['name'];
    $update_phone = $_POST['phone'];
    $update_email = $_POST['email'];
    $update_address = $_POST['address'];
    $update_username = $_POST['username'];
    $update_password = $_POST['password'];


    $sql = "UPDATE members SET name = '$update_Name', phone = '$update_phone' ,email = '$update_email',address = '$update_address',
 username = '$update_username', password = '$update_password'   WHERE mem_id='{$_SESSION["user_id"]}'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>alert('Profile Updated successfully.');</script>";
    } else {
        echo "<script>alert('Profile can not Updated.');</script>";
        echo $conn->error;
    }

}
if(isset($_POST['cancel']))
{

    header('location:index.php');


}

?>




<!DOCTYPE html>
<html>
<head>
    <title> Your Profile </title>
    <style>
        body{
            background-color:RosyBrown;
        }
        *:focus{
            outline: none;
        }
        .box{
            box-sizing: border-box;
            width: 200px;
            height: 200px;
            border:2px solid darkolivegreen;
            box-shadow: -3px -3px 7px wheat,
            3px 3px 5px rgba(94,104,121,0.288);
            border-radius: 50%;
            background-color: white;
            margin-top: 50px;
            overflow: hidden;
            transition: all 1s;
        }
        .box:hover{
            width: 360px;
            height: 600px;
            border-radius: 5px;
        }
        img{
            box-sizing: border-box;
            width:149px;
            height:149px;
            border-radius:50%;
            margin:0;
            border:5px solid darkolivegreen;
            padding: 3px;
            background-color: white;
            overflow: hidden;
            transition: all 1s;

        }
        .box:hover img{
            width: 100px;
            height: 100px;
            margin:20px 35% ;
        }
        hr{
            width:500px;
            line-height:20px;
            margin:10px 10px 10px 10px;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"]
        {
            display: block;
            box-sizing: border-box;
            color: darkolivegreen;
            margin-bottom: 30px;
            padding: 4px;
            width: 200px;
            height: 20px;
            border: none;
            border-bottom: 1px solid darkolivegreen;
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            font-size: 15px;
            transition: 0.2s ease;
            background: none;
        }
        input[type="text"]{
            margin-top: 25px;
        }
        input[type="text"]:focus,
        input[type="password"]:focus,

        input[type="email"]:focus,
        input[type="number"]:focus {
            border-bottom: 2px solid darkolivegreen;
            border-bottom-right-radius:20px;
            color: darkolivegreen;
            transition: 0.2s ease;
            background: wheat;
            border-top: none;
        }


        button{
            border:1px solid darkolivegreen;
            background-color: RosyBrown;
            color:white;
            height: 30px;
            width: 100px;
            border-radius: 5px;
            left:0;
            margin:0px;
            transition: all .3s;
        }
        button:hover{
            transform: scale(1.1);
            background-color: wheat;
        }
        input[type="file"]{
            display:none;
        }
        label{
            box-sizing: border-box;
            width:40px;
            height:20px;
            background-color: RosyBrown;
            color:white;
            border:1px solid darkolivegreen;
            background-color: RosyBrown;
            color:white;
            padding: 4px;
            border-radius: 2px;
        }
        label:hover{
            background-color: #566573;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
<form action="userProfile.php" method="post">
    <?php
    $user_id = $_SESSION['user_id'];
    $sql= "SELECT * FROM members WHERE mem_id='$user_id'";
    $gotResults = mysqli_query($conn ,$sql);
    if($gotResults)
    {
        if(mysqli_num_rows($gotResults)>0)
        {
            while($row = mysqli_fetch_array($gotResults))
            {
               // print_r($row['mem_id']);
               ?>
                <center>
                    <div class="box">

                        <input type="file" id="file" name="image" >
                        <img src="pic22.jpg" width="100%" height="100%">



                        <input type="text" placeholder=" Name" name="name" value="<?php echo $row['name'];?>">
                        <input type="number" placeholder="Phone Number" name="phone" value="<?php echo $row['phone'];?>" >
                        <input type="Email" placeholder="Email ID" name="email" value="<?php echo $row['email'];?>">
                        <input type="text" placeholder="Address" name="address" value="<?php echo $row['address'];?>">
                        <input type="text" name="username" placeholder="User Name"  value="<?php echo $row['username'];?>">
                        <input type="password" name="password" placeholder="Password"  value="<?php echo $row['password'];?>">

                        <button name="cancel"    style="float: left;margin: 10px 0 0 18.2%;">CANCEL</button>
                        <button name="done" style="float: right;margin:10px 18.2% 0 0;">DONE</button>

                    </div>

                </center>
    <?php

            }
        }
    }

?>
</form>

</body>
</html>