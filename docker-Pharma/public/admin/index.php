<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Admin Dashboard</h1>
        <div class="card-container">
            <a href="dashboard.php" class="card">
                <div class="card-content">
                    <h2>Dashboard</h2>
                    <p>View Reports and Analytics</p>
                </div>
            </a>
            <a href="manage_inventory.php" class="card">
                <div class="card-content">
                    <h2>Manage Inventory</h2>
                    <p>Add, Update, or Delete Medicines</p>
                </div>
            </a>
            <a href="sales_report.php" class="card">
                <div class="card-content">
                    <h2>Sales Report</h2>
                    <p>View Daily, Weekly, and Monthly Sales</p>
                </div>
            </a>
        </div>
        <a href="../auth/logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>
