<?php
session_start();
include "../back-end/koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../front-end/login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$nama = $_POST['nama_lengkap'];

// Ambil data user
$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($query);

$foto_lama = $user['foto'];

// Proses upload foto baru
if (!empty($_FILES['foto']['name'])) {

    $file_name = time() . "_" . $_FILES['foto']['name'];
    $temp = $_FILES['foto']['tmp_name'];

    // Pastikan folder uploads ada
    if (!is_dir("../uploads")) {
        mkdir("../uploads");
    }

    move_uploaded_file($temp, "../uploads/" . $file_name);

    // Update nama dan foto
    $update = mysqli_query($conn, 
        "UPDATE users SET nama_lengkap='$nama', foto='$file_name' WHERE id='$user_id'"
    );

} else {
    // Update hanya nama
    $update = mysqli_query($conn, 
        "UPDATE users SET nama_lengkap='$nama' WHERE id='$user_id'"
    );
}

header("Location: akun.php");
exit;
?>