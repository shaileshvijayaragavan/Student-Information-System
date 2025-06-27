<?php
// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Student Information System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <!-- Top Navigation Bar -->
        <header class="app-header">
            <div class="header-left">
                <button id="sidebar-toggle" class="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="app-title">Student Information System</h1>
            </div>
            <div class="header-right">
                <div class="admin-profile">
                    <span class="admin-name"><?php echo $_SESSION['admin_name']; ?></span>
                    <div class="dropdown">
                        <button class="dropdown-toggle">
                            <i class="fas fa-user-circle"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="../../modules/admin/profile.php">
                                <i class="fas fa-user"></i> Profile
                            </a>
                            <a href="../../logout.php">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <div class="app-body">
            <!-- Sidebar Navigation -->
            <?php include '../../includes/sidebar.php'; ?>
            
            <!-- Main Content Area -->
            <main class="app-content">
                <?php if(isset($pageTitle)): ?>
                <div class="content-header">
                    <h2><?php echo $pageTitle; ?></h2>
                    <?php if(isset($breadcrumbs)): ?>
                    <div class="breadcrumbs">
                        <?php echo $breadcrumbs; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>