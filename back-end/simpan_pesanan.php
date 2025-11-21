<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "projectpbw";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari POST
$nama = $_POST['nama_lengkap'];
$alamat = $_POST['alamat_lengkap'];
$telepon = $_POST['nomor_telepon'];
$ukuran = $_POST['ukuran'];
$pembayaran = $_POST['metode_pembayaran'];
$produkData = json_decode($_POST['produk_dipesan'], true); // produk dari localStorage

// Ubah data produk jadi teks agar bisa disimpan di database
$namaProdukList = [];
if (!empty($produkData)) {
  foreach ($produkData as $item) {
    $namaProdukList[] = $item['nama'];
  }
}
$produk_dipesan = implode(", ", $namaProdukList); // contoh: "Kaos Hitam, Hoodie Putih"

// Simpan ke tabel orders
$stmt = $conn->prepare("INSERT INTO orders (nama_lengkap, alamat_lengkap, nomor_telepon, produk_dipesan, ukuran, metode_pembayaran)
                        VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $nama, $alamat, $telepon, $produk_dipesan, $ukuran, $pembayaran);
$stmt->execute();

// ... kode PHP di atas ...

$stmt->close();
$conn->close();

echo "<script>
    alert('Pesanan kamu berhasil disimpan! 🎉');
    // Ganti jalur ini menjadi yang benar:
    window.location.href = '../front-end/home.html'; 
</script>";
?>
