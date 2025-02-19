ALTER TABLE transaksi_detail 
ADD COLUMN jumlah INT NOT NULL DEFAULT 1,
ADD COLUMN subtotal INT NOT NULL DEFAULT 0;


CREATE TABLE transaksi_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaksi_id INT NOT NULL,
    produk_id INT NOT NULL,
    nama_produk VARCHAR(255) NOT NULL,
    harga INT NOT NULL,
    jumlah INT NOT NULL DEFAULT 1,
    subtotal INT NOT NULL DEFAULT 0,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id),
    FOREIGN KEY (produk_id) REFERENCES produk(id)
);
