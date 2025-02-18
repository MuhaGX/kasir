<?php
session_start();
if (isset($_SESSION['username'])) {
    if ($_SESSION['level'] == "admin") {
        header("Location: administrator/pembelian.php");
    } else if ($_SESSION['level'] == "karyawan") {
        header("Location: karyawan/pembelian.php");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php
    if (isset($_GET['pesan'])) {
        echo "<p style='color:red;'>Username atau Password salah!</p>";
    }
    ?>
    <form method="POST" action="proses_login.php">
        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
