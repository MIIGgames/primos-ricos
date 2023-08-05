<?php
session_start();

// Check if the user is logged in (or authenticated using any other method you prefer)
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php'); // Redirect to the login page if not authenticated
    exit();
}
?>
