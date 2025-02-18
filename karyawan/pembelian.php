<?php
include '../koneksi.php';
include '../navbar.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] != "karyawan") {
    header("Location: ../login.php");
    exit();
}


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['barcode'])) {
    $barcode = $_POST['barcode'];
    $sql = "SELECT * FROM produk WHERE barcode = '$barcode'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $produk = $result->fetch_assoc();
        $_SESSION['cart'][] = $produk;
    } else {
        echo "<script>alert('Produk tidak ditemukan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Minimarket</title>
</head>
<body>
    <h2>Kasir Minimarket</h2>
    
    <form method="post">
        <input type="text" name="barcode" placeholder="Scan Barcode..." autofocus required>
        <button type="submit">Tambah</button>
    </form>

    <h3>Daftar Belanja</h3>
    <table border="1">
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
        </tr>
        <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            echo "<tr><td>{$item['nama_produk']}</td><td>Rp " . number_format($item['harga'], 0, ',', '.') . "</td></tr>";
            $total += $item['harga'];
        }
        ?>
        <tr>
            <td><b>Total</b></td>
            <td><b>Rp <?php echo number_format($total, 0, ',', '.'); ?></b></td>
        </tr>
    </table>

    <form method="post" action="reset.php">
        <button type="submit">Reset Transaksi</button>
    </form>

    <form method="post" action="checkout.php">
    <button type="submit">Checkout</button>
</form>

</body>
</html>
