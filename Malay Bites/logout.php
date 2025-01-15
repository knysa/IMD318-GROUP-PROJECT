<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the login page with a success message
header("Location: index.php?message=You have successfully logged out.");
exit();
?>
