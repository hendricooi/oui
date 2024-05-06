<?php

function get_method() {
    return $_SERVER['REQUEST_METHOD'];
}

function get_request_data() {
    return array_merge(empty($_POST) ? array() : $_POST, (array) json_decode(file_get_contents('php://input'), true), $_GET);
}

function is_not_ajax() {
    return empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest';
}

function send_response($response, $code = 200) {
    http_response_code($code);
    die(json_encode($response));
}

// Bail if not an Ajax request
if (is_not_ajax()) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    return;
}

// Get the API method
$method = get_method();

// Get any data sent with the request
// Includes query parameters, post data, and body content
$data = get_request_data();

// POST request
// Store some data or something
if ($method === 'POST') {

    session_start();
    $_SESSION['Load'] = $data['Load'];

    // You'd normally do stuff here...

    // Example: Check that all required data was provided
    if (empty($data['Load'])) {
        send_response([
            'status' => 'failed',
            'message' => 'Data did not received.',
        ], 400);
    }
    // Then, respond with a success along with the favorite data
    send_response([
        'status' => 'success',
        'message' => 'Data received',
        'Load' => $data['Load'] // Include the favorite data in the response
    ]);

}


// All other request methods
send_response([
    'code' => 405,
    'status' => 'failed',
    'message' => 'Method not allowed'
], 405);
