<script>
function EquipmentAvailability(){
    fetch('../api/received_data.json')
        .then(response => response.json())
        .then(data => {
            // Check if data contains AOI-03 equipment
            const imgArray = data['<?php echo $key ?>'];
            if (imgArray) {
            const blueStatusEntry = imgArray.find(item => item.Function === "SetEquipmentStatus" && item.List1[0] === "BLUE");
            const imgDiv = document.getElementById('img-<?php echo $key ?>');
            if (blueStatusEntry) {
                    imgDiv.src = '../img/blue.png';
                }
                else{
                imgDiv.src = '../img/circle-xxl.png';
                }
            }
            })
        }

EquipmentAvailability();

setInterval(EquipmentAvailability, 5000);

</script>