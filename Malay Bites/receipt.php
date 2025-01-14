<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request.";
    exit;
}

// Retrieve POST data
$order_id = $_POST['order_id'] ?? '';

// Database connection
$host = 'localhost';
$dbname = 'customer';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch order details
    $query = $pdo->prepare("
        SELECT 
            orders.total_price, 
            payments.name, 
            payments.phone, 
            payments.bank 
        FROM orders
        LEFT JOIN users ON orders.user_id = users.id
        LEFT JOIN payments ON payments.order_id = orders.id
        WHERE orders.id = :order_id
    ");
    $query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $query->execute();

    $order = $query->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo "Order not found.";
        exit;
    }

    $total_price = $order['total_price'] ?? 0;
    $name = $order['name'] ?? 'N/A';
    $phone = $order['phone'] ?? 'N/A';
    $bank = $order['bank'] ?? 'N/A';

    // Fetch items in the order if applicable
    $itemsQuery = $pdo->prepare("
        SELECT 
            item_name AS name, 
            item_price AS price, 
            quantity 
        FROM order_items
        WHERE order_id = :order_id
    ");
    $itemsQuery->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $itemsQuery->execute();

    $items = $itemsQuery->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        .receipt-container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        header {
            text-align: center;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
        }
        .print-button {
            margin-top: 20px;
            text-align: center;
        }
        @media print {
        .print-button {
            display: none;
        }
    }

    </style>
</head>
<body>
    <div class="receipt-container">
        <header>
            <h1>Receipt</h1>
            <p>Order #<?= htmlspecialchars($order_id) ?></p>
        </header>
        <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($phone) ?></p>
        <p><strong>Bank:</strong> <?= htmlspecialchars($bank) ?></p>
        <p><strong>Payment:</strong> Successful</p>
        <h2>Order Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>RM<?= number_format($item['price'], 2) ?></td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td>RM<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="text-align:right;">Total:</th>
                    <th>RM<?= number_format($total_price, 2) ?></th>
                </tr>
            </tfoot>
        </table>
        <div class="print-button">
            <button onclick="window.print()">Print Receipt</button>
        </div>
    </div>
</body>
</html>
