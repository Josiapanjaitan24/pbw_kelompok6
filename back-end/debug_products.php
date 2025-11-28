<?php
header('Content-Type: application/json');
include "koneksi.php";

// Get produk dari database
$query = "SELECT * FROM produk ORDER BY tanggal_upload DESC";
$result = mysqli_query($conn, $query);

$produk = array();

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $produk[] = $row;
    }
}

// Return raw data untuk debug
echo json_encode([
    'status' => 'success',
    'count' => count($produk),
    'data' => $produk
]);

mysqli_close($conn);
?>
