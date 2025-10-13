<!-- templates/homepage.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
    <link rel="stylesheet" href="templates/homepage.css">
</head>
<body>
    <div id="main">
        <div class="homepage-container">
            <header>
                <div class="logo">
                    <h1>My Shop</h1>
                </div>

                <nav>
                    <a href="index.php?action=cart">🛒 Cart</a>
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href="index.php?action=dashboard">Dashboard</a>
                        <a href="index.php?action=logout">Logout</a>
                    <?php else: ?>
                        <a href="index.php?action=login">Login</a>
                        <a href="index.php?action=register">Register</a>
                    <?php endif; ?>
                </nav>
            </header>

            <main>
                <h2>Our Latest Products
                    <?php if (!empty($_SESSION['error'])): ?>
                        <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                    <?php elseif (!empty($_SESSION['message'])): ?>
                        <p class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
                    <?php endif; ?>
                </h2>
                <div class="product-list">
                    <?php if (!empty($products)):   
                        foreach ($products as $product): ?>
                            <div class="product-item">
                                
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                     class="product-image">

                                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p><strong>$<?php echo number_format($product['price'], 2); ?></strong></p>
                                <?php if ($product['stock']==0): ?>
                                    <p><strong>out of stock right now</strong></p>
                                <?php else: ?>
                                    <p><strong><?php echo number_format($product['stock']); ?> left in stock </strong></p>
                                <?php endif; ?>

                                <form action="index.php?action=add_to_cart" method="post" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" class="btn">Add to Cart</button>
                                </form>


                                <a href="index.php?action=view&product_id=<?php echo $product['id']; ?>">
                                    View
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No products available yet.</p>
                    <?php endif; ?>
                </div>
            </main>

            <footer>
                <p>&copy; <?php echo date("Y"); ?> Some rights reserved (almost none tbh).</p>
            </footer>
        </div>
    </div>
</body>
</html>

