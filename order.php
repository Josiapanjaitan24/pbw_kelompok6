<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "projectpbw";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST['nama_lengkap'];
  $alamat = $_POST['alamat_lengkap'];
  $telepon = $_POST['nomor_telepon'];
  $ukuran = $_POST['ukuran'];
  $metode = $_POST['metode_pembayaran'];

  $stmt = $conn->prepare("INSERT INTO orders (nama_lengkap, alamat_lengkap, nomor_telepon, ukuran, metode_pembayaran) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $nama, $alamat, $telepon, $ukuran, $metode);

  if ($stmt->execute()) {
    echo "<script>alert('Pesanan berhasil dikirim!'); window.location.href='home.html';</script>";
  } else {
    echo "<script>alert('Gagal mengirim pesanan!'); window.history.back();</script>";
  }

  $stmt->close();
}

$conn->close();
?>
