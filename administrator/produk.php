<?php
include '../koneksi.php';
include 'navbar.php';
session_start();

// Cek login admin
if (!isset($_SESSION['username']) || $_SESSION['level'] != "admin") {
    header("Location: ../login.php");
    exit();
}

// Handle tambah produk
if (isset($_POST['tambah_produk'])) {
    $nama = $conn->real_escape_string($_POST['nama_produk']);
    $barcode = $conn->real_escape_string($_POST['barcode']);
    $harga = (int)$_POST['harga'];
    $conn->query("INSERT INTO produk (nama_produk, barcode, harga) VALUES ('$nama', '$barcode', $harga)");
}

// Handle edit produk
if (isset($_POST['edit_produk'])) {
    $id = (int)$_POST['id'];
    $nama = $conn->real_escape_string($_POST['nama_produk']);
    $barcode = $conn->real_escape_string($_POST['barcode']);
    $harga = (int)$_POST['harga'];
    $conn->query("UPDATE produk SET nama_produk='$nama', barcode='$barcode', harga=$harga WHERE id=$id");
}

// Handle hapus produk
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $conn->query("DELETE FROM produk WHERE id=$id");
}

// Ambil data produk
$produk = $conn->query("SELECT * FROM produk ORDER BY nama_produk");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Produk</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <h2 class="mb-3">Tambah Produk Baru</h2>
        <form method="post" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nama_produk" placeholder="Nama Produk" required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="barcode" placeholder="Barcode" required>
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control" name="harga" placeholder="Harga" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100" name="tambah_produk">Tambah</button>
                </div>
            </div>
        </form>

        <h2 class="mb-3">Daftar Produk</h2>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Barcode</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $produk->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td>
                        <form method="post" class="mb-0">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="text" class="form-control form-control-sm" name="nama_produk" value="<?= htmlspecialchars($row['nama_produk']) ?>">
                    </td>
                    <td>
                            <input type="text" class="form-control form-control-sm" name="barcode" value="<?= htmlspecialchars($row['barcode']) ?>">
                    </td>
                    <td>
                            <input type="number" class="form-control form-control-sm" name="harga" value="<?= $row['harga'] ?>">
                    </td>
                    <td>
                            <button type="submit" class="btn btn-sm btn-success me-1" name="edit_produk">Simpan</button>
                        </form>
                        <a href="?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus produk ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>