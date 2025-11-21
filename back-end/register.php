<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "projectpbw";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

// Cek apakah email sudah terdaftar
$check = $conn->prepare("SELECT * FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
  echo "Email sudah digunakan!";
  exit;
}

// Hash password sebelum simpan
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
$sql->bind_param("ss", $email, $hashedPassword);

if ($sql->execute()) {
  echo "success";
} else {
  echo "Gagal menyimpan data.";
}

$conn->close();
?>
