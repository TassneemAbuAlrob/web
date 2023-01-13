

<?php
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $uname = $_POST['username'];
    $upass = $_POST['password'];

    try {
        $conn = new mysqli('localhost', 'root', '', 'plants');
        if (isset($_POST['login'])) {

            $select = mysqli_query($conn, "SELECT * FROM `members` WHERE username = '$uname' AND password = '$upass'") or die('query failed');

            if (mysqli_num_rows($select) > 0) {
                $row = mysqli_fetch_assoc($select);
                $_SESSION['user_id'] = $row['mem_id'];
                $_SESSION['userlevel']=$row['userlevel'];
                $userlevel=$_SESSION['userlevel'];
                if($userlevel=="u")
                { header('location:index.php');}
                else
                {header('location:mainAdmin.php');}
            }


            else {
                $message[] = 'incorrect password or email!';
            }



        }
    } catch
    (Exception $e) {
    }

}
?>


<html lang="en">
<head>
    <title>Sign in form</title>
    <link rel ="stylesheet" type="text/css" href="log.css">
    <script src="https://kit.fontawesome.com/c3a80af4dd.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>signin-signup</title>

</head>
<body>

<div class="container">
    <div class="signin-signup" >

        <form  action="login.php" method="post">
            <h2 class="title">sign in</h2>
            <table>
                <tr class ="input-field">


                    <td><i class="fas fa-user"></i> </td>
                    <td><input type="text" name="username"  placeholder="username"></td>

                </tr>
                <tr class ="input-field">
                    <td> <i class="fas fa-lock"></i></td>
                    <td><input type="password" name="password" placeholder="password"></td>

                </tr>
            </table>
            <input type="submit" value="login" class="btn" name="login">
            <span class="social-text">Not registered? <a href="signup.html">Create an account</a></span>



            <div>
                <p class="social-text">Or sign in with social platform</p>
                <div class="social-media">
                    <a href="#" class="social-icon">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-google"></i>

                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-linkedin"></i>

                    </a>
                </div>
        </form>
    </div>
</div>

</body>

</html>
