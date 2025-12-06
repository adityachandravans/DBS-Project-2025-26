<?php
session_start();

// Redirect to dashboard if logged in, otherwise show welcome page
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Show welcome page for new visitors
include 'welcome.php';
?>
