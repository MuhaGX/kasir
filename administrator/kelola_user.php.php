<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] != "admin") {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    $sql_update = "UPDATE user SET username = '$username', password = '$password', level = '$level' WHERE id = '$id'";
    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Data pengguna berhasil diperbarui!'); window.location='kelola_user.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data pengguna!');</script>";
    }
}

$sql_user = "SELECT * FROM user";
$result_user = $conn->query($sql_user);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna</title>
</head>
<body>
    <h2>Kelola Pengguna</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Level</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result_user->fetch_assoc()) { ?>
        <tr>
            <form method="post">
                <td><?php echo $row['id']; ?></td>
                <td><input type="text" name="username" value="<?php echo $row['username']; ?>" required></td>
                <td><input type="text" name="password" value="<?php echo $row['password']; ?>" required></td>
                <td>
                    <select name="level">
                        <option value="admin" <?php if ($row['level'] == 'admin') echo 'selected'; ?>>Admin</option>
                        <option value="karyawan" <?php if ($row['level'] == 'karyawan') echo 'selected'; ?>>Karyawan</option>
                    </select>
                </td>
                <td>
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="update">Update</button>
                </td>
            </form>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
