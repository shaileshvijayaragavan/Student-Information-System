<?php
// Login page for the Student Information System
session_start();

// Redirect to dashboard if already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: modules/dashboard/index.php");
    exit();
}

// Include database connection
require_once 'includes/config.php';

$error = '';

// Process login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password";
    } else {
        // Query to check admin credentials (using plaintext password as specified)
        $query = "SELECT * FROM admin WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            // Authentication successful
            $admin = $result->fetch_assoc();
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['admin_username'] = $admin['username'];
            
            // Redirect to dashboard
            header("Location: modules/dashboard/index.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Information System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-header">
            <h1>Student Information System</h1>
            <p>Admin Login</p>
        </div>
        
        <div class="login-form">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
            </form>
        </div>
        
        <div class="login-footer">
            <p>&copy; <?php echo date("Y"); ?> Student Information System</p>
        </div>
    </div>
    
    <script src="assets/js/script.js"></script>
</body>
</html>