<?php
session_start();
include "../back-end/koneksi.php";

// Jika user belum login, redirect ke login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../front-end/login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data user dari database
$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($query);

// Jika data kosong (misalnya username / foto)
$username = $user['nama_lengkap'] ?? "(Belum diisi)";
$email    = $user['email'];
$foto     = $user['foto'] ?? "default.png"; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Akun Saya</title>
    <style>
    body {
        background: linear-gradient(135deg, #1a1a1a, #242424);
        color: #f5f5f5;
        font-family: "Poppins", Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    h2 {
        text-align: center;
        padding: 25px 0 10px 0;
        font-size: 1.8em;
        letter-spacing: 1px;
    }

    .container {
        max-width: 420px;    /* ➜ lebih kecil */
        margin: 40px auto;
        padding: 20px 25px;  /* ➜ lebih ramping */
        background: rgba(50, 50, 50, 0.55);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        border: 1px solid rgba(255,255,255,0.08);
        box-shadow: 0 8px 25px rgba(0,0,0,0.5);
        animation: fadeIn 0.5s ease;
        text-align: center;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(10px);}
        to {opacity: 1; transform: translateY(0);}
    }

    .profile-img {
        width: 110px;   /* ➜ lebih kecil */
        height: 110px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid rgba(255,255,255,0.1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.6);
        margin-bottom: 15px;
    }

    .info p {
    background: rgba(70, 70, 70, 0.45);
    padding: 14px 16px;
    border-radius: 10px;
    margin: 12px 0;
    font-size: 1.05em;
    border-left: 4px solid #4a90e2;   /* highlight elegan */
    display: flex;
    align-items: center;
    gap: 10px;
    letter-spacing: 0.3px;
    }

    .info p strong {
    color: #78aaff;    /* warna judul biar standout */
    font-weight: 600;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px; /* ➜ lebih kecil */
        color: white;
        text-decoration: none;
        font-weight: 600;
        border-radius: 8px;
        margin-top: 18px;
        transition: 0.25s;
        font-size: 0.95em;
    }

    .edit-btn {
        background: linear-gradient(135deg, #4a90e2, #6eb2ff);
    }
    .edit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(110,178,255,0.4);
    }

    .logout-btn {
        background: linear-gradient(135deg, #ff4b5c, #ff6d7d);
        margin-left: 8px;
    }
    .logout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255,77,92,0.4);
    }
</style>
</head>
<body>

<div class="container">
    <h2>Profil Akun</h2>

    <img src="../uploads/<?= $foto ?>" class="profile-img">

    <div class="info">
        <p><strong>Nama Pengguna:</strong> <?= $username ?></p>
        <p><strong>Email:</strong> <?= $email ?></p>
    </div>

    <a href="edit_akun.php" class="btn edit-btn">Edit Profil</a>
    <a href="../back-end/logout.php" class="btn logout-btn">Log Out</a>
</div>

</body>
</html>