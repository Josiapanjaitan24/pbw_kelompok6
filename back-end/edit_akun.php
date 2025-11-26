<?php
session_start();
include "../back-end/koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../front-end/login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($query);

$nama = $user['nama_lengkap'];
$email = $user['email'];
$foto = $user['foto'] ?? "default.png";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
    <style>
        body {
            background-color: #1f1f1f;
            color: #f0f0f0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #2c2c2c;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.5);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-img {
            display: block;
            margin: 0 auto 20px;
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #444;
        }
        label {
            display: block;
            margin-top: 15px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border-radius: 8px;
            border: none;
            background-color: #3a3a3a;
            color: white;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
        }
        .save-btn {
            background-color: #4caf50;
            color: white;
        }
        .cancel-btn {
            background-color: #ff4b5c;
            color: white;
            margin-left: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Profil</h2>

    <img src="../uploads/<?= $foto ?>" class="profile-img">

    <form action="update_akun.php" method="POST" enctype="multipart/form-data">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_lengkap" value="<?= $nama ?>" required>

        <label>Email (tidak bisa diubah)</label>
        <input type="text" value="<?= $email ?>" disabled>

        <label>Foto Profil (opsional)</label>
        <input type="file" name="foto">

        <button type="submit" class="btn save-btn">Simpan Perubahan</button>
        <a href="akun.php" class="btn cancel-btn">Batal</a>
    </form>
</div>

</body>
</html>