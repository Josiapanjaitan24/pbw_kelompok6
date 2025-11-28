<?php
session_start();
include "koneksi.php";

// Jika sudah login sebagai admin
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
    header("Location: admin_produk.php");
    exit;
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    if (!empty($email) && !empty($password)) {
        // Query user
        $stmt = $conn->prepare("SELECT id, nama_lengkap, email, password, is_admin FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Cek password
            if (password_verify($password, $user['password'])) {
                // Cek apakah admin
                if ($user['is_admin'] == 1) {
                    // Set session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['is_admin'] = 1;
                    
                    // Redirect ke admin
                    header("Location: admin_produk.php");
                    exit;
                } else {
                    $error = "⚠️ Akun ini bukan admin! Hanya admin yang bisa akses halaman ini.";
                }
            } else {
                $error = "❌ Password salah!";
            }
        } else {
            $error = "❌ Email tidak ditemukan!";
        }
        
        $stmt->close();
    } else {
        $error = "❌ Email dan password harus diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ClozUp</title>
    <link rel="stylesheet" href="../src/css/style.css">
    <style>
        body {
            background: linear-gradient(180deg, #0f0f0f, #1a1a1a);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Poppins', Arial, sans-serif;
            color: #f5f5f5;
        }

        .login-container {
            background: rgba(30, 30, 30, 0.95);
            border-radius: 12px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
            border: 1px solid #444;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #ffcc00;
            font-size: 28px;
            margin: 0 0 10px 0;
        }

        .login-header p {
            color: #999;
            font-size: 14px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #ffcc00;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            background: #2c2c2c;
            border: 1px solid #444;
            border-radius: 6px;
            color: #f5f5f5;
            font-size: 14px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #ffcc00;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.3);
        }

        .error-message {
            background: #ff5252;
            color: white;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }

        .success-message {
            background: #4caf50;
            color: white;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #ffcc00, #ffd633);
            color: #1a1a1a;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 204, 0, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
        }

        .login-footer a {
            color: #ffcc00;
            text-decoration: none;
            font-size: 14px;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .info-box {
            background: rgba(102, 126, 234, 0.1);
            border-left: 4px solid #667eea;
            padding: 12px;
            border-radius: 6px;
            margin-top: 20px;
            font-size: 12px;
            color: #999;
            line-height: 1.6;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }

            .login-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-header">
        <h1>🔐 Admin Portal</h1>
        <p>ClozUp Admin - Kelola Produk</p>
    </div>

    <?php if (isset($error)): ?>
    <div class="error-message"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="email">Email Admin</label>
            <input type="email" id="email" name="email" placeholder="Masukkan email admin" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>
        </div>

        <button type="submit" class="btn-login">Login sebagai Admin</button>
    </form>

    <div class="info-box">
        <strong>ℹ️ Info:</strong><br>
        Gunakan akun yang sudah diatur sebagai admin. 
        <a href="manage_users.php" style="color: #ffcc00;">Cek user admin</a>
    </div>

    <div class="login-footer">
        <a href="../front-end/home.html">← Kembali ke Home</a>
    </div>
</div>

</body>
</html>
