<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['submit_rental'])) {
    $customer_name = $_POST['customer_name'];
    $identity_number = $_POST['identity_number'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $car_id = $_POST['car_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $with_driver = isset($_POST['with_driver']) ? 1 : 0;

    // Fetch car price
    $car_query = mysqli_query($conn, "SELECT rental_price, driver_price FROM cars WHERE id=$car_id");
    $car = mysqli_fetch_assoc($car_query);

    $rental_days = (strtotime($end_date) - strtotime($start_date)) / 86400;
    $total_payment = $rental_days * $car['rental_price'];

    if ($with_driver) {
        $total_payment += $rental_days * $car['driver_price'];
    }

    // Insert customer
    $insert_customer = "INSERT INTO customers (name, identity_number, phone, address) VALUES ('$customer_name', '$identity_number', '$phone', '$address')";
    mysqli_query($conn, $insert_customer);
    $customer_id = mysqli_insert_id($conn);

    // Insert rental
    $insert_rental = "INSERT INTO rentals (customer_id, car_id, start_date, end_date, with_driver, total_payment) 
                      VALUES ($customer_id, $car_id, '$start_date', '$end_date', $with_driver, $total_payment)";
    mysqli_query($conn, $insert_rental);

    echo "<script>alert('Peminjaman berhasil ditambahkan!'); window.location='dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Peminjaman Mobil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container">
    <h2>Proses Peminjaman Mobil</h2>
    <form method="POST">
        <h3>Data Penyewa</h3>
        <input type="text" name="customer_name" placeholder="Nama Penyewa" required>
        <input type="text" name="identity_number" placeholder="No.Telp" required>
        <input type="text" name="phone" placeholder="SIM/KTP" required>
        <input type="text" name="address" placeholder="Alamat" required>

        <h3>Data Peminjaman</h3>
<label>Pilih Mobil:</label>
<select name="car_id" required>
    <option value="">-- Pilih Mobil --</option>
    <?php
    // Menampilkan mobil dari database
    $cars = mysqli_query($conn, "SELECT * FROM cars");
    while ($car = mysqli_fetch_assoc($cars)) {
        echo "<option value='{$car['id']}'>{$car['brand']} - {$car['model']} ({$car['plate_number']})</option>";
    }

    // Menambahkan mobil secara manual
    $manualCars = [
        ['id' => '999', 'brand' => 'Toyota', 'model' => 'Rush', 'plate_number' => 'B 1234 DIA'],
        ['id' => '1000', 'brand' => 'Honda', 'model' => 'Brio', 'plate_number' => 'B 5678 YUU'],
        ['id' => '1001', 'brand' => 'Toyota', 'model' => 'Alphard', 'plate_number' => 'B 9101 WAH'],
        ['id' => '1002', 'brand' => 'Honda', 'model' => 'HR-V', 'plate_number' => 'B 9999 NAD']
    ];

    foreach ($manualCars as $manualCar) {
        echo "<option value='{$manualCar['id']}'>{$manualCar['brand']} - {$manualCar['model']} ({$manualCar['plate_number']})</option>";
    }
    ?>
</select>
       
        <label>Tanggal Mulai:</label>
        <input type="date" name="start_date" required>
        <label>Tanggal Selesai:</label>
        <input type="date" name="end_date" required>
        <label>Gunakan Supir:</label>
        <input type="checkbox" name="with_driver">

        <button type="submit" name="submit_rental">Proses Peminjaman</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
