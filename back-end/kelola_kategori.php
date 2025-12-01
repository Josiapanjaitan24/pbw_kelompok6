<?php
session_start();
include "koneksi.php";

// Cek apakah user admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: admin_login.php");
    exit;
}

// Cek apakah tabel kategori ada, jika tidak redirect ke setup
$check_table = mysqli_query($conn, "SHOW TABLES LIKE 'kategori'");
if (mysqli_num_rows($check_table) == 0) {
    echo "<script>alert('❌ Tabel kategori belum dibuat!\\n\\nSilakan jalankan setup_kategori.php terlebih dahulu.');</script>";
    echo "<a href='setup_kategori.php' style='background: #ff9800; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔧 Buka Setup Kategori</a>";
    exit;
}

// Proses tambah kategori
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'tambah') {
        $nama = trim($_POST['nama_kategori']);
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        
        if (!empty($nama)) {
            $check = mysqli_query($conn, "SELECT id FROM kategori WHERE nama_kategori = '$nama'");
            if (mysqli_num_rows($check) > 0) {
                $message = "⚠️ Kategori sudah ada!";
            } else {
                $query = "INSERT INTO kategori (nama_kategori, deskripsi) VALUES ('$nama', '$deskripsi')";
                if (mysqli_query($conn, $query)) {
                    $message = "✓ Kategori berhasil ditambahkan!";
                } else {
                    $message = "✗ Gagal menambah kategori: " . mysqli_error($conn);
                }
            }
        } else {
            $message = "✗ Nama kategori tidak boleh kosong!";
        }
    } elseif ($_POST['action'] == 'hapus') {
        $id = (int)$_POST['id'];
        
        // Cek apakah kategori masih digunakan
        $check = mysqli_query($conn, "SELECT COUNT(*) as total FROM produk WHERE kategori = (SELECT nama_kategori FROM kategori WHERE id = $id)");
        $result = mysqli_fetch_assoc($check);
        
        if ($result['total'] > 0) {
            $message = "⚠️ Kategori tidak bisa dihapus karena masih ada " . $result['total'] . " produk!";
        } else {
            $query = "DELETE FROM kategori WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                $message = "✓ Kategori berhasil dihapus!";
            } else {
                $message = "✗ Gagal menghapus kategori!";
            }
        }
    }
}

// Ambil semua kategori
$kategori_list = mysqli_query($conn, "SELECT k.id, k.nama_kategori, k.deskripsi, k.tanggal_dibuat, COUNT(p.id) as total_produk 
                                       FROM kategori k 
                                       LEFT JOIN produk p ON p.kategori = k.nama_kategori 
                                       GROUP BY k.id 
                                       ORDER BY k.nama_kategori ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Kategori</title>
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

        .btn-kembali {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-kembali:hover {
            background: #45a049;
        }

        .container {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
        }

        .form-container {
            background: rgba(30, 30, 30, 0.95);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.5);
            height: fit-content;
        }

        .form-container h2 {
            color: #ffcc00;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.5rem;
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
        textarea {
            width: 100%;
            padding: 10px;
            background: #2a2a2a;
            border: 1px solid #444;
            border-radius: 6px;
            color: white;
            box-sizing: border-box;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #ffcc00;
            background: #333;
        }

        textarea {
            resize: vertical;
            min-height: 60px;
        }

        button {
            width: 100%;
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

        .message {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            background: #222;
            border-left: 3px solid #ffcc00;
            color: #ffcc00;
        }

        .message.error {
            border-left-color: #ff4b5c;
            color: #ff4b5c;
        }

        .message.success {
            border-left-color: #4CAF50;
            color: #4CAF50;
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
            background: rgba(255, 204, 0, 0.05);
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            background: #ffcc00;
            color: #1a1a1a;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .btn-hapus {
            background: #ff4b5c;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-hapus:hover {
            background: #ff1f3c;
        }

        .empty-message {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }

        @media (max-width: 900px) {
            .container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="admin-header">
    <h1>📂 Kelola Kategori</h1>
    <a href="admin_produk.php" class="btn-kembali">← Kembali ke Produk</a>
</div>

<div class="container">
    <!-- Form Tambah Kategori -->
    <div class="form-container">
        <h2>Tambah Kategori Baru</h2>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo (strpos($message, '✓') !== false) ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="action" value="tambah">
            
            <div class="form-group">
                <label for="nama_kategori">Nama Kategori *</label>
                <input type="text" id="nama_kategori" name="nama_kategori" placeholder="Contoh: Kemeja, Kaos, Jaket" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi (Opsional)</label>
                <textarea id="deskripsi" name="deskripsi" placeholder="Jelaskan kategori ini..."></textarea>
            </div>

            <button type="submit">✓ Tambah Kategori</button>
        </form>
    </div>

    <!-- Daftar Kategori -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($kategori_list) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($kategori_list)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nama_kategori']; ?></td>
                            <td><?php echo $row['deskripsi'] ?? '-'; ?></td>
                            <td><span class="badge"><?php echo $row['total_produk']; ?></span></td>
                            <td>
                                <?php if ($row['total_produk'] == 0): ?>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Hapus kategori ini?');">
                                        <input type="hidden" name="action" value="hapus">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="btn-hapus">🗑️ Hapus</button>
                                    </form>
                                <?php else: ?>
                                    <span style="color: #999; font-size: 0.9rem;">Tidak bisa dihapus</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty-message">
                            Belum ada kategori. Tambahkan kategori baru di form sebelah kiri.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php mysqli_close($conn); ?>

</body>
</html>
