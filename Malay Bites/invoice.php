<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Check if order ID is provided
$order_id = $_GET['order_id'] ?? null;
if (!$order_id) {
    echo "Order ID is missing.";
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

    // Fetch order details
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :order_id AND user_id = :user_id");
    $stmt->bindParam(':order_id', $order_id);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo "Order not found.";
        exit;
    }

    // Fetch order items
    $itemStmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
    $itemStmt->bindParam(':order_id', $order_id);
    $itemStmt->execute();
    $items = $itemStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="invoice.css">
    <style>
        /* CSS for the invoice */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .invoice-container {
            width: 80%;
            margin: 30px auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        header h1 {
            margin: 0;
            color: #333;
        }
        .business-details, .customer-details {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        .business-details div, .customer-details div {
            width: 48%;
        }
        h2 {
            color: #444;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tfoot {
            font-weight: bold;
        }
        .payment-form {
            margin-top: 30px;
            padding: 20px;
            background: #f7f7f7;
            border-radius: 8px;
        }
        .payment-form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        .payment-form input, .payment-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .payment-form button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .payment-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <header>
            <h1>Invoice</h1>
            <p>Order #<?= htmlspecialchars($order_id) ?></p>
        </header>

        <!-- Business Details -->
        <div class="business-details">
            <div>
                <h2>Business Details</h2>
                <p>Business Name: Malay Bites</p>
                <p>Address: 12345 Business Street</p>
                <p>Email: BitesMalaycorporation@gmail.com</p>
                <p>Phone: +6012 345 6789</p>
            </div>
            <div>
                <h2>Invoice Details</h2>
                <p>Invoice Date: <?= date('d-m-Y') ?></p>
                <p>Payment : Pending</p>
            </div>
        </div>

        <!-- Order Details -->
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
                    <td><?= htmlspecialchars($item['item_name']) ?></td>
                    <td>RM<?= number_format($item['item_price'], 2) ?></td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td>RM<?= number_format($item['item_price'] * $item['quantity'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="text-align:right;">Total:</th>
                    <th>RM<?= number_format($order['total_price'], 2) ?></th>
                </tr>
            </tfoot>
        </table>

        <!-- Payment Form -->
        <h2>Payment</h2>
        <div class="payment-form">
            <form action="process_payment.php" method="POST">
                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id) ?>">
        
                <label for="name">Your Name</label>
                <input type="text" name="name" id="name" placeholder="Enter your full name" required>
        
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" placeholder="Enter your phone number" required>

                <label for="address">Address</label>
                <input type="text" name="address" id="address" placeholder="Enter your address" required>
        
                <label for="account_number">Account Number</label>
                <input type="text" name="account_number" id="account_number" placeholder="Enter your account number" required>
        
                <label for="reference">Payment Reference</label>
                <input type="text" name="reference" id="reference" placeholder="Enter a reference (e.g., Invoice #123)" required>
        
                <label for="bank">Select Bank</label>
                <select name="bank" id="bank" required>
                    <option value="">Choose Bank</option>
                    <option value="Bank Islam">Bank Islam</option>
                    <option value="Maybank">Maybank</option>
                    <option value="CIMB Bank">CIMB Bank</option>
                    <option value="Affin Bank">Affin Bank</option>
                    <option value="RHB Bank">RHB Bank</option>
                </select>
        
                <button type="submit">Pay Now</button>
            </form>
        </div>

    <!-- JavaScript for payment handling -->
    <script>
        document.querySelector('form').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('process_payment.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
    if (data.success) {
        // Clear the cart from localStorage
        localStorage.removeItem('cart');

        // Redirect the user to the receipt page with the order ID
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'receipt.php';

        // Pass order_id and other required details
        form.innerHTML = `
            <input type="hidden" name="order_id" value="${<?= json_encode($order_id) ?>}">
            <input type="hidden" name="total_price" value="${<?= json_encode($order['total_price']) ?>}">
        `;

        document.body.appendChild(form);
        form.submit();
    } else {
        alert("Payment failed. Please try again.");
    }
})

                .catch(error => {
                    console.error('Error:', error);
                    alert('There was an error processing your payment. Please try again.');
                });
        });
    </script>
</body>
</html>
