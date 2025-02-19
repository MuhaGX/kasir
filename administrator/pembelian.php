<?php
include '../koneksi.php';
include 'navbar.php';

session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] != "admin") {
    header("Location: ../login.php");
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['barcode']) && !empty($_POST['barcode'])) {
        $barcode = $_POST['barcode'];
        $sql = "SELECT * FROM produk WHERE barcode = '$barcode'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $produk = $result->fetch_assoc();
            $found = false;
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item['id'] == $produk['id']) {
                    $_SESSION['cart'][$key]['jumlah'] += 1;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $produk['jumlah'] = 1;
                $_SESSION['cart'][] = $produk;
            }
        } else {
            echo "<script>alert('Produk tidak ditemukan!');</script>";
        }
    }
    
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['jumlah'] as $key => $jumlah) {
            if ($jumlah > 0) {
                $_SESSION['cart'][$key]['jumlah'] = $jumlah;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Minimarket</title>
    <script>
        function updateCart(key, value) {
            let form = document.createElement("form");
            form.method = "post";
            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "jumlah[" + key + "]";
            input.value = value;
            form.appendChild(input);
            let hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "update_cart";
            hiddenInput.value = "1";
            form.appendChild(hiddenInput);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>
<body>
    <h2>Kasir Minimarket</h2>
    
    <form method="post">
        <input type="text" name="barcode" placeholder="Scan Barcode..." autofocus required>
        <button type="submit">Tambah</button>
    </form>

    <h3>Daftar Belanja</h3>
    <table border="1">
        <tr>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
        </tr>
        <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $key => $item) {
            echo "<tr>
                    <td>{$item['nama_produk']}</td>
                    <td><input type='number' value='{$item['jumlah']}' min='1' onchange='updateCart($key, this.value)'></td>
                    <td>Rp " . number_format($item['harga'] * $item['jumlah'], 0, ',', '.') . "</td>
                  </tr>";
            $total += $item['harga'] * $item['jumlah'];
        }
        ?>
        <tr>
            <td><b>Total</b></td>
            <td></td>
            <td><b>Rp <?php echo number_format($total, 0, ',', '.'); ?></b></td>
        </tr>
    </table>

    <form method="post" action="reset.php">
        <button type="submit">Reset Transaksi</button>
    </form>

    <form method="post" action="checkout.php">
        <button type="submit">Checkout</button>
    </form>
</body>
</html>
