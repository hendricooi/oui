<?php
include("send_request.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if 'info' and 'eqpId' parameters are present
    if (isset($_POST['info']) && isset($_POST['eqpId'])) {
        // If 'info' and 'eqpId' parameters are present, it's an UnloadLotRequest
        // Call the UnloadLotRequest function
        $info = $_POST['info'];
        $eqpId = $_POST['eqpId'];
        $response = UnloadLotRequest($info, $eqpId);
    } else {
        // If 'info' and 'eqpId' parameters are not present, assume it's a JSON request
        // Get the POST data
        $postData = json_decode(file_get_contents("php://input"), true);

        // Check if 'EqpId' parameter is present
        if (isset($postData["EqpId"])) {
            // If 'EqpId' parameter is present, it's a ResetLoadLot request
            // Call the ResetLoadLot function with the equipment ID from the POST data
            $eqpId = $postData["EqpId"];
            $response = ResetLoadLot($eqpId);
        } else {
            // If 'EqpId' parameter is not present, return an error response
            $response = "Invalid request: EqpId parameter is missing.";
        }
    }

    // Send the response back to the client
    echo $response;

    // Stop further execution
    exit;
}
?>