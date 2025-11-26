<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db = "projectpbw";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

    // === FIX: Jika username kosong di DB ===
    if (empty($user['username'])) {
        $user['username'] = explode("@", $user['email'])[0];
    }

    if (password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];

        echo "success";
    } else {
        echo "Email atau password salah!";
    }
} else {
    echo "Email atau password salah!";
}

$stmt->close();
$conn->close();
?>