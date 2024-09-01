<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: auth/login.php");
    exit;
}
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $query = "UPDATE medicines SET name='$name', description='$description', price='$price', quantity='$quantity' WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: admin/manage_inventory.php");
        exit;
    } else {
        $error = "Error updating medicine!";
    }
}

// Fetch medicine data
$id = $_GET['id'];
$query = "SELECT * FROM medicines WHERE id='$id'";
$result = mysqli_query($conn, $query);
$medicine = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Medicine</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Update Medicine</h1>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $medicine['id']; ?>">
            <div class="form-group">
                <input type="text" name="name" value="<?php echo $medicine['name']; ?>" placeholder="Medicine Name" required>
            </div>
            <div class="form-group">
                <textarea name="description" placeholder="Description" required><?php echo $medicine['description']; ?></textarea>
            </div>
            <div class="form-group">
                <input type="number" name="price" value="<?php echo $medicine['price']; ?>" placeholder="Price" required>
            </div>
            <div class="form-group">
                <input type="number" name="quantity" value="<?php echo $medicine['quantity']; ?>" placeholder="Quantity" required>
            </div>
            <button type="submit">Update Medicine</button>
            <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        </form>
        <a href="admin/manage_inventory.php" class="back-button">Back to Inventory</a>
    </div>
</body>
</html>
