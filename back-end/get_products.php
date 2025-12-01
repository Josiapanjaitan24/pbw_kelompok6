<?php
header('Content-Type: application/json');
include "koneksi.php";

// Ambil filter kategori jika ada
$filter_kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';

// Buat query dengan optional filter
$query = "SELECT * FROM produk";
if (!empty($filter_kategori)) {
    $filter_kategori = mysqli_real_escape_string($conn, $filter_kategori);
    $query .= " WHERE kategori = '$filter_kategori'";
}
$query .= " ORDER BY tanggal_upload DESC";

$result = mysqli_query($conn, $query);

$produk = array();

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Parse spesifikasi dari JSON jika ada
        $spesifikasi = null;
        if (isset($row['spesifikasi']) && !empty($row['spesifikasi'])) {
            $spesifikasi = json_decode($row['spesifikasi'], true);
        }
        
        $produk[] = array(
            'id' => (int)$row['id'],
            'nama' => $row['nama'],
            'harga' => (int)$row['harga'],
            'kategori' => $row['kategori'],
            'deskripsi' => $row['deskripsi'],
            'foto' => $row['foto'],
            'stok' => (int)$row['stok'],
            'spesifikasi' => $spesifikasi ? $spesifikasi : [
                'bahan' => '',
                'ukuran' => '',
                'warna' => '',
                'perawatan' => ''
            ]
        );
    }
}

// Return JSON
echo json_encode($produk);

mysqli_close($conn);
?>
