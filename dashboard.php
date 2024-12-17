<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

include 'includes/header.php';
?>

<div class="container">
    <h2>Selamat Datang, <?= $_SESSION['user']; ?></h2>
    <p>Silakan pilih menu untuk melanjutkan.</p>
    <link rel="stylesheet" href="css/style.css">
</div>

<?php include 'includes/footer.php'; ?>
