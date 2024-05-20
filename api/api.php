<?php

function get_method() {
    return $_SERVER['REQUEST_METHOD'];
}

function get_request_data() {
    return array_merge(empty($_POST) ? array() : $_POST, (array) json_decode(file_get_contents('php://input'), true), $_GET);
}

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
                if ($data["Function"] === "UIRTMessage") {
                    // Append List2 value if the function is UIRTMessage
                    $existingData[$data["EqpId"]][$key]["List2"][] = $data["List2"][0];
                } elseif ($data["Function"] === "SetWIPInfo") {
                    // Initialize List1 as an empty array if it doesn't exist
                    if (!isset($existingData[$data["EqpId"]][$key]["List1"])) {
                        $existingData[$data["EqpId"]][$key]["List1"] = [];
                    }
                    // Append List1 values as a new subarray if the function is SetWIPInfo
                    $existingData[$data["EqpId"]][$key]["List1"][] = $data["List1"];
                } else {
                    // Overwrite values for other functions
                    $existingData[$data["EqpId"]][$key]["List1"] = $data["List1"];
                    $existingData[$data["EqpId"]][$key]["List2"] = $data["List2"];
                    $existingData[$data["EqpId"]][$key]["Value"] = $data["Value"];
                }
                $updated = true;
                break; // No need to continue searching
            }
        }

        if (!$updated) {
            // Append the data to existing entry
            $newEntry = [
                "Function" => $data["Function"],
                "List1" => $data["Function"] === "SetWIPInfo" ? [$data["List1"]] : $data["List1"],
                "List2" => $data["List2"],
                "Value" => $data["Value"]
            ];
            $existingData[$data["EqpId"]][] = $newEntry;
        }
    } else {
        // Initialize $existingData for the current EqpId
        $newEntry = [
            "Function" => $data["Function"],
            "List1" => $data["Function"] === "SetWIPInfo" ? [$data["List1"]] : $data["List1"],
            "List2" => $data["List2"],
            "Value" => $data["Value"]
        ];
        $existingData[$data["EqpId"]] = [$newEntry];
    }
    
    // Write updated data to the file
    file_put_contents('received_data.json', json_encode($existingData, JSON_PRETTY_PRINT));

    // Example: Check that all required data was provided
    if (empty($data)) {
        send_response([
            'status' => 'failed',
            'message' => 'Data did not receive.',
        ], 400);
    }

    // Then, respond with a success along with the received data
    send_response([
        'status' => 'success',
        'message' => 'Data received',
        'Data' => $data // Include the received data in the response
    ]);
}
?>
