<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Keranjang kosong!'); window.location='index.php';</script>";
    exit();
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['harga'];
}

$sql = "INSERT INTO transaksi (total) VALUES ('$total')";
if ($conn->query($sql) === TRUE) {
    $transaksi_id = $conn->insert_id;

    foreach ($_SESSION['cart'] as $item) {
        $produk_id = $item['id'];
        $nama_produk = $item['nama_produk'];
        $harga = $item['harga'];
        $sql_detail = "INSERT INTO transaksi_detail (transaksi_id, produk_id, nama_produk, harga)
                       VALUES ('$transaksi_id', '$produk_id', '$nama_produk', '$harga')";
        $conn->query($sql_detail);
    }

    unset($_SESSION['cart']);
    echo "<script>window.location='index.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
