<?php
session_start();
session_unset();
session_destroy();

// Redirect to login page
header('Location: admin-login.php');
exit;
?>
