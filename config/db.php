<?php
$host = "localhost";
$username = "root"; // atau username database lo
$password = ""; // password database lo
$database = "rumahkeren";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Koneksi Berhasil";
}
?>