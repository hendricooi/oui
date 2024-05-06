<?php
// Start or resume the session
session_start();

// Check if the necessary parameters are provided
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve POST data
    unset($_SESSION['$eqpId']);
    $_SESSION['eqpId'] = $_POST["eqpId"];
    $eqpId = $_POST["eqpId"];

    // Echo back the received data
    echo "Received eqpId: " . $_SESSION['eqpId'];
    
} else {
    // If no POST data is received, return an error message
    echo "No POST data received.";
}
?>
