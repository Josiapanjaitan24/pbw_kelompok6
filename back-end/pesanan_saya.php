<?php
session_start();
require "../back-end/koneksi.php";

// Jika user belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user = $_SESSION['username'];

// Ambil pesanan berdasarkan nama_lengkap = username
$query = "SELECT * FROM orders WHERE nama_lengkap = '$user' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Saya</title>
    <style>
        /* ===== Body & Layout ===== */
        body {
            background-color: #1f1f1f;
            color: #f0f0f0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            padding: 30px 0 10px 0;
            font-size: 2em;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background-color: #2c2c2c;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.5);
        }

        /* ===== Tabel Pesanan ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #3a3a3a;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #555;
        }

        th {
            background-color: #444;
        }

        tr:hover {
            background-color: #505050;
        }

        /* ===== Tombol Kembali ===== */
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background: linear-gradient(135deg, #ff4b5c, #ff6f61);
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, #ff1f3c, #ff3f33);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.4);
        }

        p.no-order {
            text-align: center;
            margin-top: 20px;
            font-size: 1.1em;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Pesanan Saya</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Produk</th>
                <th>Ukuran</th>
                <th>Metode Pembayaran</th>
                <th>Tanggal Pesan</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['produk_dipesan'] ?></td>
                    <td><?= $row['ukuran'] ?></td>
                    <td><?= $row['metode_pembayaran'] ?></td>
                    <td><?= $row['tanggal pesan'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p class="no-order">Belum ada pesanan.</p>
    <?php endif; ?>

    <a href="../front-end/home.html" class="back-btn">⬅ Kembali</a>
</div>

</body>
</html>