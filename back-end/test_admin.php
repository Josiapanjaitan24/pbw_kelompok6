<?php
session_start();

// Simulasi admin session untuk testing
if (!isset($_SESSION['is_admin'])) {
    $_SESSION['is_admin'] = 1;
    $_SESSION['user_id'] = 1;
    $_SESSION['username'] = 'admin';
    echo "<h2>✓ Session admin sudah diset untuk testing</h2>";
}

// Test koneksi database
include "koneksi.php";

echo "<h2>Diagnostic Produk Management System</h2>";

// 1. Test Database Connection
echo "<h3>1. Koneksi Database</h3>";
if ($conn) {
    echo "✓ Database terhubung<br>";
} else {
    echo "✗ Database tidak terhubung: " . mysqli_connect_error() . "<br>";
    exit;
}

// 2. Test Table Structure
echo "<h3>2. Struktur Table Produk</h3>";
$result = mysqli_query($conn, "DESCRIBE produk");
if ($result) {
    echo "✓ Table produk ada<br>";
    echo "<table border='1' style='margin-top: 10px;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['Field']}</td>";
        echo "<td>{$row['Type']}</td>";
        echo "<td>{$row['Null']}</td>";
        echo "<td>{$row['Key']}</td>";
        echo "<td>{$row['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "✗ Error: " . mysqli_error($conn) . "<br>";
}

// 3. Test Upload Folder
echo "<h3>3. Upload Folder</h3>";
$upload_dir = "../uploads/produk/";
if (is_dir($upload_dir)) {
    echo "✓ Folder $upload_dir sudah ada<br>";
} else {
    echo "✗ Folder $upload_dir tidak ada<br>";
    if (@mkdir($upload_dir, 0777, true)) {
        echo "✓ Folder berhasil dibuat<br>";
    } else {
        echo "✗ Gagal membuat folder<br>";
    }
}

// 4. Test Current Products
echo "<h3>4. Produk Saat Ini</h3>";
$produk_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM produk");
$produk_count = mysqli_fetch_assoc($produk_result);
echo "Total produk: " . $produk_count['total'] . "<br>";

if ($produk_count['total'] > 0) {
    echo "<table border='1' style='margin-top: 10px;'>";
    echo "<tr><th>ID</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Kategori</th></tr>";
    $list = mysqli_query($conn, "SELECT id, nama, harga, stok, kategori FROM produk LIMIT 5");
    while ($row = mysqli_fetch_assoc($list)) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['nama']}</td>";
        echo "<td>Rp " . number_format($row['harga']) . "</td>";
        echo "<td>{$row['stok']}</td>";
        echo "<td>{$row['kategori']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// 5. Link ke Admin Pages
echo "<h3>5. Navigation</h3>";
echo "<ul>";
echo "<li><a href='admin_produk.php'>Go to Admin Produk Page</a></li>";
echo "<li><a href='tambah_produk.php'>Go to Tambah Produk Form</a></li>";
echo "</ul>";

mysqli_close($conn);
?>
