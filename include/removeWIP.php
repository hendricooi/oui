<?php

// Read the JSON file
$jsonData = file_get_contents('../api/received_data.json');

// Decode JSON data
$data = json_decode($jsonData, true);

// Function to remove subarray from List1 if it matches with List1 value of RemoveWIPItem
function removeWIPItem(&$list1, $itemToRemove) {
    $found = false;
    foreach ($list1 as $key => $subarray) {
        // Check if $itemToRemove string value is in $subarray
        if (in_array($itemToRemove, $subarray)) {
            unset($list1[$key]);
            $found = true; // Subarray removed
        }
    }
    // Re-index the array
    $list1 = array_values($list1);
    return $found;
}

// Loop through each key (equipment) in data
foreach ($data as $equipment => $entries) {
    // Collect keys to remove after processing
    $keysToRemove = [];

    // Loop through each entry for the equipment
    foreach ($entries as $key => $entry) {
        if ($entry['Function'] === 'RemoveWIPItem') {
            // Remove subarray from List1 if it matches with List1 value of RemoveWIPItem
            foreach ($entry['List1'] as $itemToRemove) {
                foreach ($data[$equipment] as $subkey => $subentry) {
                    if ($subentry['Function'] === 'SetWIPInfo') {
                        removeWIPItem($data[$equipment][$subkey]['List1'], $itemToRemove);
                    }
                }
            }
            // Mark this entry for removal
            $keysToRemove[] = $key;
        }
    }
    // Remove the 'RemoveWIPItem' entries
    foreach ($keysToRemove as $key) {
        unset($data[$equipment][$key]);
    }
    // Re-index the array
    $data[$equipment] = array_values($data[$equipment]);
}

// Encode data back to JSON
$newJsonData = json_encode($data, JSON_PRETTY_PRINT);

// Update the JSON file
file_put_contents('../api/received_data.json', $newJsonData);

?>
