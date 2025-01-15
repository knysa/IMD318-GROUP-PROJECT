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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE BINARY username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $register_error = "Username or email already taken.";
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (username, email, phone, password) VALUES (:username, :email, :phone, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            header("Location: index.php?message=Account created successfully. You can now log in.");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="login-container">
        <!-- Left Side: Image -->
        <div class="login-image">
            <img src="image/logo2.png" alt="Registration Image">
        </div>

        <!-- Right Side: Form -->
        <div class="login-form">
            <div class="title-form">
                <h1>Create Account</h1>
                <p>Sign up to start your journey with us!</p>
            </div>

            <?php if (isset($register_error)): ?>
                <p class="error"><?= $register_error ?></p>
            <?php endif; ?>

            <form method="POST">
                <input type="text" name="username" placeholder="Username" class="form-input" required>
                <input type="email" name="email" placeholder="Email" class="form-input" required>
                <input type="text" name="phone" placeholder="Phone" class="form-input" required>
                <input type="password" name="password" placeholder="Password" class="form-input" required>
                <button type="submit" name="register" class="btn-login">Register</button>
            </form>

            <div class="form-actions">
                <p>
                    Already have an account? <a href="index.php">Sign In</a>.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
