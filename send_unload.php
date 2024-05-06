<?php
include("send_request.php");
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Get the posted data
    $info = $_POST['info'];
    $eqpId = $_POST['eqpId'];
    
    // Call the UnloadLotRequest function
    $response = UnloadLotRequest($info, $eqpId);

    // Output the response
    echo $response;

    // Stop further execution
    exit;
}
