<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="templates/dashboard.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <h2>My Online Shop</h2>
        </div>
        <nav>
            <a href="index.php?action=homepage">Home</a>
            <a href="index.php?action=cart">🛒 Cart</a>
            <a href="index.php?action=logout">Logout</a>
            <button id="darkModeToggle">🌙</button>
        </nav>
    </header>

    <!-- Main Dashboard -->
    <main>
        <div class="dashboard-container">
            <h2>User Dashboard</h2>

                <h2>
                <?php if (!empty($_SESSION['error'])): ?>
                    <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                <?php elseif (!empty($_SESSION['message'])): ?>
                    <p class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
                <?php endif; ?>
                </h2>

            <!-- Stats Section -->
            <section class="stats">
                <div class="card">
                    <h3>Total Orders</h3>
                    <p><?= $order_stats['total_orders'] ?></p>
                </div>
                <div class="card">
                    <h3>Completed</h3>
                    <p><?= $order_stats['completed'] ?></p>
                </div>
                <div class="card">
                    <h3>Pending</h3>
                    <p><?= $order_stats['pending'] ?></p>
                </div>
                <div class="card">
                    <h3>Cancelled</h3>
                    <p><?= $order_stats['cancelled']?></p>
                </div>
            </section>

            <!-- Orders Table -->
            <section>
                <h3>Lastest Orders</h3>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>#<?= htmlspecialchars($order['id']) ?></td>
                                    <td>$<?= htmlspecialchars($order['total']) ?></td>
                                    <td><?= htmlspecialchars($order['status']) ?></td>
                                    <td><?= htmlspecialchars($order['created_at']) ?></td>
                                    <td>
                                        <a href="index.php?action=view_order_details&order_id=<?= $order['id']; ?>" class="view-btn">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>

            <!-- Notifications -->
            <section class="section-box notification">
                <h3>Notifications</h3>
                <?php if (!empty($notifications)): ?>
                    <ul>
                        <?php foreach ($notifications as $note): ?>
                            <li><?= htmlspecialchars($note) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No new notifications.</p>
                <?php endif; ?>
            </section>

            <!-- Settings -->
            <section class="section-box settings">
                <h3>Account Settings</h3>
                <form action="index.php?action=change_password" method="post">
                    <label for="password">Change Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter new password" required>
                    <button class="btn" type="submit">Update Password</button>
                </form>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>© <?= date('Y') ?> My Online Shop. All rights reserved.</p>
    </footer>

    <!-- Dark Mode Script -->
    <script>
        const toggle = document.getElementById('darkModeToggle');
        toggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            toggle.textContent = document.body.classList.contains('dark-mode') ? '☀️' : '🌙';
        });
    </script>
</body>
</html>
