<?php
session_start();
include "koneksi.php";

// Cek apakah user admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: admin_login.php");
    exit;
}

$produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Kelola Produk</title>
    <link rel="stylesheet" href="../src/css/style.css">
    <style>
        body {
            background: linear-gradient(180deg, #0f0f0f, #1a1a1a);
            padding: 80px 40px 40px;
            color: #f5f5f5;
            font-family: 'Poppins', Arial, sans-serif;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .admin-header h1 {
            color: #ffcc00;
            font-size: 2rem;
            margin: 0;
        }

        .btn-tambah {
            background: linear-gradient(135deg, #ffcc00, #ffd633);
            color: #1a1a1a;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-tambah:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 204, 0, 0.4);
        }

        .btn-logout {
            background: #ff4b5c;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: #ff1f3c;
        }

        .table-container {
            background: rgba(30, 30, 30, 0.95);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.5);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #222;
            color: #ffcc00;
            padding: 15px;
            text-align: left;
            font-weight: 700;
            border-bottom: 2px solid #ffcc00;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #444;
            color: #cfcfcf;
        }

        tr:hover {
            background: #2a2a2a;
        }

        img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #444;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-edit,
        .btn-delete {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            font-size: 12px;
        }

        .btn-edit {
            background: #667eea;
            color: white;
        }

        .btn-edit:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #ff5252;
            color: white;
        }

        .btn-delete:hover {
            background: #ff1744;
            transform: translateY(-2px);
        }

        .empty-message {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .price {
            color: #ffcc00;
            font-weight: 700;
        }

        .stok {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .stok.high {
            background: rgba(76, 175, 80, 0.2);
            color: #4caf50;
        }

        .stok.low {
            background: rgba(255, 76, 76, 0.2);
            color: #ff4c4c;
        }

        @media (max-width: 768px) {
            body {
                padding: 100px 20px 40px;
            }

            .admin-header {
                flex-direction: column;
                align-items: flex-start;
            }

            table {
                font-size: 12px;
            }

            td, th {
                padding: 10px;
            }

            img {
                width: 60px;
                height: 60px;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="admin-header">
    <h1>📦 Kelola Produk</h1>
    <div style="display: flex; gap: 10px;">
        <a href="tambah_produk.php" class="btn-tambah">+ Tambah Produk</a>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</div>

<?php 
// Tampilkan pesan sukses/error
if (isset($_GET['success'])): ?>
<div style="background: #4caf50; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
    ✓ <?= htmlspecialchars($_GET['success']) ?>
</div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
<div style="background: #ff5252; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
    ✗ <?= htmlspecialchars($_GET['error']) ?>
</div>
<?php endif; ?>

<div class="table-container">
    <?php if (mysqli_num_rows($produk) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($produk)): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td>
                    <?php if (isset($row['foto']) && !empty($row['foto'])): ?>
                        <img src="../uploads/produk/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>">
                    <?php else: ?>
                        <img src="../src/img/no-image.jpg" alt="No Image">
                    <?php endif; ?>
                </td>
                <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td>
                <td class="price">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td>
                    <span class="stok <?= $row['stok'] > 20 ? 'high' : 'low' ?>">
                        <?= $row['stok'] ?> pcs
                    </span>
                </td>
                <td><?= htmlspecialchars($row['kategori']) ?></td>
                <td>
                    <div class="action-buttons">
                        <a href="edit_produk.php?id=<?= $row['id'] ?>" class="btn-edit">✏️ Edit</a>
                        <a href="hapus_produk.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Hapus produk ini?')">🗑️ Hapus</a>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="empty-message">
        <p>Belum ada produk. <a href="tambah_produk.php" style="color: #ffcc00; text-decoration: underline;">Tambah produk baru</a></p>
    </div>
    <?php endif; ?>
</div>

</body>
</html>