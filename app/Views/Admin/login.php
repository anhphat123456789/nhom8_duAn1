<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="assets/Admin/css/login.css">
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <div class="error">
            <?php
                if(isset($_SESSION['error'])) {
                    echo "<p>".$_SESSION['error']. "</p>";
                    unset($_SESSION['error']);
                }
            ?>
        </div>
        <form action="<?= BASE_URL ?>?role=admin&act=post-login" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="register.html">Register here</a></p>
            </div>
        </form>
    </div>
</body>
</html>
