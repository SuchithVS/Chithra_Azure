<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../auth/login.php");
    exit;
}
include('../db_connection.php');

// Fetch summary data for the dashboard
$sales_query = "
    SELECT 
        COUNT(prescriptions.id) AS total_sales, 
        SUM(prescriptions.quantity) AS total_quantity, 
        SUM(medicines.price * prescriptions.quantity) AS total_revenue 
    FROM prescriptions 
    INNER JOIN medicines ON prescriptions.medicine_id = medicines.id";
$sales_result = mysqli_query($conn, $sales_query);
if ($sales_result) {
    $sales_data = mysqli_fetch_assoc($sales_result);
} else {
    die("Error fetching sales data: " . mysqli_error($conn));
}

$inventory_query = "SELECT COUNT(id) AS total_medicines, SUM(quantity) AS total_stock FROM medicines";
$inventory_result = mysqli_query($conn, $inventory_query);
if ($inventory_result) {
    $inventory_data = mysqli_fetch_assoc($inventory_result);
} else {
    die("Error fetching inventory data: " . mysqli_error($conn));
}

$prescriptions_query = "SELECT COUNT(id) AS total_prescriptions FROM prescriptions";
$prescriptions_result = mysqli_query($conn, $prescriptions_query);
if ($prescriptions_result) {
    $prescriptions_data = mysqli_fetch_assoc($prescriptions_result);
} else {
    die("Error fetching prescriptions data: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Dashboard</h1>
        <div class="dashboard-summary">
            <div class="card">
                <h2>Total Sales</h2>
                <p><?php echo $sales_data['total_sales'] ?? '0'; ?> orders</p>
                <p>Total Quantity: <?php echo $sales_data['total_quantity'] ?? '0'; ?></p>
                <p>Total Revenue: $<?php echo number_format($sales_data['total_revenue'] ?? 0, 2); ?></p>
            </div>
            <div class="card">
                <h2>Inventory Status</h2>
                <p><?php echo $inventory_data['total_medicines'] ?? '0'; ?> types of medicines</p>
                <p>Total Stock: <?php echo $inventory_data['total_stock'] ?? '0'; ?> units</p>
            </div>
            <div class="card">
                <h2>Total Prescriptions</h2>
                <p><?php echo $prescriptions_data['total_prescriptions'] ?? '0'; ?> prescriptions</p>
            </div>
        </div>
        <a href="../auth/logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>
