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
        background: linear-gradient(135deg, #1b1b1b, #292929);
        color: #f5f5f5;
        font-family: "Poppins", Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px;
        background: rgba(45, 45, 45, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.08);
        box-shadow: 0 10px 35px rgba(0,0,0,0.6);
        animation: fadeIn 0.5s ease;
    }
    @keyframes fadeIn {
        from {opacity:0; transform: translateY(10px);}
        to {opacity:1; transform: translateY(0);}
    }
    h2 {
        text-align: center;
        margin-bottom: 25px;
        font-size: 26px;
        letter-spacing: 1px;
    }
    .profile-img {
        display: block;
        margin: 0 auto 20px;
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid rgba(255,255,255,0.1);
        box-shadow: 0 5px 20px rgba(0,0,0,0.7);
    }
    label {
        display: block;
        margin-top: 18px;
        font-weight: 500;
        font-size: 14px;
        opacity: 0.85;
    }
    input {
        width: 100%;
        padding: 12px;
        margin-top: 6px;
        border-radius: 10px;
        border: 1px solid rgba(255,255,255,0.1);
        background-color: rgba(60, 60, 60, 0.6);
        color: white;
        font-size: 15px;
        transition: 0.2s;
    }
    input:focus {
        outline: none;
        border: 1px solid #6cff7d;
        background-color: rgba(70,70,70,0.8);
    }
    .btn {
        display: inline-block;
        margin-top: 25px;
        padding: 12px 20px;
        text-decoration: none;
        font-weight: bold;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.25s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }
    .save-btn {
        background: linear-gradient(135deg, #28c76f, #35e084);
        color: white;
    }
    .save-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(40,200,111,0.4);
    }
    .cancel-btn {
        background: linear-gradient(135deg, #ff4d4d, #ff6e6e);
        color: white;
        margin-left: 10px;
    }
    .cancel-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(255,77,77,0.4);
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