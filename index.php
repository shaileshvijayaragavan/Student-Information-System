<?php
// Main entry point for the Student Information System
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Redirect to dashboard
header("Location: modules/dashboard/index.php");
exit();
?>