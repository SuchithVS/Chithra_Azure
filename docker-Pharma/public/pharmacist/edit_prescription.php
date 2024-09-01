<?php
session_start();
if (!isset($_SESSION['pharmacist_logged_in']) || $_SESSION['pharmacist_logged_in'] !== true) {
    header("Location: ../index.php");
    exit;
}
include('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
    $medicine_id = $_POST['medicine_id'];
    $quantity = $_POST['quantity'];
    $prescription_date = $_POST['prescription_date'];

    $update_query = "UPDATE prescriptions 
                     SET patient_name='$patient_name', medicine_id='$medicine_id', quantity='$quantity', prescription_date='$prescription_date' 
                     WHERE id='$id'";
    
    if (mysqli_query($conn, $update_query)) {
        header("Location: manage_prescriptions.php");
        exit;
    } else {
        $error = "Error updating prescription: " . mysqli_error($conn);
    }
}

// Fetch the existing prescription data
$id = $_GET['id'];
$query = "SELECT * FROM prescriptions WHERE id='$id'";
$result = mysqli_query($conn, $query);
$prescription = mysqli_fetch_assoc($result);

// Fetch all medicines for the edit form
$medicines_query = "SELECT id, name FROM medicines";
$medicines_result = mysqli_query($conn, $medicines_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Prescription</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Edit Prescription</h1>
        <form method="POST" action="edit_prescription.php">
            <input type="hidden" name="id" value="<?php echo $prescription['id']; ?>">
            <div class="form-group">
                <label for="patient_name">Patient Name:</label>
                <input type="text" name="patient_name" id="patient_name" value="<?php echo $prescription['patient_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="medicine_id">Medicine:</label>
                <select name="medicine_id" id="medicine_id" required>
                    <?php while($medicine = mysqli_fetch_assoc($medicines_result)) { ?>
                    <option value="<?php echo $medicine['id']; ?>" <?php if ($medicine['id'] == $prescription['medicine_id']) echo 'selected'; ?>><?php echo $medicine['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" value="<?php echo $prescription['quantity']; ?>" required>
            </div>
            <div class="form-group">
                <label for="prescription_date">Prescription Date:</label>
                <input type="date" name="prescription_date" id="prescription_date" value="<?php echo $prescription['prescription_date']; ?>" required>
            </div>
            <button type="submit">Update Prescription</button>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        </form>

        <a href="manage_prescriptions.php" class="back-button">Back to Manage Prescriptions</a>
    </div>
</body>
</html>
