<?php
// Start the session
session_start();

// Unset all of the session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page or any other page as needed
header("Location: index.html"); // Replace "login.php" with the desired destination
exit();
?>
