<?php
session_start();

include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$login = mysqli_query($conn,"SELECT * FROM user WHERE username='$username' AND password='$password'");

$cek = mysqli_num_rows($login);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($login);

    if ($data['level'] == "admin") {

        $_SESSION['username'] = $username;
        $_SESSION['level'] = "admin";
        header("Location: administrator/pembelian.php");
        
    } else if ($data['level'] == "karyawan") {

        $_SESSION['username'] = $username;
        $_SESSION['level'] = "karyawan";
        header("Location: karyawan/pembelian.php");
    } else {
        header("Location: index.php?pesan=gagal");
    }
} else {
    header("Location: index.php?pesan=gagal");
}
?>
