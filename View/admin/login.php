<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="templates/login.css">

</head> 
<body id="main">
    <div class="form">
        <div class="form-content">
            <h2>Secret Login Page</h2>
            <?php if (!empty($_SESSION['error']))
            echo "<p>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']); ?> 
        </div>
        
        <div class="form-content">

            <form method="POST" action="index.php?action=doAdminLogin">
                <fieldset>
                    <legend class="legend">login:</legend>
                    <label for="username">Username:</label><br>
                    <input type="text" id="username" name="username" placeholder="enter username" required><br>
                    <label for="password">password:</label><br>
                    <input type="password" id="password" name="password"  placeholder="enter password" required><br><br>
                    <input type="submit" value="login">
                </fieldset>
            </form>

        </div>

        <footer>
            <p>&copy; <?= date('Y'); ?> Some rights reserved (almost none tbh).</p>
        </footer>
    </div>
    
</body>
</html>

