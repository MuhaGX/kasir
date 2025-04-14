<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Keranjang kosong!'); window.location='pembelian.php';</script>";
    exit();
}

if (!isset($_POST['pembayaran']) || empty($_POST['pembayaran'])) {
    echo "<script>alert('Masukkan jumlah pembayaran!'); window.location='pembelian.php';</script>";
    exit();
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['harga'] * $item['jumlah'];
}

$pembayaran = $_POST['pembayaran'];
if ($pembayaran < $total) {
    echo "<script>alert('Jumlah pembayaran kurang!'); window.location='pembelian.php';</script>";
    exit();
}

$kembalian = $pembayaran - $total;

$sql = "INSERT INTO transaksi (total, pembayaran, kembalian) VALUES ('$total', '$pembayaran', '$kembalian')";
if ($conn->query($sql) === TRUE) {
    $transaksi_id = $conn->insert_id;

    foreach ($_SESSION['cart'] as $item) {
        $produk_id = $item['id'];
        $nama_produk = $item['nama_produk'];
        $harga = $item['harga'];
        $jumlah = $item['jumlah'];
        $subtotal = $harga * $jumlah;

        $sql_detail = "INSERT INTO transaksi_detail (transaksi_id, produk_id, nama_produk, harga, jumlah, subtotal)
                       VALUES ('$transaksi_id', '$produk_id', '$nama_produk', '$harga', '$jumlah', '$subtotal')";
        $conn->query($sql_detail);
    }

    unset($_SESSION['cart']);
    echo "<script>window.location='struk.php?id=$transaksi_id&autoprint=1';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>