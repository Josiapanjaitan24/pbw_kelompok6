<?php
include "koneksi.php";

echo "<h2>Database Update Script</h2>";

// 1. Tambah kolom is_admin jika belum ada
echo "<h3>1. Checking is_admin column...</h3>";
$check_is_admin = mysqli_query($conn, "SHOW COLUMNS FROM users LIKE 'is_admin'");
if (mysqli_num_rows($check_is_admin) == 0) {
    $add_is_admin = mysqli_query($conn, "ALTER TABLE users ADD COLUMN is_admin INT DEFAULT 0");
    if ($add_is_admin) {
        echo "✓ Kolom 'is_admin' berhasil ditambahkan<br>";
    } else {
        echo "✗ Gagal menambah kolom 'is_admin': " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "✓ Kolom 'is_admin' sudah ada<br>";
}

// 2. Set user dengan ID 6 (Josia) sebagai admin
echo "<h3>2. Setting Admin...</h3>";
$set_admin = mysqli_query($conn, "UPDATE users SET is_admin = 1 WHERE id = 6");
if ($set_admin) {
    echo "✓ User ID 6 (Josia panjaitan) berhasil dijadikan Admin<br>";
} else {
    echo "✗ Gagal: " . mysqli_error($conn) . "<br>";
}

// 3. Verifikasi
echo "<h3>3. Verifikasi Data Users:</h3>";
$verify = mysqli_query($conn, "SELECT id, nama_lengkap, email, is_admin FROM users");
echo "<table border='1' style='border-collapse: collapse; margin-top: 10px;'>";
echo "<tr style='background: #333; color: white;'>";
echo "<th style='padding: 10px;'>ID</th>";
echo "<th style='padding: 10px;'>Nama Lengkap</th>";
echo "<th style='padding: 10px;'>Email</th>";
echo "<th style='padding: 10px;'>Admin Status</th>";
echo "</tr>";

while ($row = mysqli_fetch_assoc($verify)) {
    echo "<tr>";
    echo "<td style='padding: 10px;'>" . $row['id'] . "</td>";
    echo "<td style='padding: 10px;'>" . $row['nama_lengkap'] . "</td>";
    echo "<td style='padding: 10px;'>" . $row['email'] . "</td>";
    echo "<td style='padding: 10px;'>" . ($row['is_admin'] == 1 ? '✓ ADMIN' : '✗ User') . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<h3>✓ Database Update Selesai!</h3>";
echo "<p><a href='admin_produk.php' style='background: #4caf50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Admin Produk</a></p>";

mysqli_close($conn);
?>
