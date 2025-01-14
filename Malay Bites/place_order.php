<?php
session_start();
header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Get the JSON data from the request body
$input = json_decode(file_get_contents('php://input'), true);
$items = $input['items'] ?? [];

// Check if the cart is empty
if (empty($items)) {
    echo json_encode(['error' => 'Your cart is empty!']);
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

    // Calculate the total price
    $totalPrice = 0;
    foreach ($items as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }

    // Insert the order into the 'orders' table
    $stmt = $pdo->prepare("INSERT INTO orders (total_price, user_id) VALUES (:total_price, :user_id)");
    $stmt->bindParam(':total_price', $totalPrice);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    // Get the last inserted order ID
    $order_id = $pdo->lastInsertId();

    // Insert each item into the 'order_items' table
    $itemStmt = $pdo->prepare("INSERT INTO order_items (order_id, item_name, item_price, quantity, user_id) VALUES (:order_id, :item_name, :item_price, :quantity, :user_id)");
    foreach ($items as $item) {
        $quantity = isset($item['quantity']) && $item['quantity'] > 0 ? $item['quantity'] : 1;

        $itemStmt->bindParam(':order_id', $order_id);
        $itemStmt->bindParam(':item_name', $item['name']);
        $itemStmt->bindParam(':item_price', $item['price']);
        $itemStmt->bindParam(':quantity', $quantity);
        $itemStmt->bindParam(':user_id', $user_id);
        $itemStmt->execute();
    }

    // Redirect to the invoice page
    echo json_encode(['success' => 'Order placed successfully!', 'redirect_url' => "invoice.php?order_id=$order_id"]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}


?>

