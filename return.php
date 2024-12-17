<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['submit_return'])) {
    $rental_id = $_POST['rental_id'];
    $return_date = $_POST['return_date'];
    $late_days = $_POST['late_days'];
    $damage_fee = $_POST['damage_fee'];
    $total_fee = $late_days * 100000 + $damage_fee;

    // Insert into returns table
    $insert_return = "INSERT INTO returns (rental_id, return_date, late_days, damage_fee, total_fee) 
                      VALUES ($rental_id, '$return_date', $late_days, $damage_fee, $total_fee)";
    mysqli_query($conn, $insert_return);

    echo "<script>alert('Pengembalian berhasil diproses!'); window.location='dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pengembalian Mobil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container">
<h2>Proses Pengembalian Mobil</h2>
<form method="POST">
    <label>Pilih Peminjaman:</label>
    <select name="rental_id" required>
        <option value="">-- Pilih Peminjaman --</option>
        <?php
        // Mengambil data peminjaman dari database
        $rentals = mysqli_query($conn, "SELECT rentals.id, customers.name, cars.model 
                                        FROM rentals 
                                        JOIN customers ON rentals.customer_id = customers.id 
                                        JOIN cars ON rentals.car_id = cars.id");
        while ($rental = mysqli_fetch_assoc($rentals)) {
            $customerName = htmlspecialchars($rental['name']);
            $carModel = htmlspecialchars($rental['model']);
            echo "<option value='{$rental['id']}'>Peminjaman: {$customerName} - {$carModel}</option>";
        }

        // Menambahkan data peminjaman secara manual
        $manualRentals = [
            ['id' => '999', 'name' => 'Keyze', 'model' => 'Toyota Alpahrd'],
            ['id' => '1000', 'name' => 'Chanyeol', 'model' => 'Honda Brio']
        ];

        foreach ($manualRentals as $manualRental) {
            $customerName = htmlspecialchars($manualRental['name']);
            $carModel = htmlspecialchars($manualRental['model']);
            echo "<option value='{$manualRental['id']}'>Peminjaman: {$customerName} - {$carModel}</option>";
        }
        ?>
    </select>
    <button type="submit">Proses Pengembalian</button>
</form>

        </select>
        <label>Tanggal Pengembalian:</label>
        <input type="date" name="return_date" required>
        <label>Keterlambatan (hari):</label>
        <input type="number" name="late_days" value="0" required>
        <label>Biaya Kerusakan:</label>
        <input type="number" name="damage_fee" value="0" required>

        <button type="submit" name="submit_return">Proses Pengembalian</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
