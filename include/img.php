<script>
function EquipmentAvailability() {
    fetch('../api/received_data.json')
        .then(response => response.json())
        .then(data => {
            const itemExists = Object.keys(data).includes("<?php echo $key ?>");
            const imgDiv = document.getElementById('img-<?php echo $key ?>');
            if (itemExists) {
                const blueStatusEntry = data["<?php echo $key ?>"].find(item => item.Function === "SetEquipmentStatus" && item.List1[0] === "BLUE");
                if (blueStatusEntry) {
                    imgDiv.src = '../img/blue.png';
                } else {
                    imgDiv.src = '../img/circle-xxl.png';
                }
            } else {
                imgDiv.src = '../img/clock.png';
            }
        });
}

EquipmentAvailability();

setInterval(EquipmentAvailability, 3000);


</script>