
<?php
function makeCurlRequest($function, $data) {
    $curl = curl_init();

    $requestData = json_encode(array(
        "Function" => $function,
        "Data" => $data
    ));

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'localhost:8088',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => $requestData,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    $array=json_decode($response, true);
    $sectionArray = $array['Data'];
    $response= json_encode($sectionArray);
    curl_close($curl);
    return $response;
}

function LotRequest($function,$data, $eqpId) {
    // Initialize cURL session
    $curl_load = curl_init();

    // Set cURL options
    curl_setopt_array($curl_load, array(
        CURLOPT_URL => "localhost:8088",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array(
            "Function" => $function,
            "Data" => $data,
            "ActiveCCM" => 1,
            "EqpId" => $eqpId
        )),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    // Execute cURL request
    $response_load = curl_exec($curl_load);

    // Close cURL session
    curl_close($curl_load);

    // Return response
    return $response_load;
}

function CancelLotRequest($info, $eqpId) {
    // Initialize cURL session
    $curl = curl_init();

    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => "localhost:8088",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array(
            "Function" => "CancelLotInputOK",
            "Data" => $info,
            "EqpId" => $eqpId,
            "ActiveCCM" => 1,
            "LoadPort" => "LP1"
        )),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    // Execute cURL request
    $response = curl_exec($curl);

    // Close cURL session
    curl_close($curl);

    // Return response
    return $response;
}

function UnloadLotRequest($info, $eqpId) {
    // Initialize cURL session
    $curl = curl_init();

    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => "localhost:8088",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array(
            "Function" => "RequestUnloadFormType",
            "Data" => $info,
            "ActiveCCM" => 1,
            "EqpId" => $eqpId,
        )),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    // Execute cURL request
    $response = curl_exec($curl);

    // Close cURL session
    curl_close($curl);

    // Return response
    return $response;
}

function UnloadLotRequestAfter($function,$info, $eqpId) {
    // Initialize cURL session
    $curl = curl_init();

    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => "localhost:8088",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array(
            "Function" => $function,
            "Data" => $info,
            "EqpId" => $eqpId,
            "ActiveCCM" => 1,
            "LoadPort" => "LP1"
        )),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    // Execute cURL request
    $response = curl_exec($curl);

    // Close cURL session
    curl_close($curl);

    // Return response
    return $response;
}




