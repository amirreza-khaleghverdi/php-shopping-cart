<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Cart</title>
    <link rel="stylesheet" href="templates/cartpage.css">
</head>
<body>

    <header>
        <div class="logo">
            <h1>My Shop</h1>
        </div>
        <nav>
            <a href="index.php?action=homepage">Home</a>
            <a href="index.php?action=logout">Logout</a>
        </nav>
    </header>

    <main>
        <div class="cart-container">
            <h2>Your Shopping Cart

                <?php if (!empty($_SESSION['errors'])): ?>
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <p class="errors"><?= htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    <?php unset($_SESSION['errors']);?>
                <?php endif; ?>
                
            </h2>

            


            <?php if (!empty($cart_items)): ?>
                <form action="index.php?action=update_cart" method="post">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price ($)</th>
                                <th>Quantity</th>
                                <th>Subtotal ($)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total=0;
                            foreach ($cart_items as $item): ?>
                                <tr>
                                    <td class="product-name"><?= htmlspecialchars($item['name']); ?></td>
                                    <td><?= number_format($item['price'], 2); ?></td>
                                    <td>
                                        <input type="number" class="qty-input" name="quantities[<?= $item['id']; ?>]" value="<?= $item['quantity']; ?>" min="1">
                                    </td>
                                    <td><?= number_format($item['price'] * $item['quantity'], 2); ?></td>
                                    <td>
                                        <a href="index.php?action=remove_item&cart_item_id=<?= $item['id']; ?>" class="remove-btn">Remove</a>
                                    </td>
                                </tr>
                                <?php $total+=$item['total'];
                            endforeach; ?>
                        </tbody>
                    </table>
                    <div class="total">
                        <strong>Total: $<?= number_format($total, 2); ?></strong>
                    </div>
                    <button type="submit">Update Cart</button>
                </form>
                <a href="index.php?action=showCheckout" class="checkout-btn">Proceed to Checkout</a>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; <?= date('Y'); ?> Some rights reserved (almost none tbh).</p>
    </footer>

</body>
</html>