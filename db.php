<?php
$host = "localhost";
$user = "root";
$pass = "zacky"; // Ganti jika password root Anda tidak kosong
$db   = "pemweb";

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>