<?php 
$item = str_replace('-', '_', $item);
?>
<div style='display: flex; flex-direction: column;'>
        <div style='display: flex; margin-top:10px;'>
            <div style='flex: 1;'>Equipment Status = </div>
            <div style='margin-left: auto;'> User ID:<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></div>
        </div>

        <div style='display: flex;'>
            <div style='flex: 1;'>XSite= </div>
            <div style='margin-left: auto;'> Badge ID:<?php echo isset($_SESSION['ID']) ? $_SESSION['ID'] : ''; ?></div>
        </div> 

        <div style='display: flex; flex-direction: column; margin-top:10px'>
            <div>Lot status</div>
            <div style='display: flex; flex-direction: row;'>
                <div style='flex: 1; margin-left:50px;'>
                    <div>Status</div>
                    <input id='LpStatus-<?php echo $item ?>' type='text' value="" disabled>
                </div>
                <div style='flex: 1;'>
                    <div>Lot ID</div>
                    <input type='text'>
                </div>
                <div style='flex: 1;'>
                    <div>Recipe</div>
                    <input type='text'>
                </div>
                <div style='display: flex; flex-direction: column;'>
                    <button class= class=eq-button; style='margin-bottom:5px;' onclick='openLoadPopoutWindow()'>Load</button>
                    <button class= class=eq-button; onclick='openCancelLotPopoutWindow()'>Cancel Load</button>
                </div>
            </div>
        </div>

        <div style= margin-top:10px> Work in Progress(WIP) data</div>
        <table border=1 style='margin-top: 5px; width:100%;'>
            <tr>
                <th>LotID</th>
                <th>Operation</th>
                <th>Device</th>
                <th>Package</th>
                <th>Track In Qty</th>
                <th>Recipe</th>
                <th>Status</th>
                <th>User ID</th>
                <th>Time In</th>
            </tr>
            <tr>
                <td data-label='LotID'>abc</td>
                <td data-label='Operation'>cdef</td>
                <td data-label='Device'>ewrew</td>
                <td data-label='Package'>12312321</td>
                <td data-label='TrackInQty'>12323</td>
                <td data-label='Recipe'>rgbgrb</td>
                <td data-label='Status'>rbgrb</td>
                <td data-label='UserID'>ikiu</td>
                <td data-label='TimeIn'>546454</td>
            </tr>
        </table>

        <div style='display: flex; margin-top:20px; border:1px solid black; padding-right:5px;'>
            <div style='display: flex; flex-wrap: wrap; width:100%;'>
                <button class=eq-button onclick='checkLoggedIn()'>Reserved 1</button>
                <button class=eq-button>Reserved 2</button>
                <button class=eq-button>Reserved 3</button>
                <button class=eq-button>Reserved 4</button>
                <button class=eq-button>Reserved 5</button>
                <button class=eq-button>Reserved 6</button>
                <button class=eq-button>Reserved 7</button>
                <button class=eq-button>Reserved 8</button>
                <button class=eq-button>Reserved 9</button>
                <button class=eq-button>Reserved 10</button>
            </div>
            <div style='display:flex; width: 20%;'>
                <button style='height:25px; width:175px; margin-top:15px;' onclick='unloadLotPopoutWindow()'>Unload</button>
            </div>
        </div>

        <div style= margin-top:10px;> Run Time Info </div>
        <div class="runtimeInfo" id= "runtimeInfo-<?php echo $item ?>">
        <!-- Content will be updated here -->
    </div>
    </div>

<script>
const appendedMessages_<?php echo $item ?> = new Set();

function fetchData() {
    fetch('../api/received_data.json')
        .then(response => response.json())
        .then(data => {
            const messages = data["AOI-03"].filter(item => item.Function === "UIRTMessage").map(item => item.List2[0]);
            const runtimeInfoDiv = document.getElementById('runtimeInfo-AOI-03');
            if (messages.length > 0) {
                messages.forEach(message => {
                    if (!appendedMessages_<?php echo $item ?>.has(message)) {
    // Check if message is already present in the DOM
                        if (!runtimeInfoDiv.querySelector(`.message[data-content="${message}"]`)) {
                            const messageDiv = document.createElement('div');
                            messageDiv.textContent = message;
                            messageDiv.dataset.content = message; // Set data attribute to identify message content
                            console.log(message);
                            messageDiv.classList.add('message'); // Add message class for styling
                            // Check if message starts with "ERR" and add red color
                            if (message.includes("ERR")) {
                                messageDiv.classList.add('error'); // Add error class
                            }
                            // Insert new message before the first child of runtimeInfoDiv
                            runtimeInfoDiv.insertBefore(messageDiv, runtimeInfoDiv.firstChild);
                        }
                        appendedMessages_<?php echo $item ?>.add(message); // Add message to the set of appended messages
                    }
                });
            } else {
 // Append message indicating no UIRT Messages
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

// // Call fetchData initially
// fetchData();

// // Call fetchData every 5 seconds
// setInterval(fetchData, 5000);


function updateLPStatus() {
    fetch('../api/received_data.json')
        .then(response => response.json())
        .then(data => {
            const lpStatusArray = data["AOI-03"].find(item => item.Function === "SetLPStatus");
            if (lpStatusArray) {
                const lpStatus = lpStatusArray.List1;
                const lpStatusInput = document.getElementById('LpStatus-<?php echo $item ?>');
                if (lpStatusInput) {
                    // lpStatusInput.setAttribute('value', lpStatus); // Set the value attribute directly
                    document.getElementById('LpStatus-<?php echo $item ?>').value = lpStatus;
                } else {
                    console.error('Input field not found with ID:', 'LpStatus-<?php echo $item ?>');
                }
            } else {
                console.error('No data found for SetLPStatus function');
            }
        })
        .catch(error => {
            console.error('Error fetching LP status data:', error);
        });
}

// updateLPStatus();

// // Call updateLPStatus every 5 seconds
// setInterval(updateLPStatus, 5000);
</script>