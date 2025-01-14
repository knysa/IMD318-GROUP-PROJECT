<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "customer";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch orders for the user
$sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_id DESC";
$result = $conn->query($sql);

$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $order_id = $row['order_id'];
        $total_price = $row['total_price'];

        // Fetch items for this order
        $items_sql = "SELECT item_name AS name, item_price AS price FROM order_items WHERE order_id = $order_id";
        $items_result = $conn->query($items_sql);

        $items = [];
        if ($items_result->num_rows > 0) {
            while ($item_row = $items_result->fetch_assoc()) {
                $items[] = $item_row;
            }
        }

        $orders[] = [
            "order_id" => $order_id,
            "total_price" => $total_price,
            "items" => $items
        ];
    }
}

echo json_encode($orders);

$conn->close();
?>
