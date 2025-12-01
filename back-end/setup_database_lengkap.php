<?php
include "koneksi.php";

echo "<style>
    body { font-family: Arial; margin: 20px; background: #f5f5f5; }
    h2 { color: #333; }
    h3 { color: #666; margin-top: 20px; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .warning { color: orange; font-weight: bold; }
    table { border-collapse: collapse; margin-top: 10px; width: 100%; background: white; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    th { background: #4CAF50; color: white; }
    a { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px; }
    a:hover { background: #45a049; }
</style>";

echo "<h2>🔧 Database Initialization Script</h2>";
echo "<hr>";

// 1. CREATE USERS TABLE
echo "<h3>1. Creating 'users' table...</h3>";
$create_users = "
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `is_admin` int(11) DEFAULT 0,
  `tanggal_daftar` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

if (mysqli_query($conn, $create_users)) {
    echo "<span class='success'>✓ Tabel 'users' berhasil dibuat</span><br>";
} else {
    echo "<span class='warning'>⚠️ Tabel 'users' sudah ada atau: " . mysqli_error($conn) . "</span><br>";
}

// 2. CREATE PRODUK TABLE
echo "<h3>2. Creating 'produk' table...</h3>";
$create_produk = "
CREATE TABLE IF NOT EXISTS `produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `spesifikasi` json DEFAULT NULL,
  `tanggal_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `kategori` (`kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

if (mysqli_query($conn, $create_produk)) {
    echo "<span class='success'>✓ Tabel 'produk' berhasil dibuat</span><br>";
} else {
    echo "<span class='warning'>⚠️ Tabel 'produk' sudah ada atau: " . mysqli_error($conn) . "</span><br>";
}

// 3. CREATE ORDERS TABLE
echo "<h3>3. Creating 'orders' table...</h3>";
$create_orders = "
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) NOT NULL,
  `alamat_lengkap` text NOT NULL,
  `nomor_telepon` varchar(20) NOT NULL,
  `produk_dipesan` text NOT NULL,
  `ukuran` varchar(50) DEFAULT NULL,
  `metode_pembayaran` varchar(100) NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `tanggal_pesan` timestamp DEFAULT CURRENT_TIMESTAMP,
  `total_harga` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nama_lengkap` (`nama_lengkap`),
  KEY `tanggal_pesan` (`tanggal_pesan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

if (mysqli_query($conn, $create_orders)) {
    echo "<span class='success'>✓ Tabel 'orders' berhasil dibuat</span><br>";
} else {
    echo "<span class='warning'>⚠️ Tabel 'orders' sudah ada atau: " . mysqli_error($conn) . "</span><br>";
}

// 4. CHECK/INSERT ADMIN USER
echo "<h3>4. Setting up admin user...</h3>";
$check_admin = mysqli_query($conn, "SELECT id FROM users WHERE email = 'josia.panjaitan24@gmail.com'");

if (mysqli_num_rows($check_admin) == 0) {
    // Insert default admin user
    $admin_password = password_hash("admin123", PASSWORD_DEFAULT);
    $insert_admin = "
    INSERT INTO users (nama_lengkap, email, password, is_admin) 
    VALUES ('Josia Panjaitan', 'josia.panjaitan24@gmail.com', '{$admin_password}', 1)
    ";
    
    if (mysqli_query($conn, $insert_admin)) {
        echo "<span class='success'>✓ Admin user berhasil dibuat</span><br>";
        echo "  - Email: josia.panjaitan24@gmail.com<br>";
        echo "  - Password: admin123<br>";
        echo "  <span class='warning'><strong>⚠️ Segera ubah password setelah login!</strong></span><br>";
    } else {
        echo "<span class='error'>✗ Gagal membuat admin user: " . mysqli_error($conn) . "</span><br>";
    }
} else {
    echo "<span class='success'>✓ Admin user sudah ada</span><br>";
    // Ensure is_admin is set to 1
    mysqli_query($conn, "UPDATE users SET is_admin = 1 WHERE email = 'josia.panjaitan24@gmail.com'");
}

// 5. INSERT SAMPLE PRODUCTS
echo "<h3>5. Inserting sample products...</h3>";
$sample_products = array(
    array(
        'nama' => 'Kaos Hitam Premium',
        'harga' => 75000,
        'stok' => 50,
        'kategori' => 'Pakaian',
        'deskripsi' => 'Kaos hitam berkualitas premium dengan bahan katun 100%',
        'spesifikasi' => '{"bahan": "Katun 100%", "ukuran": "M, L, XL", "warna": "Hitam"}'
    ),
    array(
        'nama' => 'Hoodie Putih Nyaman',
        'harga' => 150000,
        'stok' => 30,
        'kategori' => 'Pakaian',
        'deskripsi' => 'Hoodie putih nyaman dengan material fleece',
        'spesifikasi' => '{"bahan": "Fleece", "ukuran": "M, L, XL, XXL", "warna": "Putih"}'
    ),
    array(
        'nama' => 'Celana Jeans Biru',
        'harga' => 200000,
        'stok' => 20,
        'kategori' => 'Pakaian',
        'deskripsi' => 'Celana jeans biru dengan desain modern',
        'spesifikasi' => '{"bahan": "Denim", "ukuran": "28-34", "warna": "Biru"}'
    )
);

$check_existing = mysqli_query($conn, "SELECT COUNT(*) as count FROM produk");
$result = mysqli_fetch_assoc($check_existing);

if ($result['count'] == 0) {
    foreach ($sample_products as $prod) {
        $insert_sql = "INSERT INTO produk (nama, harga, stok, kategori, deskripsi, spesifikasi) 
                       VALUES ('{$prod['nama']}', {$prod['harga']}, {$prod['stok']}, '{$prod['kategori']}', '{$prod['deskripsi']}', '{$prod['spesifikasi']}')";
        if (mysqli_query($conn, $insert_sql)) {
            echo "<span class='success'>✓ Product '{$prod['nama']}' ditambahkan</span><br>";
        } else {
            echo "<span class='error'>✗ Gagal menambah product '{$prod['nama']}': " . mysqli_error($conn) . "</span><br>";
        }
    }
} else {
    echo "<span class='warning'>⚠️ Produk sudah ada (" . $result['count'] . " produk)</span><br>";
}

// 6. VERIFY TABLES
echo "<h3>6. Verifikasi Struktur Database:</h3>";
$verify_tables = mysqli_query($conn, "
    SELECT TABLE_NAME FROM information_schema.TABLES 
    WHERE TABLE_SCHEMA = 'projectpbw' 
    AND TABLE_NAME IN ('users', 'produk', 'orders')
");

echo "<table>";
echo "<tr><th>Tabel</th><th>Status</th></tr>";
$required_tables = array('users', 'produk', 'orders');
$existing_tables = array();

while ($row = mysqli_fetch_assoc($verify_tables)) {
    $existing_tables[] = $row['TABLE_NAME'];
}

foreach ($required_tables as $table) {
    if (in_array($table, $existing_tables)) {
        echo "<tr><td>$table</td><td><span class='success'>✓ Ada</span></td></tr>";
    } else {
        echo "<tr><td>$table</td><td><span class='error'>✗ Tidak Ada</span></td></tr>";
    }
}
echo "</table>";

// 7. DISPLAY DATA
echo "<h3>7. Data Users:</h3>";
$verify = mysqli_query($conn, "SELECT id, nama_lengkap, email, is_admin, tanggal_daftar FROM users");

if (mysqli_num_rows($verify) > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Nama Lengkap</th>";
    echo "<th>Email</th>";
    echo "<th>Admin Status</th>";
    echo "<th>Tanggal Daftar</th>";
    echo "</tr>";

    while ($row = mysqli_fetch_assoc($verify)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nama_lengkap'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . ($row['is_admin'] == 1 ? '<span class="success">✓ ADMIN</span>' : '<span class="warning">✗ User</span>') . "</td>";
        echo "<td>" . $row['tanggal_daftar'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<span class='error'>❌ Tidak ada user dalam database</span><br>";
}

// 8. CHECK PRODUK DATA
echo "<h3>8. Data Produk:</h3>";
$check_produk = mysqli_query($conn, "SELECT COUNT(*) as total FROM produk");
$produk_count = mysqli_fetch_assoc($check_produk);
echo "Total Produk: <span class='success'>" . $produk_count['total'] . " produk</span><br>";

$list_produk = mysqli_query($conn, "SELECT id, nama, harga, stok, kategori FROM produk LIMIT 10");
if (mysqli_num_rows($list_produk) > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Kategori</th></tr>";
    while ($row = mysqli_fetch_assoc($list_produk)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nama'] . "</td>";
        echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
        echo "<td>" . $row['stok'] . "</td>";
        echo "<td>" . $row['kategori'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// 9. CHECK ORDERS DATA
echo "<h3>9. Data Orders:</h3>";
$check_orders = mysqli_query($conn, "SELECT COUNT(*) as total FROM orders");
$orders_count = mysqli_fetch_assoc($check_orders);
echo "Total Orders: <span class='success'>" . $orders_count['total'] . " pesanan</span><br>";

echo "<hr>";
echo "<h3 style='color: green;'>✅ Database Initialization Selesai!</h3>";
echo "<p>";
echo "  <a href='admin_login.php'>🔓 Login Admin</a> ";
echo "  <a href='test_admin.php'>🧪 Test System</a> ";
echo "</p>";

mysqli_close($conn);
?>
