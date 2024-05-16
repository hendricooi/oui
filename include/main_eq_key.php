<?php 
$key_div = str_replace('-', '_', $key);
?>
<div style='display: flex; flex-direction: column;'>
<div class='container' style='margin-top:3px;  border: 1px solid #ccc; border-radius: 5px; padding: 10px;'>
<div class="row">
        <div class="label" style='width:140px;'>Equipment Status:</div>
        <div class="label">XSite:</div>
    </div>
    <div class="row" style="display: flex; justify-content: center;width: 100%; padding-top:10px; font-size:30px;">
        <div class="label" id="EqStatus-<?php echo $key_div ?>"></div>
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
        <div style='display: flex; flex-direction: column; margin-top:10px; border: 1px solid #ccc; border-radius: 5px; padding: 10px; height:70px;' >
            <div style='font-weight:bold'>Lot status</div>
            <div style='display: flex; flex-direction: row;'>
                <div style='flex: 1; margin-left:50px;'>
                    <div>Status</div>
                    <input id='LpStatus-<?php echo $key_div ?>' type='text' disabled style='height: 20px; padding: 5px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px;'>
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
                    <button class= 'LButton' id="LoadButton-<?php echo $key_div ?>" onclick='checkLoggedIn()'></button>
                    <button class= 'LButton' style="margin-top:5px;" onclick='openCancelLotPopoutWindow()'>Cancel Load</button>
                </div>
            </div>
        </div>
    <div style='margin-top:10px; border: 1px solid #ccc; border-radius: 5px; padding: 10px;'>
        <div style="font-weight:bold;"> Work in Progress(WIP) data</div>
        <div id="tableContainer-<?php echo $key_div ?>" style="max-height: 100px; overflow-y: auto; ">
        <table border=1 style='margin-top: 5px; width:100%;'>
        <thead style="position:sticky; border:1px solid #000; background-color:#fff; top:0;">
            <tr style="height:20px;">
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
        </thead>
        <tbody id="wipInfoTableBody-<?php echo $key_div ?>" style="height:60px;">
            <!-- Table rows will be appended here -->
        </tbody>
    </table>
</div>

        <div style='display: flex; margin-top:10px; border:1px solid black; padding-right:5px;'>
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
                <button class='LButton' style='margin-top:15px;' onclick='unloadLotPopoutWindow()'>Unload</button>
            </div>
        </div>
    </div>

        <div style= margin-top:10px;> Run Time Info </div>
        <div class="runtimeInfo" id= "runtimeInfo-<?php echo $key_div?>">
        <!-- Content will be updated here -->
    </div>
    </div>

<script>
const appendedMessages_<?php echo $key_div ?> = new Set();

function fetchData() {
    fetch('../api/received_data.json')
        .then(response => response.json())
        .then(data => {
            const uirtMessages = data["<?php echo $key ?>"].filter(item => item.Function === "UIRTMessage").map(item => item.List2);
            const runtimeInfoDiv = document.getElementById('runtimeInfo-<?php echo $key_div ?>');

            // Clear the existing messages
            runtimeInfoDiv.innerHTML = '';

            if (uirtMessages.length > 0) {
                // Flatten the array and sort messages in descending order
                const allMessages = uirtMessages.flat().sort((a, b) => b.localeCompare(a));

                allMessages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.textContent = message;
                    messageDiv.dataset.content = message; // Set data attribute to identify message content
                    messageDiv.classList.add('message'); // Add message class for styling
                    // Check if message contains "ERR" and add error class
                    if (message.includes("ERR")) {
                        messageDiv.classList.add('error'); // Add error class
                    }
                    // Append new message to runtimeInfoDiv
                    runtimeInfoDiv.appendChild(messageDiv);
                });
            } else {
                // Append message indicating no UIRT Messages
                const noMessagesDiv = document.createElement('div');
                noMessagesDiv.textContent = 'No UIRT Messages';
                noMessagesDiv.classList.add('no-messages');
                runtimeInfoDiv.appendChild(noMessagesDiv);
            }
        })
        .catch(error => {
        });
}

// Call fetchData initially
fetchData();
setInterval(fetchData, 3000);



function updateLPStatus() {
    fetch('../api/received_data.json')
        .then(response => response.json())
        .then(data => {
            const lpStatusArray = data["<?php echo $key ?>"].find(item => item.Function === "SetLPStatus");
            const EqStatusDiv = document.getElementById('EqStatus');
            if (lpStatusArray) {
                const lpStatus = lpStatusArray.List1;
                const lpStatusInput = document.getElementById('LpStatus-<?php echo $key_div ?>');
                if (lpStatusInput) {
                    lpStatusInput.value = lpStatus;
                } else {
                    console.error('Input field not found with ID:', 'LpStatus-<?php echo $key_div ?>');
                }
            } else {
            
            }
        })
        .catch(error => {
        
        });
}


 updateLPStatus();

