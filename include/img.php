<script>
        function EquipmentAvailability() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '../api/received_data.json', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        const data = JSON.parse(xhr.responseText);
                        const itemExists = Object.keys(data).includes("<?php echo $key ?>");
                        const imgDiv = document.getElementById('img-<?php echo $key ?>');
                        if (itemExists) {
                            const colors = data["<?php echo $key ?>"].filter(item => item.Function === "SetEquipmentStatus").map(item => item.List1[0]);
                            imgDiv.src = colors[0].toUpperCase() === "BLUE" ? "../img/blue.png" : 
                                         colors[0].toUpperCase() === "RED" ? "../img/circle-xxl.png" : 
                                         colors[0].toUpperCase() === "GREEN" ? "../img/green.jpg" : "";
                        } else {
                            imgDiv.src = '../img/clock.png';
                        }
                    } else {
                        console.error('Error fetching data: ' + xhr.statusText);
                    }
                }
            };
            xhr.onerror = function() {
                console.error('Network error');
            };
            xhr.send();
        }

        EquipmentAvailability();
        setInterval(EquipmentAvailability, 5000);
    </script>