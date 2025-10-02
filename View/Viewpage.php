<!-- templates/viewpage.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="templates/viewpage.css">
</head>
<body>
    <div id="main">
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
        <div class="viewpage-container">
            <?php if (!empty($product)): ?>
                <div class="product-card">
                    
                    
                    <div class="product-image-container">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>

                    
                    <div class="product-info">
                        <h2><?php echo htmlspecialchars($product['name']); ?></h2>

                        <?php if (!empty($_SESSION['error'])): ?>
                            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                        <?php elseif (!empty($_SESSION['message'])): ?>
                            <p class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
                        <?php endif; ?>

                        <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                        <p class="stock"><?php echo number_format($product['stock']); ?> left in stock</p>

                        <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>

                        
                        <div class="buttons">
                            <form action="index.php?action=add_to_cart" method="post" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="btn">Add to Cart</button>
                            </form>
                            <a href="index.php?action=homepage" class="btn">⬅ Back to Shop</a>
                            <a href="index.php?action=cart" class="btn">🛒 Cart</a>
                        </div>
                    </div>

                </div>
            <?php else: ?>
                <p>No product found.</p>
            <?php endif; ?>
        </div>
        <footer>
            <p>&copy; <?php echo date("Y"); ?> All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
