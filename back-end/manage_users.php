<?php
include "koneksi.php";

echo "<h2>Daftar User</h2>";

// Tampilkan semua users
$result = mysqli_query($conn, "SELECT id, nama_lengkap, email, foto, is_admin FROM users");

if ($result && mysqli_num_rows($result) > 0) {
    echo "<table border='1' style='border-collapse: collapse; padding: 10px;'>";
    echo "<tr style='background: #333; color: white;'>";
    echo "<th style='padding: 10px;'>ID</th>";
    echo "<th style='padding: 10px;'>Nama Lengkap</th>";
    echo "<th style='padding: 10px;'>Email</th>";
    echo "<th style='padding: 10px;'>Admin Status</th>";
    echo "<th style='padding: 10px;'>Action</th>";
    echo "</tr>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        $is_admin = isset($row['is_admin']) ? $row['is_admin'] : 0;
        echo "<tr>";
        echo "<td style='padding: 10px;'>" . $row['id'] . "</td>";
        echo "<td style='padding: 10px;'>" . $row['nama_lengkap'] . "</td>";
        echo "<td style='padding: 10px;'>" . $row['email'] . "</td>";
        echo "<td style='padding: 10px;'>" . ($is_admin == 1 ? '✓ Admin' : '✗ User') . "</td>";
        echo "<td style='padding: 10px;'>";
        
        if ($is_admin != 1) {
            echo "<a href='?set_admin=" . $row['id'] . "' style='color: blue; text-decoration: underline;'>Set as Admin</a>";
        } else {
            echo "<a href='?remove_admin=" . $row['id'] . "' style='color: red; text-decoration: underline;'>Remove Admin</a>";
        }
        
        echo "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "Tidak ada user ditemukan.<br>";
}

// Proses jika ada request set admin
if (isset($_GET['set_admin'])) {
    $user_id = intval($_GET['set_admin']);
    $update = mysqli_query($conn, "UPDATE users SET is_admin = 1 WHERE id = $user_id");
    
    if ($update) {
        echo "<div style='background: #4caf50; color: white; padding: 10px; margin-top: 20px;'>";
        echo "✓ User ID $user_id berhasil dijadikan Admin!";
        echo "<br><a href='manage_users.php'>Refresh halaman</a>";
        echo "</div>";
    } else {
        echo "<div style='background: #f44336; color: white; padding: 10px; margin-top: 20px;'>";
        echo "✗ Gagal update user";
        echo "</div>";
    }
}

if (isset($_GET['remove_admin'])) {
    $user_id = intval($_GET['remove_admin']);
    $update = mysqli_query($conn, "UPDATE users SET is_admin = 0 WHERE id = $user_id");
    
    if ($update) {
        echo "<div style='background: #ff9800; color: white; padding: 10px; margin-top: 20px;'>";
        echo "✓ Admin status dihapus dari User ID $user_id!";
        echo "<br><a href='manage_users.php'>Refresh halaman</a>";
        echo "</div>";
    } else {
        echo "<div style='background: #f44336; color: white; padding: 10px; margin-top: 20px;'>";
        echo "✗ Gagal update user";
        echo "</div>";
    }
}

mysqli_close($conn);
?>
