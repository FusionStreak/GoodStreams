<?php
session_start();
session_unset();
// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: ?page=login.php");
exit;
?>