<?php
include '../koneksi.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID produk tidak valid!'); window.location='tambah_produk.php';</script>";
    exit();
}

$id_produk = $_GET['id'];

$sql = "SELECT * FROM produk WHERE id = '$id_produk'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_produk'])) {
    $sql = "UPDATE produk SET nama_produk = '".$_POST['nama_produk']."', barcode = '".$_POST['barcode']."', harga = '".$_POST['harga']."' WHERE id = '".$_POST['id_produk']."'";
    $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
</head>
<body>
    <h2>Edit Produk</h2>
    <form method="POST">
        <label>Nama Produk:</label>
        <input type="text" name="nama_produk" value="<?php echo $row['nama_produk']; ?>" required><br>

        <label>Barcode:</label>
        <input type="text" name="barcode" value="<?php echo $row['barcode']; ?>" required><br>

        <label>Harga:</label>
        <input type="number" name="harga" value="<?php echo $row['harga']; ?>" required><br>

        <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>">

        <button type="submit" name="edit_produk">Edit Produk</button>
    </form>
    <br>
    <a href="tambah_produk.php">Kembali ke Daftar Produk</a>
</body>
</html>