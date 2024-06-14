<script>
function EquipmentAvailability_value() {
    fetch('../api/received_data.json')
        .then(response => response.json())
        .then(data => {
            const itemExists = Object.keys(data).includes("<?php echo $value ?>");
            const imgDiv = document.getElementById('img-<?php echo $value ?>');
            if (itemExists) {
                const colors = data["<?php echo $value ?>"].filter(item => item.Function === "SetEquipmentStatus").map(item => item.List1[0]);
                imgDiv.src= colors[0].toUpperCase() === "BLUE" ? "../img/blue.png" : 
                colors[0].toUpperCase() === "RED" ? "../img/circle-xxl.png" : 
                colors[0].toUpperCase() === "GREEN" ? "../img/green.jpg" : "";
            } else {
                imgDiv.src = '../img/clock.png';
            }
        });
}

EquipmentAvailability_value();

setInterval(EquipmentAvailability_value, 3000);


</script>