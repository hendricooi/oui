<?php 
include("send_request.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the POST data
    $postData = json_decode(file_get_contents("php://input"), true);

    // Call the ResetLoadLot function with the equipment ID from the POST data
    $eqpId = $postData["EqpId"];
    $response = ResetLoadLot($eqpId);

    // Send the response back to the client
    echo $response;
}
?>