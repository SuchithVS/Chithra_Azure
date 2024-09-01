<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['admin_logged_in']) && !isset($_SESSION['pharmacist_logged_in'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Select Dashboard</h1>
        <div class="card-container">
            <a href="admin/index.php" class="card">
                <div class="card-content">
                    <h2>Admin Dashboard</h2>
                    <p>Access the admin panel to manage inventory, view sales, and more.</p>
                </div>
            </a>
            <a href="pharmacist/index.php" class="card">
                <div class="card-content">
                    <h2>Pharmacist Dashboard</h2>
                    <p>Access the pharmacist panel to manage prescriptions and more.</p>
                </div>
            </a>
        </div>
        <a href="auth/logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>
