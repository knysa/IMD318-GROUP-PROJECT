<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = 'localhost';
$dbname = 'customer';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$login_error = ""; // Initialize the error message variable

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$delete_error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];

    // Verify password
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        try {
            $conn->beginTransaction(); // Start transaction
        
            // Step 1: Delete payments associated with the user's orders
            $stmt = $conn->prepare("DELETE FROM payments WHERE order_id IN (SELECT id FROM orders WHERE user_id = :user_id)");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
        
            // Step 2: Delete order items associated with the user's orders
            $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id IN (SELECT id FROM orders WHERE user_id = :user_id)");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
        
            // Step 3: Delete orders associated with the user
            $stmt = $conn->prepare("DELETE FROM orders WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
        
            // Step 4: Delete the user
            $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
        
            $conn->commit(); // Commit the transaction
        
            // Logout user
            session_destroy();
            header("Location: index.php?message=Account deleted successfully.");
            exit;
        } catch (Exception $e) {
            $conn->rollBack(); // Rollback the transaction on error
            $delete_error = "Error: " . $e->getMessage();
        }
    } else {
        $delete_error = "Incorrect password.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="login-container">
        <!-- Left Side: Image -->
        <div class="login-image">
            <img src="image/logo2.png" alt="Delete Account Image">
        </div>

        <!-- Right Side: Form -->
        <div class="login-form">
            <div class="title-form">
                <h1>Delete Account</h1>
                <p>This action is irreversible. Please confirm your decision carefully.</p>
            </div>

            <?php if (isset($delete_error)): ?>
                <p class="error"><?= $delete_error ?></p>
            <?php endif; ?>

            <form method="POST">
                <input type="password" name="password" placeholder="Enter your password" class="form-input" required>
                <button type="submit" class="btn-login">Delete Account</button>
            </form>
            <div class="error-message">
                <?php if (!empty($login_error)) : ?>
                    <p style="color: red;"><?= htmlspecialchars($login_error) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <p>
                    Changed your mind? <a href="home.php">Go Back</a>.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
