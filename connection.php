<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "bendi_car_rental";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>
