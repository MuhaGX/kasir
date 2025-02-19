<?php
include '../koneksi.php';
include 'navbar.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] != "admin") {
    header("Location: ../login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
</head>
<body>
    <h2>Laporan Transaksi</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Detail</th>
        </tr>
        <?php
        $sql = "SELECT * FROM transaksi ORDER BY tanggal DESC";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['tanggal']}</td>
                    <td>Rp " . number_format($row['total'], 0, ',', '.') . "</td>
                    <td><a href='detail_transaksi.php?id={$row['id']}'>Lihat</a></td>
                  </tr>";
        }
        ?>
    </table>

    <a href="index.php">Kembali ke Kasir</a>
</body>
</html>