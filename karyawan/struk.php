<?php
include '../koneksi.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: pembelian.php");
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
    <title>Struk Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                width: 80mm !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
</head>
<body class="p-2">
    <div class="text-center mb-1">
        <h5 class="mb-0 fw-bold">MINIMARKET KASIRKU</h5>
        <p class="mb-0 small">Jl. Contoh No. 123, Kota</p>
        <p class="mb-0 small">Telp: 08123456789</p>
    </div>

    <div class="mb-1 small">
        <p class="mb-0">No. Transaksi: <?= $transaksi['id'] ?></p>
        <p class="mb-0">Tanggal: <?= date('d/m/Y H:i:s', strtotime($transaksi['tanggal'])) ?></p>
    </div>

    <div class="mb-1">
        <?php while ($row = $result_detail->fetch_assoc()): ?>
        <p class="mb-0 fw-bold"><?= $row['nama_produk'] ?></p>
        <div class="d-flex justify-content-between mb-1">
            <span><?= $row['jumlah'] ?> x <?= number_format($row['harga'], 0, ',', '.') ?></span>
            <span>Rp <?= number_format($row['subtotal'], 0, ',', '.') ?></span>
        </div>
        <?php endwhile; ?>
    </div>

    <hr class="my-1">

    <div class="mb-1">
        <div class="d-flex justify-content-between">
            <span>Total</span>
            <span>Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></span>
        </div>
        <div class="d-flex justify-content-between">
            <span>Bayar</span>
            <span>Rp <?= number_format($transaksi['pembayaran'], 0, ',', '.') ?></span>
        </div>
        <div class="d-flex justify-content-between fw-bold">
            <span>Kembalian</span>
            <span>Rp <?= number_format($transaksi['kembalian'], 0, ',', '.') ?></span>
        </div>
    </div>

    <div class="text-center mt-2 small">
        <p class="mb-0">Terima kasih telah berbelanja</p>
        <p class="mb-0">Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</p>
    </div>

    <div class="no-print mt-2 text-center">
        <button class="btn btn-primary btn-sm" onclick="window.print()">Cetak Struk</button>
        <button class="btn btn-secondary btn-sm" onclick="window.location.href='pembelian.php'">Kembali ke Kasir</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        if (window.location.search.indexOf('autoprint') > -1) {
            window.print();
        }
    </script>
</body>
</html>