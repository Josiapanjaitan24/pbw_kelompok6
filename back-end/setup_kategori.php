<?php
include "koneksi.php";

echo "<style>
    body { font-family: Arial; margin: 20px; background: #f5f5f5; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .warning { color: orange; font-weight: bold; }
    .info { color: blue; margin: 10px 0; }
    hr { border: 1px solid #ddd; }
</style>";

echo "<h2>🔧 Setup Tabel Kategori</h2>";
echo "<hr>";

// 1. Cek apakah tabel kategori sudah ada
echo "<h3>1. Checking tabel kategori...</h3>";
$check_table = mysqli_query($conn, "SHOW TABLES LIKE 'kategori'");

if (mysqli_num_rows($check_table) > 0) {
    echo "<span class='warning'>⚠️ Tabel 'kategori' sudah ada, skip membuat tabel</span><br>";
} else {
    echo "<span class='info'>Membuat tabel 'kategori'...</span><br>";
    
    $create_kategori = "
    CREATE TABLE `kategori` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `nama_kategori` varchar(100) NOT NULL UNIQUE,
      `deskripsi` text DEFAULT NULL,
      `tanggal_dibuat` timestamp DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ";
    
    if (mysqli_query($conn, $create_kategori)) {
        echo "<span class='success'>✓ Tabel 'kategori' berhasil dibuat</span><br>";
    } else {
        echo "<span class='error'>✗ Error: " . mysqli_error($conn) . "</span><br>";
        mysqli_close($conn);
        exit;
    }
}

// 2. Insert kategori default
echo "<h3>2. Menambahkan kategori default...</h3>";

$default_categories = array(
    'Kemeja',
    'Kaos',
    'Polo',
    'Jaket',
    'Celana',
    'Aksesoris',
    'Sepatu',
    'Tas'
);

$added = 0;
$skipped = 0;

foreach ($default_categories as $cat) {
    $check = mysqli_query($conn, "SELECT id FROM kategori WHERE nama_kategori = '$cat'");
    if (mysqli_num_rows($check) == 0) {
        $insert = mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ('$cat')");
        if ($insert) {
            echo "<span class='success'>✓ '$cat' ditambahkan</span><br>";
            $added++;
        } else {
            echo "<span class='error'>✗ Gagal menambah '$cat': " . mysqli_error($conn) . "</span><br>";
        }
    } else {
        echo "<span class='warning'>⚠️ '$cat' sudah ada</span><br>";
        $skipped++;
    }
}

echo "<br><span class='info'>Summary: $added kategori ditambahkan, $skipped sudah ada</span>";

// 3. Update produk yang belum punya kategori dari tabel produk
echo "<h3>3. Verifikasi struktur produk table...</h3>";

$check_produk = mysqli_query($conn, "SHOW COLUMNS FROM produk LIKE 'kategori'");
if (mysqli_num_rows($check_produk) > 0) {
    echo "<span class='success'>✓ Kolom 'kategori' sudah ada di tabel produk</span><br>";
} else {
    echo "<span class='warning'>⚠️ Kolom 'kategori' tidak ada di tabel produk, menambahkan...</span><br>";
    $add_col = mysqli_query($conn, "ALTER TABLE produk ADD COLUMN kategori varchar(100) DEFAULT 'Lainnya'");
    if ($add_col) {
        echo "<span class='success'>✓ Kolom 'kategori' berhasil ditambahkan</span><br>";
    }
}

// 4. Display kategori yang ada
echo "<h3>4. Daftar Kategori Yang Ada:</h3>";
$result = mysqli_query($conn, "SELECT id, nama_kategori FROM kategori ORDER BY id");
echo "<ul>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<li>" . $row['nama_kategori'] . " (ID: " . $row['id'] . ")</li>";
}
echo "</ul>";

// 5. Display statistik produk per kategori
echo "<h3>5. Statistik Produk Per Kategori:</h3>";
$stat = mysqli_query($conn, "SELECT kategori, COUNT(*) as total FROM produk GROUP BY kategori ORDER BY total DESC");
echo "<ul>";
$total_produk = 0;
while ($row = mysqli_fetch_assoc($stat)) {
    echo "<li>" . $row['kategori'] . ": " . $row['total'] . " produk</li>";
    $total_produk += $row['total'];
}
echo "</ul>";
echo "<p><span class='info'><strong>Total Produk: $total_produk</strong></span></p>";

echo "<hr>";
echo "<h3 style='color: green;'>✅ Setup Kategori Selesai!</h3>";
echo "<p>";
echo "  <a href='kelola_kategori.php' style='background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>Kelola Kategori</a>";
echo "  <a href='tambah_produk.php' style='background: #2196F3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>Tambah Produk</a>";
echo "  <a href='admin_produk.php' style='background: #FF9800; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Kembali ke Admin</a>";
echo "</p>";

mysqli_close($conn);
?>
