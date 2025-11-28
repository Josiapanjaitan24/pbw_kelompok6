<?php
session_start();
include "koneksi.php";

// Cek admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: admin_login.php");
    exit;
}

echo "<h2>🔧 Database Repair</h2>";

// 1. Check if there are products with ID 1-10 from database (not default)
$check = mysqli_query($conn, "SELECT COUNT(*) as count FROM produk WHERE id <= 10");
$check_row = mysqli_fetch_assoc($check);

if ($check_row['count'] > 0) {
    echo "<p>Found " . $check_row['count'] . " products with ID 1-10 (conflict with default products)</p>";
    echo "<p>Fixing by renumbering to start from 101...</p>";
    
    // Get all database products ordered by id
    $products = mysqli_query($conn, "SELECT * FROM produk WHERE id <= 10 ORDER BY id ASC");
    $new_id = 101;
    
    while ($prod = mysqli_fetch_assoc($products)) {
        $old_id = $prod['id'];
        $update = mysqli_query($conn, "UPDATE produk SET id = $new_id WHERE id = $old_id");
        if ($update) {
            echo "✓ Updated product ID: $old_id → $new_id (" . $prod['nama'] . ")<br>";
        } else {
            echo "✗ Error updating ID $old_id: " . mysqli_error($conn) . "<br>";
        }
        $new_id++;
    }
    
    // Set AUTO_INCREMENT to next available
    $next_id = $new_id;
    $set_ai = mysqli_query($conn, "ALTER TABLE produk AUTO_INCREMENT = $next_id");
    if ($set_ai) {
        echo "✓ Set AUTO_INCREMENT to $next_id<br>";
    }
    
    echo "<br><p>✅ Repair complete! Now:</p>";
    echo "<ul>";
    echo "<li>Default products: ID 1-10</li>";
    echo "<li>Database products: ID 101+</li>";
    echo "<li>No more conflicts!</li>";
    echo "</ul>";
    
    echo "<p><a href='admin_produk.php' style='background: #4caf50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Admin Produk</a></p>";
    
} else {
    echo "<p>✓ No ID conflicts found!</p>";
    echo "<p><a href='admin_produk.php'>Go to Admin Produk</a></p>";
}

mysqli_close($conn);
?>
