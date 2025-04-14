<?php
include '../koneksi.php';
include 'navbar.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] != "admin") {
    header("Location: ../login.php");
    exit();
}

// Initialize variables
$result_user = null;
$error = '';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    $sql_update = "UPDATE user SET username = '$username', password = '$password', level = '$level' WHERE id = '$id'";
    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Data pengguna berhasil diperbarui!'); window.location='kelola_user.php';</script>";
    } else {
        $error = "Gagal memperbarui data pengguna: " . $conn->error;
    }
}

if (isset($_POST['tambah'])) {
    $username = $_POST['new_username'];
    $password = $_POST['new_password'];
    $level = $_POST['new_level'];

    // Check if username already exists
    $sql_check = "SELECT * FROM user WHERE username = '$username'";
    $result_check = $conn->query($sql_check);
    
    if ($result_check->num_rows > 0) {
        $error = "Username sudah digunakan!";
    } else {
        $sql_insert = "INSERT INTO user (username, password, level) VALUES ('$username', '$password', '$level')";
        if ($conn->query($sql_insert) === TRUE) {
            echo "<script>alert('User berhasil ditambahkan!'); window.location='kelola_user.php';</script>";
        } else {
            $error = "Gagal menambahkan user: " . $conn->error;
        }
    }
}

// Get user data
$sql_user = "SELECT * FROM user";
$result_user = $conn->query($sql_user);
if (!$result_user) {
    $error = "Error mendapatkan data user: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <h2>Kelola Pengguna</h2>
        
        <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <!-- Simple Add User Form -->
        <form method="post" class="mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="new_username" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Password</label>
                    <input type="text" class="form-control" name="new_password" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Level</label>
                    <select class="form-select" name="new_level" required>
                        <option value="admin">Admin</option>
                        <option value="karyawan">Karyawan</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-success" name="tambah">Tambah</button>
                </div>
            </div>
        </form>

        <!-- Simple User Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_user && $result_user->num_rows > 0): ?>
                    <?php while ($row = $result_user->fetch_assoc()): ?>
                    <tr>
                        <form method="post">
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><input type="text" class="form-control" name="username" value="<?= htmlspecialchars($row['username']) ?>" required></td>
                            <td><input type="text" class="form-control" name="password" value="<?= htmlspecialchars($row['password']) ?>" required></td>
                            <td>
                                <select class="form-select" name="level">
                                    <option value="admin" <?= $row['level'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="karyawan" <?= $row['level'] == 'karyawan' ? 'selected' : '' ?>>Karyawan</option>
                                </select>
                            </td>
                            <td>
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn btn-primary btn-sm" name="update">Update</button>
                            </td>
                        </form>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data pengguna</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>