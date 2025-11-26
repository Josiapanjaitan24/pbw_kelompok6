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

// Buat nama_lengkap default dari email
$nama_lengkap = explode("@", $email)[0];

// Cek apakah email sudah terdaftar
$check = $conn->prepare("SELECT * FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "Email sudah digunakan!";
    exit;
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Simpan ke database (sesuai kolom yang ada)
$sql = $conn->prepare(
    "INSERT INTO users (nama_lengkap, email, password) VALUES (?, ?, ?)"
);
$sql->bind_param("sss", $nama_lengkap, $email, $hashedPassword);

if ($sql->execute()) {
    echo "success";
} else {
    echo "Gagal menyimpan data.";
}

$conn->close();
?>