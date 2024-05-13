<?php 
$key = str_replace('-', '_', $key);
?>
<div style='display: flex; flex-direction: column;'>
<div class='container' style='margin-top:3px;  border: 1px solid #ccc; border-radius: 5px; padding: 10px;'>
<div class="row">
        <div class="label" style='width:140px;'>Equipment Status:</div>
        <div class="label">XSite:</div>
    </div>
    <div class="row" style="display: flex; justify-content: center;width: 100%; padding-top:10px; font-size:30px;">
        <div class="label" id="EqStatus-<?php echo $key ?>"></div>
    </div>
    <div class="row" style="margin-left:auto;">
        <div class="label">UserId:</div>
        <div class="label" style='width:75px'>Badge ID:</div>
    </div>
    <div class="row">
        <div class="value"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></div>
        <div class="value"><?php echo isset($_SESSION['ID']) ? $_SESSION['ID'] : ''; ?></div>
    </div>
</div>
        <div style='display: flex; flex-direction: column; margin-top:10px; border: 1px solid #ccc; border-radius: 5px; padding: 10px;' >
            <div style='font-weight:bold'>Lot status</div>
            <div style='display: flex; flex-direction: row;'>
                <div style='flex: 1; margin-left:50px;'>
                    <div>Status</div>
                    <input id='LpStatus-<?php echo $key ?>' type='text' disabled style='height: 20px; padding: 5px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px;'>
                </div>
                <div style='flex: 1;'>
                    <div>Lot ID</div>
                    <input type='text' style='height: 20px; padding: 5px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px;'>
                </div>
                <div style='flex: 1;'>
                    <div>Recipe</div>
                    <input type='text' style='height: 20px; padding: 5px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px;'>
                </div>
                <div style='display: flex; flex-direction: column;'>
                    <button class= 'LPbutton' id="LoadButton-<?php echo $key ?>"></button>
                    <button class= 'LPButton' onclick='openCancelLotPopoutWindow()' style="background-color: rgb(192, 187, 187 /48%);">Cancel Load</button>
                </div>
            </div>
        </div>
    <div style='margin-top:10px; border: 1px solid #ccc; border-radius: 5px; padding: 10px;'>
        <div> Work in Progress(WIP) data</div>
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
    </div>

        <div style= margin-top:10px;> Run Time Info </div>
        <div class="runtimeInfo" id= "runtimeInfo-<?php echo $key ?>">
        <!-- Content will be updated here -->
    </div>
    </div>

<script>
const appendedMessages_<?php echo $key ?> = new Set();

function fetchData() {
    fetch('../api/received_data.json')
        .then(response => response.json())
        .then(data => {
            const messages = data["AOI-03"].filter(item => item.Function === "UIRTMessage").map(item => item.List2[0]);
            const runtimeInfoDiv = document.getElementById('runtimeInfo-<?php echo $key ?>');
            if (messages.length > 0) {
                messages.forEach(message => {
                    if (!appendedMessages_<?php echo $key ?>.has(message)) {
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
                        appendedMessages_<?php echo $key ?>.add(message); // Add message to the set of appended messages
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

// Call fetchData initially
fetchData();

// Call fetchData every 5 seconds
setInterval(fetchData, 5000);

function updateLPStatus() {
    fetch('../api/received_data.json')
        .then(response => response.json())
        .then(data => {
            const lpStatusArray = data["AOI-03"].find(item => item.Function === "SetLPStatus");
            const EqStatusDiv = document.getElementById('EqStatus');
            if (lpStatusArray) {
                const lpStatus = lpStatusArray.List1;
                const lpStatusInput = document.getElementById('LpStatus-<?php echo $key ?>');
                if (lpStatusInput) {
                    lpStatusInput.value = lpStatus;
                } else {
                    console.error('Input field not found with ID:', 'LpStatus-<?php echo $key ?>');
                }
            } else {
                console.error('No data found for SetLPStatus function');
            }
        })
        .catch(error => {
            console.error('Error fetching LP status data:', error);
        });
}


updateLPStatus();

setInterval(updateLPStatus, 5000);

function updateEqStatus() {
    fetch('../api/received_data.json')
        .then(response => response.json())
        .then(data => {
            const messages = data["AOI-03"].filter(item => item.Function === "SetEquipmentStatus").map(item => item.List2[0]);
            const colors = data["AOI-03"].filter(item => item.Function === "SetEquipmentStatus").map(item => item.List1[0]);
            const EqStatusDiv = document.getElementById('EqStatus-<?php echo $key ?>');
            if (messages.length > 0) {
                EqStatusDiv.innerHTML = ''; // Clear existing content
                EqStatusDiv.innerHTML = messages[0]; // Assuming only one message is to be displayed
                // Set font color based on color value
                EqStatusDiv.style.color = colors[0] === "BLUE" ? "blue" : (colors[0] === "RED" ? "red" : "black");
            } else {
                console.error('No data found for SetEquipmentStatus function');
            }
        })
        .catch(error => {
            console.error('Error fetching equipment status data:', error);
        });
}
updateEqStatus();

setInterval(updateEqStatus, 5000);

function openLoadPopoutWindow() {
    // Define the URL of the pop-out window
    // Check if the user is logged in before opening the popout window

    var openWindowIfLoggedIn = function() {
    var url = "../window/load_page.php";

    // Define the dimensions and position of the pop-out window
    var width = 600;
    var height = 400;
    var left = (screen.width - width) / 2;
    var top = (screen.height - height) / 2;

    // Open the pop-out window with specified dimensions and position
    window.open(url, "popoutWindow", "width=" + width + ", height=" + height + ", left=" + left + ", top=" + top);
};
checkLoggedIn(openWindowIfLoggedIn);
}

function updateLPButtonName() {
    fetch('../api/received_data.json')
        .then(response => response.json())
        .then(data => {
            const LpButton = data["AOI-03"].filter(item => item.Function === "UISetLPButtonName").map(item => item.List2[0]);
            const LpColors = data["AOI-03"].filter(item => item.Function === "UISetLPButtonName").map(item => item.List1[0]);
            const EqButtonDiv = document.getElementById('LoadButton-<?php echo $key ?>');
            if(LpButton) {
                EqButtonDiv.innerHTML = ''; // Clear existing content
                EqButtonDiv.innerHTML = LpButton[0];
                EqButtonDiv.style.fontSize = "15px";
                EqButtonDiv.style.fontWeight = "bold";
                EqButtonDiv.style.backgroundColor = LpColors[0] === "RED" ? "red" : "rgb(192, 187, 187 /48%)";  
                EqButtonDiv.onclick = LpButton[0] === "LOAD" ? openLoadPopoutWindow : resetData;
            }

})
}
updateLPButtonName();

setInterval(updateLPButtonName, 5000);

function resetData(){
    console.log('test');
}
</script>