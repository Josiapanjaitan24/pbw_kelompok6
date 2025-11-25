<?php
session_start();

// Jika user belum login, redirect ke login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../front-end/login.html");
    exit;
}

// Ambil data session
$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Akun Saya</title>
    <style>
        /* ===== Body & Layout ===== */
        body {
            background-color: #1f1f1f;
            color: #f0f0f0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            padding: 30px 0 10px 0;
            font-size: 2em;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #2c2c2c;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.5);
        }

        .info p {
            background-color: #3a3a3a;
            padding: 12px 15px;
            border-radius: 8px;
            margin: 10px 0;
            font-size: 1em;
        }

        /* ===== Tombol Logout ===== */
        .logout-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background: linear-gradient(135deg, #ff4b5c, #ff6f61);
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #ff1f3c, #ff3f33);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.4);
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Profil Akun</h2>
    <div class="info">
        <p><strong>Nama Pengguna:</strong> <?= $username ?></p>
        <p><strong>Email:</strong> <?= $email ?></p>
    </div>

    <a href="../back-end/logout.php" class="logout-btn">Log Out</a>
</div>

</body>
</html>