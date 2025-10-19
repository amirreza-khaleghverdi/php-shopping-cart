<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="templates/adminpanel.css">

    <script>
        function showSection(id) {
            const sections = document.querySelectorAll('.section');
            sections.forEach(s => s.classList.remove('active'));
            document.getElementById(id).classList.add('active');
        }
    </script>
</head>
<body>
    <div class="admin-container">
        <h1>Admin Panel</h1>

        <nav>
            <button onclick="showSection('orders')">Orders</button>
            <button onclick="showSection('products')">Products</button>
            <button onclick="showSection('users')">Users</button>
        </nav>

        <!-- Orders Section -->
        <section id="orders" class="section active">
            <button class="add-btn" onclick="window.location.href='?controller=orders&action=create'">+ Add Order</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
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
                                <td><?= htmlspecialchars($order['id']) ?></td>
                                <td><?= htmlspecialchars($order['user_id']) ?></td>
                                <td>$<?= htmlspecialchars($order['total']) ?></td>
                                <td><?= htmlspecialchars($order['status']) ?></td>
                                <td><?= htmlspecialchars($order['created_at']) ?></td>
                                <td class="actions">
                                    <button class="view-btn" onclick="window.location.href='index.php?action=view_order&id=<?= $order['id'] ?>'">View</button>
                                    <button class="edit-btn" onclick="window.location.href='index.php?action=edit&id=<?= $order['id'] ?>'">Edit</button>
                                    <button class="delete-btn" onclick="window.location.href='index.php?action=delete&type=order&id=<?= $order['id'] ?>'">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6">No orders found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <!-- Products Section -->
        <section id="products" class="section">
            <button class="add-btn" onclick="window.location.href='?controller=products&action=create'">+ Add Product</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Image Url</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['id']) ?></td>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td>$<?= htmlspecialchars($product['price']) ?></td>
                                <td><?= htmlspecialchars($product['stock']) ?></td>
                                <td><?= htmlspecialchars($product['image_url']) ?></td>
                                <td><?= htmlspecialchars($product['description']) ?></td>
                                <td class="actions">
                                    <button class="view-btn" onclick="window.location.href='?controller=products&action=view&id=<?= $product['id'] ?>'">View</button>
                                    <button class="edit-btn" onclick="window.location.href='?controller=products&action=edit&id=<?= $product['id'] ?>'">Edit</button>
                                    <button class="delete-btn" onclick="window.location.href='index.php?action=delete&type=product&id=<?= $product['id'] ?>'">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6">No products found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <!-- Users Section -->
        <section id="users" class="section">
            <button class="add-btn" onclick="window.location.href='?controller=users&action=create'">+ Add User</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Register Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td><?= htmlspecialchars($user['name']) ?></td>
                                <td><?= htmlspecialchars($user['password']) ?></td>
                                <td><?= htmlspecialchars($user['created_at']) ?></td>
                                <td class="actions">
                                    <button class="view-btn" onclick="window.location.href='?controller=users&action=view&id=<?= $user['id'] ?>'">View</button>
                                    <button class="edit-btn" onclick="window.location.href='?controller=users&action=edit&id=<?= $user['id'] ?>'">Edit</button>
                                    <button class="delete-btn" onclick="window.location.href='index.php?action=delete&type=user&id=<?= $user['id'] ?>'">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5">No users found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
