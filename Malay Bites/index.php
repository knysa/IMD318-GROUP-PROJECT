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

$login_error = ""; // Initialize the error message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE BINARY username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: home.php");
            exit;
        } else {
            $login_error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="css/styles-frontpage.css">
</head>
<body>
    <div class="login-container">
        <div class="login-image">
            <img src="image/logo2.png" alt="Login Image">
        </div>
        <div class="login-form">
            <div class="title-form">
                <h1>Sign In</h1>
                <p>Welcome To Our Shop! Please Enjoy Our Food Service :)</p>
            </div>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" class="form-input" required>
                <input type="password" name="password" placeholder="Password" class="form-input" required>
                <button type="submit" name="login" class="btn-login">Sign In</button>
            </form>
            <div class="error-message">
                <?php if (!empty($login_error)) : ?>
                    <p style="color: red;"><?= htmlspecialchars($login_error) ?></p>
                <?php endif; ?>
            </div>
            <div class="form-actions">
                <p>
                    Don't have an account? <a href="register.php">Sign up</a>.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
