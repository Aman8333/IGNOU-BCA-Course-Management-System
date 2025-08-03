<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: admin-login.php');
    exit;
}
require_once 'config.php';

// Get the ID from the URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    // Delete the record
    $stmt = $conn->prepare("DELETE FROM materials WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to the dashboard
header("Location: admin-dashboard.php");
exit;
?>
