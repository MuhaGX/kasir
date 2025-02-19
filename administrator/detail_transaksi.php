<?php
include '../koneksi.php';
include 'navbar.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] != "admin") {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "<script>alert('ID transaksi tidak valid!'); window.location='laporan.php';</script>";
    exit();
}

$transaksi_id = $_GET['id'];

$sql_transaksi = "SELECT * FROM transaksi WHERE id = '$transaksi_id'";
$result_transaksi = $conn->query($sql_transaksi);
$transaksi = $result_transaksi->fetch_assoc();

$sql_detail = "SELECT * FROM transaksi_detail WHERE transaksi_id = '$transaksi_id'";
$result_detail = $conn->query($sql_detail);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
</head>
<body>
    <h2>Detail Transaksi #<?php echo $transaksi['id']; ?></h2>
    <p>Tanggal: <?php echo $transaksi['tanggal']; ?></p>
    <p>Total: Rp <?php echo number_format($transaksi['total'], 0, ',', '.'); ?></p>

    <table border="1">
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
        <?php
        while ($row = $result_detail->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nama_produk']}</td>
                    <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                    <td>{$row['jumlah']}</td>
                    <td>Rp " . number_format($row['subtotal'], 0, ',', '.') . "</td>
                  </tr>";
        }
        ?>
    </table>

    <a href="laporan.php">Kembali ke Laporan</a>
</body>
</html>