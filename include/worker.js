function fetchData() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../api/received_data.json', true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    const data = JSON.parse(xhr.responseText);
                    postMessage({ type: 'data', data: data });
                    console.log('Data fetched successfully:', data); // Log successful data fetch
                } catch (error) {
                    postMessage({ type: 'error', error: error.message });
                    console.error('Error parsing data:', error.message); // Log error
                }
            } else {
                postMessage({ type: 'error', error: xhr.statusText });
                console.error('Error fetching data:', xhr.statusText); // Log error
            }
        }
    };

    xhr.send();
}

// Fetch data every 3 seconds
setInterval(fetchData, 3000);

self.onmessage = function(event) {
    if (event.data === 'fetch') {
        fetchData();
    }
};