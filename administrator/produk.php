<?php
include '../koneksi.php';
include 'navbar.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] != "admin") {
    header("Location: ../login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah_produk'])) {
        $sql = "INSERT INTO produk (nama_produk, barcode, harga) VALUES ('".$_POST['nama_produk']."', '".$_POST['barcode']."', '".$_POST['harga']."')";
        $conn->query($sql);
    } elseif (isset($_POST['edit_produk'])) {
        $sql = "UPDATE produk SET nama_produk = '".$_POST['nama_produk']."', barcode = '".$_POST['barcode']."', harga = '".$_POST['harga']."' WHERE id = '".$_POST['id_produk']."'";
        $conn->query($sql);
    }
}

if (isset($_GET['hapus'])) {
    $sql = "DELETE FROM produk WHERE id = '".$_GET['hapus']."'";
    $conn->query($sql);
}

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    $sql = "SELECT * FROM produk WHERE id = '$id_produk'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
</head>
<body>
    <h2>Tambah Produk Baru</h2>
    <form method="POST">
        <label>Nama Produk:</label>
        <input type="text" name="nama_produk" required><br>

        <label>Barcode:</label>
        <input type="text" name="barcode" required><br>

        <label>Harga:</label>
        <input type="number" name="harga" required><br>

        <button type="submit" name="tambah_produk">Tambah Produk</button>
    </form>
    <br>

    <h2>Daftar Produk</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Barcode</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php
        $sql = "SELECT * FROM produk";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nama_produk']; ?></td>
                <td><?php echo $row['barcode']; ?></td>
                <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                <td>
                    <a href="?hapus=<?php echo $row['id']; ?>">Hapus</a>
                    <form action="" method="post">
                        <input type="hidden" name="id_produk" value="<?php echo $row['id']; ?>">
                        <input type="text" name="nama_produk" value="<?php echo $row['nama_produk']; ?>">
                        <input type="text" name="barcode" value="<?php echo $row['barcode']; ?>">
                        <input type="number" name="harga" value="<?php echo $row['harga']; ?>">
                        <input type="submit" name="edit_produk" value="Edit">
                    </form>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>

    <br>
    <a href="index.php">Kembali ke Kasir</a>
</body>
</html>