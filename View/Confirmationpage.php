<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="templates/cartpage.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>My Shop</h1>
        </div>
        <nav>
            <a href="index.php?action=homepage">Home</a>
            <a href="index.php?action=dashboard">Dashboard</a>
            <a href="index.php?action=logout">Logout</a>
        </nav>
    </header>

    <main>
        <div class="cart-container">
            <h2>Confirm Your Order</h2>

            <?php if (!empty($order) && !empty($order_items)): ?>
                <p>Order ID: <strong>#<?= htmlspecialchars($order['id']); ?></strong></p>
                <p>Status: <strong><?= htmlspecialchars($order['status']); ?></strong></p>

                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price ($)</th>
                            <th>Quantity</th>
                            <th>Subtotal ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']); ?></td>
                                <td><?= number_format($item['price'], 2); ?></td>
                                <td><?= htmlspecialchars($item['quantity']); ?></td>
                                <td><?= number_format($item['price'] * $item['quantity'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="total">
                    <strong>Total: $<?= number_format($order['total'], 2); ?></strong>
                </div>

                <form action="index.php?action=confirm_order" method="post">
                    <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                    <button type="submit" class="checkout-btn">Confirm Order</button>
                </form>

                <form action="index.php?action=cancel_order" method="post">
                    <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                    <button type="submit" class="checkout-btn">Cancel</button>
                </form>
            <?php else: ?>
                <p>No order found.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; <?= date('Y'); ?> Some rights reserved (almost none tbh).</p>
    </footer>
</body>
</html>
