<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.',
    ]);
    exit;
}

// Validate the required form data
if (!isset($_POST['order_id'], $_POST['bank'], $_POST['address'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid payment request. Missing order ID, bank details, or address.',
    ]);
    exit;
}

// Get the form data
$order_id = $_POST['order_id'];
$name = $_POST['name'] ?? 'N/A';
$phone = $_POST['phone'] ?? 'N/A';
$address = $_POST['address'] ?? 'N/A'; // New address field
$account_number = $_POST['account_number'] ?? 'N/A';
$reference = $_POST['reference'] ?? 'N/A';
$bank = $_POST['bank'];
$user_id = $_SESSION['user_id'] ?? null; // Assuming the user is logged in and `user_id` is stored in session

if (!$user_id) {
    echo json_encode([
        'success' => false,
        'message' => 'User not logged in.',
    ]);
    exit;
}

// Database connection
$host = 'localhost';
$dbname = 'customer';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the total price for the order
    $orderQuery = $pdo->prepare("SELECT total_price FROM orders WHERE id = :order_id AND user_id = :user_id");
    $orderQuery->bindParam(':order_id', $order_id);
    $orderQuery->bindParam(':user_id', $user_id);
    $orderQuery->execute();

    $order = $orderQuery->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo json_encode([
            'success' => false,
            'message' => 'Order not found or does not belong to the logged-in user.',
        ]);
        exit;
    }

    $total_price = $order['total_price'];

    // Insert payment data into the database
    $stmt = $pdo->prepare("
        INSERT INTO payments (order_id, user_id, name, phone, address, account_number, reference, bank, total_price) 
        VALUES (:order_id, :user_id, :name, :phone, :address, :account_number, :reference, :bank, :total_price)
    ");

    $stmt->bindParam(':order_id', $order_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address); // Bind the address
    $stmt->bindParam(':account_number', $account_number);
    $stmt->bindParam(':reference', $reference);
    $stmt->bindParam(':bank', $bank);
    $stmt->bindParam(':total_price', $total_price);

    $stmt->execute();

    // Respond with success
    echo json_encode([
        'success' => true,
        'message' => "Payment for Order #$order_id via $bank was successful! Thank you for your purchase.",
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error processing payment: ' . $e->getMessage(),
    ]);
    exit;
}
?>
