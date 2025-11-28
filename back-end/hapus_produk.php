<?php
session_start();
include "koneksi.php";

// Cek admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: admin_login.php");
    exit;
}

// Cek apakah ada ID produk
if (!isset($_GET['id'])) {
    header("Location: admin_produk.php");
    exit;
}

$produk_id = intval($_GET['id']);

// Ambil data produk untuk mendapat nama foto
$stmt = $conn->prepare("SELECT foto FROM produk WHERE id = ?");
$stmt->bind_param("i", $produk_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: admin_produk.php?error=Produk tidak ditemukan");
    exit;
}

$produk = $result->fetch_assoc();
$foto = $produk['foto'];

// Hapus file foto jika ada
if (!empty($foto)) {
    $foto_path = "../uploads/produk/" . $foto;
    if (file_exists($foto_path)) {
        unlink($foto_path);
    }
}

// Hapus dari database
$delete_stmt = $conn->prepare("DELETE FROM produk WHERE id = ?");
$delete_stmt->bind_param("i", $produk_id);

if ($delete_stmt->execute()) {
    // Redirect dengan pesan sukses
    header("Location: admin_produk.php?success=Produk berhasil dihapus!");
    exit;
} else {
    header("Location: admin_produk.php?error=Gagal menghapus produk");
    exit;
}

$stmt->close();
$delete_stmt->close();
$conn->close();
?>
