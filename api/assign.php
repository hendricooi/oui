<?php
session_start();
function get_request_data() {
    return array_merge(empty($_POST) ? array() : $_POST, (array) json_decode(file_get_contents('php://input'), true), $_GET);
}

// Check if data has been received via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = get_request_data();
    // Assign data to session variable
    $_SESSION['api_data'] = $data;

    // Return a response if needed
    echo json_encode(array("message" => $_SESSION['api_data']));
} else {
    // Handle other HTTP methods if necessary
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("error" => "Only POST requests are allowed"));
}
?>