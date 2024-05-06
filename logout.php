
<?php
session_start();
$returnTo = $_SESSION['return_to'];
// remove all session variables
session_unset();

// destroy the session
session_destroy();

header("Location: $returnTo");
?>