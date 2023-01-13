<?php


try {
    $conn = new mysqli('localhost', 'root', '', 'plants');
}
catch
(Exception $e) {
}
session_start();
session_unset();
session_destroy();

header('location:login.php');

?>