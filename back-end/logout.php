<?php
session_start();       // buka session
session_destroy();     // hapus semua session (logout)

header("Location: ../front-end/login.html"); 
exit();
?>