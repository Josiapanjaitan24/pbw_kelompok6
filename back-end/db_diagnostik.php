<?php
session_start();
include "koneksi.php";

// Cek apakah user admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: admin_login.php");
    exit;
}

echo "<h2>Database Diagnostik</h2>";

// Check structure produk table
echo "<h3>1. Struktur Tabel Produk</h3>";
$desc = mysqli_query($conn, "DESCRIBE produk");
echo "<table border='1' style='border-collapse: collapse;'>";
while ($row = mysqli_fetch_assoc($desc)) {
    echo "<tr>";
    foreach ($row as $val) echo "<td style='padding: 5px;'>" . $val . "</td>";
    echo "</tr>";
}
echo "</table>";

// Check all products
echo "<h3>2. Semua Produk di Database</h3>";
$result = mysqli_query($conn, "SELECT * FROM produk ORDER BY id ASC");
echo "<table border='1' style='border-collapse: collapse; margin-top: 10px;'>";
echo "<tr style='background: #333; color: white;'>";
echo "<th>ID</th><th>Nama</th><th>Harga</th><th>Kategori</th><th>Foto</th><th>Deskripsi (preview)</th><th>Spesifikasi</th>";
echo "</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['nama'] . "</td>";
    echo "<td>" . $row['harga'] . "</td>";
    echo "<td>" . $row['kategori'] . "</td>";
    echo "<td>" . $row['foto'] . "</td>";
    echo "<td>" . substr($row['deskripsi'], 0, 50) . "...</td>";
    echo "<td>" . substr($row['spesifikasi'], 0, 50) . "...</td>";
    echo "</tr>";
}
echo "</table>";

// Check AUTO_INCREMENT
echo "<h3>3. AUTO_INCREMENT Status</h3>";
$ai = mysqli_query($conn, "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'projectpbw' AND TABLE_NAME = 'produk'");
$ai_row = mysqli_fetch_assoc($ai);
echo "Next AUTO_INCREMENT: " . $ai_row['AUTO_INCREMENT'] . "<br>";

// Recommendation
echo "<h3>4. Rekomendasi Perbaikan</h3>";
echo "Jika ID bertabrakan (product ID kurang dari 11), jalankan:<br>";
echo "<code>ALTER TABLE produk AUTO_INCREMENT = 101;</code><br>";
echo "<code>UPDATE produk SET id = id + 100 WHERE id < 11;</code>";

mysqli_close($conn);
?>
