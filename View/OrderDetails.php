<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order #<?= htmlspecialchars($order['id']) ?> Details</title>
    <link rel="stylesheet" href="templates/orderdetails.css">
</head>
<body>
<div class="order-container">
    <h2>Order #<?= htmlspecialchars($order['id']) ?></h2>
    <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
    <p><strong>Date:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
    <p><strong>Total:</strong> $<?= htmlspecialchars($order['total']) ?></p>

    <h3>Items:</h3>
    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($items as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td>$<?= htmlspecialchars($item['price']) ?></td>
            <td><?= htmlspecialchars($item['quantity']) ?></td>
            <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <a href="index.php?action=dashboard" class="back-btn">← Back to Dashboard</a>
</div>
</body>
</html>