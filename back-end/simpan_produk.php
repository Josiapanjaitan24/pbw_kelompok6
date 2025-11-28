<?php
session_start();
include "koneksi.php";

// Cek admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: admin_login.php");
    exit;
}

// Ambil data
$nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
$harga = isset($_POST['harga']) ? (int)$_POST['harga'] : 0;
$stok = isset($_POST['stok']) ? (int)$_POST['stok'] : 0;
$kategori = isset($_POST['kategori']) ? trim($_POST['kategori']) : '';
$deskripsi = isset($_POST['deskripsi']) ? trim($_POST['deskripsi']) : '';
$bahan = isset($_POST['bahan']) ? trim($_POST['bahan']) : '';
$ukuran = isset($_POST['ukuran']) ? trim($_POST['ukuran']) : '';
$warna = isset($_POST['warna']) ? trim($_POST['warna']) : '';
$perawatan = isset($_POST['perawatan']) ? trim($_POST['perawatan']) : '';

// Validasi input
if (empty($nama) || $harga <= 0 || empty($kategori)) {
    die("Error: Nama, harga (>0), dan kategori tidak boleh kosong!");
}

// Buat JSON spesifikasi
$spesifikasi = json_encode([
    'bahan' => $bahan,
    'ukuran' => $ukuran,
    'warna' => $warna,
    'perawatan' => $perawatan
]);

// -------------------------
// Upload Gambar
// -------------------------
$folder = "../uploads/produk/";
if (!is_dir($folder)) {
    if (!mkdir($folder, 0777, true)) {
        die("Error: Gagal membuat folder uploads. Pastikan folder uploads sudah ada atau memiliki permission yang tepat!");
    }
}

$foto = '';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $file_ext = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
    
    if (in_array($file_ext, $allowed_ext)) {
        $foto = time() . "_" . basename($_FILES["foto"]["name"]);
        $target = $folder . $foto;
        if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target)) {
            die("Error: Gagal mengupload gambar!");
        }
    } else {
        die("Error: Format gambar tidak didukung (JPG, PNG, GIF)!");
    }
} else {
    die("Error: Gambar produk wajib diupload!");
}

// -------------------------
// Simpan ke database
// -------------------------
// Coba insert dengan spesifikasi terlebih dahulu
$stmt = $conn->prepare("INSERT INTO produk (nama, harga, stok, kategori, deskripsi, foto, spesifikasi) VALUES (?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    // Jika gagal (kolom spesifikasi tidak ada), insert tanpa spesifikasi
    $stmt = $conn->prepare("INSERT INTO produk (nama, harga, stok, kategori, deskripsi, foto) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiiss", $nama, $harga, $stok, $kategori, $deskripsi, $foto);
} else {
    $stmt->bind_param("siissss", $nama, $harga, $stok, $kategori, $deskripsi, $foto, $spesifikasi);
}

if ($stmt->execute()) {
    echo "<script>alert('Produk berhasil ditambahkan!'); window.location.href='admin_produk.php';</script>";
} else {
    echo "Gagal: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>