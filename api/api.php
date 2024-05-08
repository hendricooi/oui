<?php

function get_method() {
    return $_SERVER['REQUEST_METHOD'];
}

function get_request_data() {
    return array_merge(empty($_POST) ? array() : $_POST, (array) json_decode(file_get_contents('php://input'), true), $_GET);
}

// function is_not_ajax() {
//     return empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest';
// }

function send_response($response, $code = 200) {
    http_response_code($code);
    die(json_encode($response));
}

// Get the API method
$method = get_method();

// Get any data sent with the request
// Includes query parameters, post data, and body content
$data = get_request_data();


// POST request
// Store some data or something
if ($method === 'POST') {
    $existingData = [];
    if (file_exists('received_data.json')) {
        $existingData = json_decode(file_get_contents('received_data.json'), true);
    }
    
    // Check if $existingData has already been initialized for the current EqpId
    if (isset($existingData[$data["EqpId"]])) {
        $updated = false; // Flag to check if data was updated

        // Loop through existing entries for the current EqpId
        foreach ($existingData[$data["EqpId"]] as $key => $entry) {
            // Check if the "Function" value already exists
            if ($entry["Function"] === $data["Function"]) {
                // Overwrite values
                $existingData[$data["EqpId"]][$key]["List1"] = $data["List1"];
                $existingData[$data["EqpId"]][$key]["List2"] = $data["List2"];
                $existingData[$data["EqpId"]][$key]["Value"] = $data["Value"];
                $updated = true;
                break; // No need to continue searching
            }
        }

        if (!$updated) {
            // Append the data to existing entry
            $existingData[$data["EqpId"]][] = [
                "Function" => $data["Function"],
                "List1" => $data["List1"],
                "List2" => $data["List2"],
                "Value" => $data["Value"]
            ];
        }
    } else {
        // Initialize $existingData for the current EqpId
        $existingData[$data["EqpId"]] = [
            [
                "Function" => $data["Function"],
                "List1" => $data["List1"],
                "List2" => $data["List2"],
                "Value" => $data["Value"]
            ]
        ];
    }
    
    // Write updated data to the file
    file_put_contents('received_data.json', json_encode($existingData, JSON_PRETTY_PRINT));
    // Example: Check that all required data was provided
    if (empty($data)) {
        send_response([
            'status' => 'failed',
            'message' => 'Data did not received.',
        ], 400);
    }

    // Then, respond with a success along with the favorite data
    send_response([
        'status' => 'success',
        'message' => 'Data received',
        'Data' => $data // Include the favorite data in the response
    ]);

}
?>
<!-- <script>
// Define a function to handle the API call
function callApi() {
    fetch('../api/load.php', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json' // Specify content type as JSON
        },
        body: JSON.stringify({
            'Load': '<?php isset($data) ? $data : '' ?>'
            // Assuming 'Load' is the key you want to send
        })
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response data here
        console.log(data);
        // You can do further processing here based on the response
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Call the function when the page loads or whenever you want to trigger the API call
callApi();
</script> -->