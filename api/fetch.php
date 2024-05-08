<?php

session_start();

if (isset($_SESSION['Load'])) {
    echo "<h3>Load Information:</h3>";

    foreach ($_SESSION['Load'] as $key => $value) {

        foreach ($value as $innerKey => $innerValue) {
            echo "<strong>{$innerKey}</strong>: ";

            if (is_array($innerValue)) {
                echo "[ ";
                foreach ($innerValue as $item) {
                    echo $item . " ";
                }
                echo "]<br>";
            } else {
                echo $innerValue . "<br>";
            }
        }

        echo "<br>";
    }
} else {
    echo "No data in session.";
}

?>

<script>

fetch('../api/load.php', {
	method: 'POST',
	headers: {
		'X-Requested-With': 'XMLHttpRequest',
	},
	body: JSON.stringify({
		Load: {
            "SES":{
                "EqpId" : "AOI-03",
                "Function" : "SetEquipmentStatus",
                "List1" : [
                "RED"
                ],
                "List2" : [
                "NG"
                ],
                "Value" : 0
            },
        "SLBA":{
                "EqpId" : "AOI-03",
                "Function" : "SetLOADButtonAvailability",
                "List1" : [
                ""
                ],
                "List2" : [
                ""
                ],
                "Value" : 0
            },
        "SUBA": {
                "EqpId" : "AOI-03",
                "Function" : "SetUNLOADButtonAvailability",
                "List1" : [
                ""
                ],
                "List2" : [
                ""
                ],
                "Value" : 0
            },
        "SLPBN":{
                "EqpId" : "AOI-03",
                "Function" : "UISetLPButtonName",
                "List1" : [
                "RED"
                ],
                "List2" : [
                "RESET"
                ],
                "Value" : 0
                }
        }
	})
})
.then(response => response.json()) // Parse the JSON response
.then(data => {
    // Handle the response data here
    console.log(data); // Output the response to the console
    // Assuming the response contains 'favorite' key, you can display it
    if (data.status === 'success') {
        console.log('Data:', data.Load);
    } else {
        console.error('Failed to retrieve data:', data.message);
    }
})
.catch(error => {
    // Handle any errors
    console.error('Error:', error);
});


</script>