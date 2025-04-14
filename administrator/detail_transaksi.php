<?php
include '../koneksi.php';
include 'navbar.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['level'] != "admin") {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID transaksi tidak valid!</div>";
    header("Refresh: 2; url=transaksi.php");
    exit();
}

$transaksi_id = $_GET['id'];
$transaksi = $conn->query("SELECT * FROM transaksi WHERE id = '$transaksi_id'")->fetch_assoc();
$detail = $conn->query("SELECT * FROM transaksi_detail WHERE transaksi_id = '$transaksi_id'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <h3 class="mb-3">Detail Transaksi #<?= $transaksi['id'] ?></h3>
        
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-2">
                    <strong>Tanggal:</strong> <?= $transaksi['tanggal'] ?>
                </div>
                <div class="mb-2">
                    <strong>Total:</strong> Rp <?= number_format($transaksi['total'], 0, ',', '.') ?>
                </div>
                <div class="mb-2">
                    <strong>Pembayaran:</strong> Rp <?= number_format($transaksi['pembayaran'], 0, ',', '.') ?>
                </div>
                <div class="mb-2">
                    <strong>Kembalian:</strong> Rp <?= number_format($transaksi['kembalian'], 0, ',', '.') ?>
                </div>
            </div>
        </div>

        <h4>Daftar Produk</h4>
        <table class="table table-bordered">
            <tr class="table-primary">
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
            <?php while($row = $detail->fetch_assoc()): ?>
            <tr>
                <td><?= $row['nama_produk'] ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td>Rp <?= number_format($row['subtotal'], 0, ',', '.') ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <div class="mt-3">
            <a href="transaksi.php" class="btn btn-secondary btn-sm">Kembali</a>
            <a href="struk.php?id=<?= $transaksi_id ?>" target="_blank" class="btn btn-primary btn-sm">Cetak Struk</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>