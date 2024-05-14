const fs = require('fs');

// Path to the JSON file
const filePath = '../api/received_data.json';

// Function to read JSON file
function readJSONFile(filename, callback) {
    fs.readFile(filename, 'utf8', (err, data) => {
        if (err) {
            callback(err);
            return;
        }
        try {
            const json = JSON.parse(data);
            callback(null, json);
        } catch (error) {
            callback(error);    
        }
    });
}

// Function to compare two JSON objects
function compareJSON(obj1, obj2) {
    return JSON.stringify(obj1) === JSON.stringify(obj2);
}

// Watch for changes to the JSON file
fs.watch(filePath, (event, filename) => {
    if (event === 'change') {
        readJSONFile(filePath, (err, newData) => {
            if (err) {
                console.error('Error reading JSON file:', err);
                return;
            }

            // Compare current data with previous data
            if (!compareJSON(newData, previousData)) {
                console.log('JSON file has changed!');
                // Update previousData for the next comparison
                previousData = newData;
            } else {
                console.log('JSON file has not changed.');
            }
        });
    }
});

// Read the initial contents of the JSON file
let previousData;
readJSONFile(filePath, (err, initialData) => {
    if (err) {
        console.error('Error reading JSON file:', err);
        return;
    }
    previousData = initialData;
});