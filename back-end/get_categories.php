<?php
header('Content-Type: application/json');
include "koneksi.php";

// Ambil semua kategori
$kategori = mysqli_query($conn, "SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC");
$result = [];

while ($row = mysqli_fetch_assoc($kategori)) {
    $result[] = $row;
}

echo json_encode($result);
mysqli_close($conn);
?>
