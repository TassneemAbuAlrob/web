<?php

if (isset($_POST['submit'])) {
    if (isset($_POST['username']) && isset($_POST['password']) &&
        isset($_POST['gender']) && isset($_POST['email']) &&
        isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['SIN']) && isset($_POST['address'])
    && isset($_POST['user_level'])) {

        $name = $_POST['name'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$SIN = $_POST['SIN'];
$email = $_POST['email'];
$address = $_POST['address'];
$username = $_POST['username'];
$password = $_POST['password'];
$user_level = $_POST['user_level'];



$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "plants";
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM members WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO members(name, gender,phone,SIN, email, address,username,password,userlevel ) values(?, ?, ?, ?, ?, ?,?,?,?)";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssiisssss",$name,$gender,$phone,$SIN, $email, $address,$username,$password,$user_level);
                if ($stmt->execute()) {
                    //echo "New record inserted sucessfully.";
                    header('Location:login.php');
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>
