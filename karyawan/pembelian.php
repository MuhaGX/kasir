<?php
include '../koneksi.php';
include 'navbar.php';

session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] != "karyawan") {
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

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['harga'] * $item['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        // Fungsi untuk memformat nilai ke format Rupiah
        function formatRupiah(angka) {
            return 'Rp ' + parseFloat(angka).toLocaleString('id-ID');
        }

        // Fungsi untuk mengonversi format Rupiah ke angka
        function parseRupiah(rupiah) {
            if (typeof rupiah !== 'string') return 0;
            return parseFloat(rupiah.replace(/[^\d,-]/g, '').replace(',', '.')) || 0;
        }

        // Fungsi untuk menghitung kembalian secara otomatis
        function hitungKembalianOtomatis() {
            const total = <?= $total ?>;
            const pembayaranStr = document.getElementById('pembayaran').value;
            const pembayaran = parseRupiah(pembayaranStr);
            const kembalian = pembayaran - total;
            
            if (kembalian >= 0) {
                document.getElementById('kembalian').value = formatRupiah(kembalian);
            } else {
                document.getElementById('kembalian').value = 'Pembayaran kurang!';
            }
            
            // Update nilai hidden untuk checkout
            document.getElementById('pembayaran-hidden').value = pembayaran;
        }

        // Fungsi untuk memformat input pembayaran
        function formatPembayaranInput() {
            const input = document.getElementById('pembayaran');
            const value = parseRupiah(input.value);
            
            // Jika tidak ada nilai atau NaN, set default ke total
            if (!value || isNaN(value)) {
                input.value = formatRupiah(<?= $total ?>);
            } else {
                input.value = formatRupiah(value);
            }
            
            hitungKembalianOtomatis();
        }

        // Panggil fungsi saat halaman dimuat dan saat input pembayaran berubah
        document.addEventListener('DOMContentLoaded', function() {
            const pembayaranInput = document.getElementById('pembayaran');
            
            // Set nilai awal dengan format Rupiah
            pembayaranInput.value = formatRupiah(<?= $total ?>);
            
            // Ketika input mendapat fokus, hilangkan format untuk memudahkan pengeditan
            pembayaranInput.addEventListener('focus', function() {
                this.value = this.value.replace(/[^\d,-]/g, '');
                this.select();
            });
            
            // Ketika input kehilangan fokus, format kembali ke Rupiah
            pembayaranInput.addEventListener('blur', formatPembayaranInput);
            
            // Event untuk menangani input langsung
            pembayaranInput.addEventListener('input', hitungKembalianOtomatis);
            
            // Inisialisasi kembalian
            hitungKembalianOtomatis();
        });
    </script>
</head>
<body>
    <div class="container mt-3">
        <h2>Kasir</h2>
        
        <form method="post" class="my-3">
            <div class="row g-2">
                <div class="col">
                    <input type="text" class="form-control" name="barcode" placeholder="Scan Barcode..." autofocus required>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" type="submit">Tambah</button>
                </div>
            </div>
        </form>

        <h3>Daftar Belanja</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($_SESSION['cart'] as $key => $item) {
                $subtotal = $item['harga'] * $item['jumlah'];
                echo "<tr>
                        <td>{$item['nama_produk']}</td>
                        <td>Rp " . number_format($item['harga'], 0, ',', '.') . "</td>
                        <td><input type='number' class='form-control' value='{$item['jumlah']}' min='1' onchange='updateCart($key, this.value)'></td>
                        <td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
                    </tr>";
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><b class="fs-4">Total</b></td>
                    <td><b class="fs-4">Rp <?= number_format($total, 0, ',', '.') ?></b></td>
                </tr>
            </tfoot>
        </table>

        <div class="row mb-3">
            <div class="col-md-6 fs-4">
                <label for="pembayaran" class="form-label">Pembayaran (Rp)</label>
                <input type="text" class="form-control" id="pembayaran" required>
            </div>
            <div class="col-md-6 fs-4">
                <label class="form-label">Kembalian (Rp)</label>
                <input type="text" class="form-control" id="kembalian" readonly value="0">
            </div>
        </div>

        <div class="d-flex gap-2">
            <form method="post" action="reset.php">
                <button class="btn btn-danger" type="submit">Reset Transaksi</button>
            </form>
            <form method="post" action="checkout.php">
                <input type="hidden" name="pembayaran" id="pembayaran-hidden" value="<?= $total ?>">
                <button class="btn btn-primary" type="submit">Checkout</button>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>