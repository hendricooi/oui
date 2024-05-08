<?php 
session_start();
    // Output the value of 'Function'
print_r ($_SESSION);


echo "<br><br>";
// Access the stored data from $_SESSION
if (isset($_SESSION['EqpId'])) {
    $apiData = $_SESSION['EqpId'];
    echo "Data received from API: ";
    print_r($apiData);
} else {
    echo "No data received from API yet.";
}
?>

<script>
    // Function to fetch and process the data
function fetchDataAndProcess() {
    // Fetch the JSON file
    fetch('received_data.json')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Check if "Function" is "UIRTMessage"
        Object.keys(data).forEach(key => {
            if (data[key].Function === "UIRTMessage") {
                // If "Function" is "UIRTMessage", get the value of "List1"
                var list1Value = data[key].List1;
                // Now you can use list1Value as needed, such as echoing it on another page
                // For demonstration, let's log it to the console
                console.log("List1 value:", list1Value);
            }
        });
    })
    .catch(error => {
        console.error('There was a problem fetching the data:', error);
    });
}

// Call the function every 5 seconds
setInterval(fetchDataAndProcess, 5000);
</script>