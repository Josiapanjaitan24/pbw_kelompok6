<?php
session_start();
include "koneksi.php";

// Hanya admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: admin_login.php");
    exit;
}

// Ambil daftar kategori dari database
$kategori_list = mysqli_query($conn, "SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="../src/css/style.css">
    <style>
        body {
            background: linear-gradient(180deg, #0f0f0f, #1a1a1a);
            padding: 80px 20px 40px;
            color: #f5f5f5;
        }
        .form-box {
            max-width: 600px;
            margin: auto;
            background: rgba(30, 30, 30, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.5);
        }
        .form-box h2 {
            color: #ffcc00;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            color: #cfcfcf;
            margin-bottom: 5px;
            font-weight: 600;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            background: #2a2a2a;
            border: 1px solid #444;
            border-radius: 6px;
            color: white;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }
        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #ffcc00;
            background: #333;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        button {
            flex: 1;
            padding: 12px;
            background: #ffcc00;
            color: #1a1a1a;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        button:hover {
            background: #ffd633;
            transform: translateY(-2px);
        }
        .btn-cancel {
            background: #666;
            color: white;
        }
        .btn-cancel:hover {
            background: #777;
        }
        .spec-box {
            background: #222;
            padding: 15px;
            border-radius: 8px;
            border-left: 3px solid #ffcc00;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>📦 Tambah Produk Baru</h2>

    <form action="simpan_produk.php" method="POST" enctype="multipart/form-data">

        <div class="form-row">
            <div class="form-group">
                <label for="nama">Nama Produk *</label>
                <input type="text" id="nama" name="nama" placeholder="Contoh: Kemeja Navy" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga (Rp) *</label>
                <input type="number" id="harga" name="harga" placeholder="Contoh: 150000" min="1" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" id="stok" name="stok" placeholder="Contoh: 50" min="0" value="0">
            </div>
            <div class="form-group">
                <label for="kategori">Kategori *</label>
                <select id="kategori" name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php 
                    if (mysqli_num_rows($kategori_list) > 0) {
                        while ($row = mysqli_fetch_assoc($kategori_list)) {
                            echo "<option value='" . $row['nama_kategori'] . "'>" . $row['nama_kategori'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <small style="color: #999; display: block; margin-top: 5px;">
                    <a href="kelola_kategori.php" style="color: #ffcc00; text-decoration: none;">➕ Kelola Kategori</a>
                </small>
            </div>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi Produk</label>
            <textarea id="deskripsi" name="deskripsi" placeholder="Jelaskan detail produk, keunggulan, bahan, dll..."></textarea>
        </div>

        <div class="spec-box">
            <h3 style="color: #ffcc00; margin-top: 0;">Spesifikasi Produk</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="bahan">Bahan</label>
                    <input type="text" id="bahan" name="bahan" placeholder="Contoh: Katun premium">
                </div>
                <div class="form-group">
                    <label for="ukuran">Ukuran</label>
                    <input type="text" id="ukuran" name="ukuran" placeholder="Contoh: S, M, L, XL">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="warna">Warna</label>
                    <input type="text" id="warna" name="warna" placeholder="Contoh: Navy, Merah, Hitam">
                </div>
                <div class="form-group">
                    <label for="perawatan">Perawatan</label>
                    <input type="text" id="perawatan" name="perawatan" placeholder="Contoh: Cuci mesin dingin">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="foto">Foto Produk *</label>
            <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/gif" required>
            <small style="color: #999;">Format: JPG, PNG, GIF | Ukuran max: 5MB</small>
        </div>

        <div class="button-group">
            <button type="submit">💾 Simpan Produk</button>
            <a href="admin_produk.php" class="btn-cancel" style="text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center;">Batal</a>
        </div>

    </form>
</div>

</body>
</html>
</div>

</body>
</html>