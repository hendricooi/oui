<?php
// Read the stored data
$stored_data = file_get_contents('received_data.json');
session_start();
// Parse the JSON data
$received_data = json_decode($stored_data, true);

// Now you can use $received_data as needed
print_r($received_data);
?>

<script>
    function displayLatestData() {
    // Fetch the JSON file
    fetch('received_data.json')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Get the latest entry (last element in the array)
        const latestEntry = data[data.length - 1];

        // Display the latest entry
        console.log("Latest entry:", latestEntry);
        // Example of displaying "List1" value on the page
        if (latestEntry.Function === "UIRTMessage") {
            document.getElementById("list1Value").innerText = latestEntry.List1[0];
        }
    })
    .catch(error => {
        console.error('There was a problem fetching the data:', error);
    });
}

// Call the function to display the latest data
displayLatestData();
</script>
