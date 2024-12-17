<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laporan Penyewaan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container">
    <h2>Laporan Penyewaan Bulanan</h2>
    <table border="1" width="100%" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Penyewa</th>
                <th>Mobil</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Total Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $rentals = mysqli_query($conn, "SELECT customers.name, cars.model, rentals.start_date, rentals.end_date, rentals.total_payment
                                           FROM rentals
                                           JOIN customers ON rentals.customer_id = customers.id
                                           JOIN cars ON rentals.car_id = cars.id");
            while ($rental = mysqli_fetch_assoc($rentals)) {
                echo "<tr>
                        <td>$no</td>
                        <td>{$rental['name']}</td>
                        <td>{$rental['model']}</td>
                        <td>{$rental['start_date']}</td>
                        <td>{$rental['end_date']}</td>
                        <td>Rp. {$rental['total_payment']}</td>
                      </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
