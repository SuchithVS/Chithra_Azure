<?php
session_start();
if (!isset($_SESSION['pharmacist_logged_in']) || $_SESSION['pharmacist_logged_in'] !== true) {
    header("Location: ../index.php");
    exit;
}
include('../db_connection.php');

// Fetch all prescriptions
$query = "SELECT prescriptions.id, prescriptions.patient_name, prescriptions.quantity, prescriptions.prescription_date, medicines.name AS medicine_name 
          FROM prescriptions 
          INNER JOIN medicines ON prescriptions.medicine_id = medicines.id";
$result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add new prescription
    $patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
    $medicine_id = $_POST['medicine_id'];
    $quantity = $_POST['quantity'];
    $prescription_date = $_POST['prescription_date'];

    $add_query = "INSERT INTO prescriptions (patient_name, medicine_id, quantity, prescription_date) 
                  VALUES ('$patient_name', '$medicine_id', '$quantity', '$prescription_date')";
    
    if (mysqli_query($conn, $add_query)) {
        header("Location: manage_prescriptions.php");
        exit;
    } else {
        $error = "Error adding prescription: " . mysqli_error($conn);
    }
}

// Fetch all medicines for the add prescription form
$medicines_query = "SELECT id, name FROM medicines";
$medicines_result = mysqli_query($conn, $medicines_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Prescriptions</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Manage Prescriptions</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Medicine</th>
                    <th>Quantity</th>
                    <th>Prescription Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['patient_name']; ?></td>
                    <td><?php echo $row['medicine_name']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['prescription_date']; ?></td>
                    <td>
                        <a href="edit_prescription.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                        <a href="delete_prescription.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this prescription?');">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <h2>Add New Prescription</h2>
        <form method="POST" action="manage_prescriptions.php">
            <div class="form-group">
                <label for="patient_name">Patient Name:</label>
                <input type="text" name="patient_name" id="patient_name" required>
            </div>
            <div class="form-group">
                <label for="medicine_id">Medicine:</label>
                <select name="medicine_id" id="medicine_id" required>
                    <?php while($medicine = mysqli_fetch_assoc($medicines_result)) { ?>
                    <option value="<?php echo $medicine['id']; ?>"><?php echo $medicine['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" required>
            </div>
            <div class="form-group">
                <label for="prescription_date">Prescription Date:</label>
                <input type="date" name="prescription_date" id="prescription_date" required>
            </div>
            <button type="submit">Add Prescription</button>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        </form>

        <a href="../auth/logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>