setInterval(updateLPStatus, 3000);

function updateEqStatus() {
    fetch('../api/received_data.json')
        .then(response => response.json())
        .then(data => {
            const messages = data["<?php echo $key ?>"].filter(item => item.Function === "SetEquipmentStatus").map(item => item.List2[0]);
            const colors = data["<?php echo $key ?>"].filter(item => item.Function === "SetEquipmentStatus").map(item => item.List1[0]);
            const EqStatusDiv = document.getElementById('EqStatus-<?php echo $key_div?>');
            if (messages.length > 0) {
                EqStatusDiv.innerHTML = ''; // Clear existing content
                EqStatusDiv.innerHTML = messages[0]; // Assuming only one message is to be displayed
                // Set font color based on color value
                EqStatusDiv.style.color = colors[0] === "BLUE" ? "blue" : 
                                        colors[0] === "RED" ? "red" : 
                                        colors[0] === "GREEN" ? "green" : "black";
            } else {
            
            }
        })
        .catch(error => {
        
        });
}
 updateEqStatus();

setInterval(updateEqStatus, 3000);
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
            const LpButton = data["<?php echo $key ?>"].filter(item => item.Function === "UISetLPButtonName").map(item => item.List2[0]);
            const LpColors = data["<?php echo $key ?>"].filter(item => item.Function === "UISetLPButtonName").map(item => item.List1[0]);
            const EqButtonDiv = document.getElementById('LoadButton-<?php echo $key_div ?>');
            if(LpButton) {
                EqButtonDiv.innerHTML = ''; // Clear existing content
                EqButtonDiv.innerHTML = LpButton[0];
                EqButtonDiv.style.fontSize = "15px";
                EqButtonDiv.style.fontWeight = "bold";
                EqButtonDiv.style.backgroundColor = LpColors[0] === "RED" ? "red" :"";  
                EqButtonDiv.onclick = LpButton[0] === "LOAD" ? openLoadPopoutWindow : resetData;
                if(LpButton[0]=== "LOAD"){
                EqButtonDiv.addEventListener('mouseenter', function() {
                // Change background color to darkgrey
                this.style.backgroundColor = 'darkgrey';
                });
            
                // Add event listener for mouseleave (hover out)
                EqButtonDiv.addEventListener('mouseleave', function() {
                // Reset background color
                this.style.backgroundColor = ''; // or whatever the default background color is
                });
            }
            else{
                EqButtonDiv.addEventListener('mouseenter', function() {
                // Change background color to darkgrey
                this.style.backgroundColor = 'red';
                });
            
                // Add event listener for mouseleave (hover out)
                EqButtonDiv.addEventListener('mouseleave', function() {
                // Reset background color
                this.style.backgroundColor = 'red'; // or whatever the default background color is
                });
            }

            }
        })
    .catch(error => {
                // Do nothing to suppress the error
            });
}
updateLPButtonName();
setInterval(updateLPButtonName, 3000);

function resetData() {
    var resetIfLoggedIn = function() {
    // Make an AJAX call to the PHP function
    var eqpId<?php echo $key_div ?> = "<?php echo $key?>" // Set the equipment ID here
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../send_json.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Request was successful, do something with the response if needed
            var response = xhr.responseText;
            console.log(response); // Output the response to the console
        }
    };
    var data = JSON.stringify({
        Function: "ResetLP",
        Data: "LP1",
        ActiveCCM: 1,
        EqpId: eqpId
    });
    xhr.send(data);
}
checkLoggedIn(resetIfLoggedIn); 
}

function fetchTableData() {
    fetch('../api/received_data.json')
        .then(response => response.json())
        .then(data => {
            // Extract the WIP info messages where the function is "SetWIPInfo"
            const wipInfoMessages = data["<?php echo $key ?>"].filter(item => item.Function === "SetWIPInfo").flatMap(item => item.List1);
            const wipInfoTableBody = document.getElementById('wipInfoTableBody-<?php echo $key_div ?>');
            
            // Clear existing table rows
            wipInfoTableBody.innerHTML = '';

            // Check if there are any WIP info messages to display
            if (wipInfoMessages.length > 0) {
                // Iterate over each WIP info entry and create a table row for it
                wipInfoMessages.forEach(info => {
                    const row = document.createElement('tr');
                    row.style.height = '25px';
                    row.style.maxHeight = '25px';
                    row.style.color = 'blue';

                    // Iterate over each piece of data in the entry and create a table cell for it
                    info.forEach(cellData => {
                        const cell = document.createElement('td');
                        cell.textContent = cellData;
                        row.appendChild(cell);
                    });

                    // Append the completed row to the table body
                    wipInfoTableBody.appendChild(row);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

// Call the function initially to fetch and display data
fetchTableData();
// Set an interval to refresh the data every 3000 milliseconds (3 seconds)
setInterval(fetchTableData, 3000);


</script>