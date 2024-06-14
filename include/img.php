<script>
function EquipmentAvailability() {
    const controller = new AbortController();
    const timeoutId = setTimeout(() => {
        controller.abort();
    }, 2500);
    fetch('../api/received_data.json')
        .then(response => response.json())
        .then(data => {
            const itemExists = Object.keys(data).includes("<?php echo $key ?>");
            const imgDiv = document.getElementById('img-<?php echo $key ?>');
            if (itemExists) {
                const colors = data["<?php echo $key ?>"].filter(item => item.Function === "SetEquipmentStatus").map(item => item.List1[0]);
                imgDiv.src= colors[0].toUpperCase() === "BLUE" ? "../img/blue.png" : 
                colors[0].toUpperCase() === "RED" ? "../img/circle-xxl.png" : 
                colors[0].toUpperCase() === "GREEN" ? "../img/green.jpg" : "";
            } else {
                imgDiv.src = '../img/clock.png';
            }
        });
}

EquipmentAvailability();

setInterval(EquipmentAvailability, 3000);


</script>