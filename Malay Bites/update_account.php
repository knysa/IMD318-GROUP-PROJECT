<?php
session_start();

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

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$update_success = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if username is already taken by another user
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND id != :id");
    $stmt->bindParam(':username', $new_username);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $update_error = "Username already taken.";
    } else {
        // Update username and password
        $stmt = $conn->prepare("UPDATE users SET username = :username, password = :password WHERE id = :id");
        $stmt->bindParam(':username', $new_username);
        $stmt->bindParam(':password', $new_password);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();

        $update_success = "Account updated successfully.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="login-container">
        <!-- Left Side: Image -->
        <div class="login-image">
            <img src="image/logo2.png" alt="Update Account Image">
        </div>

        <!-- Right Side: Form -->
        <div class="login-form">
            <div class="title-form">
                <h1>Update Account</h1>
                <p>Update your details to keep your account up-to-date!</p>
            </div>

            <?php if (isset($update_error)): ?>
                <p class="error"><?= $update_error ?></p>
            <?php endif; ?>
            <?php if (isset($update_success)): ?>
                <p class="success"><?= $update_success ?></p>
            <?php endif; ?>

            <form method="POST">
                <input type="text" name="username" placeholder="New Username" class="form-input" value="<?= htmlspecialchars($_SESSION['username']) ?>" required>
                <input type="password" name="password" placeholder="New Password" class="form-input" required>
                <button type="submit" class="btn-login">Update Account</button>
            </form>

            <div class="form-actions">
                <p>
                    Want to return? <a href="home.php">Go Back</a>.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
