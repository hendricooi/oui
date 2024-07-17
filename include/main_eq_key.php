
<?php 
$key_div = str_replace('-', '_', $key);
?>
<div style='display: flex; flex-direction: column;'>
<div class='container' style='margin-top:3px;  border: 1px solid #ccc; border-radius: 5px; padding: 10px;'>
<div class="row">
        <div class="label" style='width:140px;'>Equipment Status:</div>
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
                    <input type='text' id='textBox<?php echo $key_div?>' style='height: 20px; padding: 5px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px;'>
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
        <div class="loading" id="loading-<?php echo $key_div?>"></div>
    <div style='margin-top:10px; border: 1px solid #ccc; border-radius: 5px; padding: 10px;'>
        <div style="font-weight:bold;"> Work in Progress(WIP) data</div>
        <div id="tableContainer-<?php echo $key_div ?>" style="max-height: 100px; height:100px; overflow-y: auto; ">
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

        <div style='display: flex; margin-top:5px; border:1px solid black; padding-right:5px;'>
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

        <div style= "margin-top:10px; font-weight:bold;"> Run Time Info </div>
        <div class="runtimeInfo" id= "runtimeInfo-<?php echo $key_div?>">
        <!-- Content will be updated here -->
    </div>
    </div>
    <script src="../include/script_jquery.js" type="text/javascript"></script>
<script>
const appendedMessages_<?php echo $key_div ?> = new Set();

if (window.Worker) {
    const worker = new Worker('../include/worker.js');
    worker.onmessage = function(event) {
        if (event.data.type === 'data') {
            const data = event.data.data;
            console.log('Data received from worker:', new Date().toLocaleString(), data);// Add logging to check data
            fetchTableData(data);
            fetchData(data);
            updateLPStatus(data);
            updateEqStatus(data);
            updateLPButtonName(data);
            RemoveItem(data);
        } else if (event.data.type === 'error') {
            console.error('Worker error:', event.data.error);
        }
    };

    // Continuously fetch data from the worker every 3 seconds
    setInterval(() => worker.postMessage('fetch'), 3000);

    function fetchTableData(data) {
        const wipInfoMessages = (data["<?php echo $key ?>"] || []).filter(item => item.Function === "SetWIPInfo").flatMap(item => item.List1);
        const wipInfoTableBody = document.getElementById('wipInfoTableBody-<?php echo $key_div ?>');

        if (!wipInfoTableBody) {
            console.error('Table body not found');
            return;
        }

        const currentRows = Array.from(wipInfoTableBody.getElementsByTagName('tr'));
        const currentRowsMap = new Map();

        currentRows.forEach(row => {
            const identifier = JSON.stringify(Array.from(row.children).map(cell => cell.textContent));
            currentRowsMap.set(identifier, row);
        });

        if (wipInfoMessages.length > 0) {
            showLoading<?php echo $key_div ?>();

            const uniqueEntries = [];

            wipInfoMessages.forEach(info => {
                const identifier = JSON.stringify(info);
                if (!currentRowsMap.has(identifier)) {
                    const row = document.createElement('tr');
                    row.style.height = '25px';
                    row.style.maxHeight = '25px';
                    row.style.color = 'blue';

                    info.forEach(cellData => {
                        const cell = document.createElement('td');
                        cell.textContent = cellData;
                        row.appendChild(cell);
                    });

                    wipInfoTableBody.insertBefore(row, wipInfoTableBody.firstChild);
                    currentRowsMap.set(identifier, row);
                }
                uniqueEntries.push(info);
            });

            currentRows.forEach(row => {
                const identifier = JSON.stringify(Array.from(row.children).map(cell => cell.textContent));
                if (!uniqueEntries.some(entry => JSON.stringify(entry) === identifier)) {
                    row.remove();
                    currentRowsMap.delete(identifier);
                }
            });

            hideLoading<?php echo $key_div ?>();
        } else {
            wipInfoTableBody.innerHTML = '';
            hideLoading<?php echo $key_div ?>();
        }
    }

    function fetchData(data) {
        const uirtMessages = (data["<?php echo $key ?>"] || []).filter(item => item.Function === "UIRTMessage").map(item => item.List2);
        const runtimeInfoDiv = document.getElementById('runtimeInfo-<?php echo $key_div ?>');

        if (!runtimeInfoDiv) {
            console.error('Runtime info div not found');
            return;
        }

        if (uirtMessages.length > 0) {
            uirtMessages.forEach(messageList => {
                messageList.forEach(message => {
                    const existingMessages = Array.from(runtimeInfoDiv.getElementsByClassName('message'));
                    let isNewMessage = !existingMessages.some(existingMessage => existingMessage.dataset.content === message);
                    if (isNewMessage) {
                        const messageDiv = document.createElement('div');
                        messageDiv.textContent = message;
                        messageDiv.dataset.content = message;
                        messageDiv.classList.add('message');
                        if (message.includes("ERR")) {
                            messageDiv.classList.add('error');
                        }
                        runtimeInfoDiv.insertBefore(messageDiv, runtimeInfoDiv.firstChild);
                    }
                });
            });
        } else {
            const noMessagesDiv = document.createElement('div');
            noMessagesDiv.textContent = 'No UIRT Messages';
            noMessagesDiv.classList.add('no-messages');
            runtimeInfoDiv.appendChild(noMessagesDiv);
        }
    }

    function updateLPStatus(data) {
        const lpStatusArray = (data["<?php echo $key ?>"] || []).find(item => item.Function === "SetLPStatus");
        const lpStatusInput = document.getElementById('LpStatus-<?php echo $key_div ?>');

        if (!lpStatusInput) {
            console.error('LP status input not found');
            return;
        }

        if (lpStatusArray) {
            lpStatusInput.value = lpStatusArray.List1;
        }
    }

    function updateEqStatus(data) {
        const messages = (data["<?php echo $key ?>"] || []).filter(item => item.Function === "SetEquipmentStatus").map(item => item.List2[0]);
        const colors = (data["<?php echo $key ?>"] || []).filter(item => item.Function === "SetEquipmentStatus").map(item => item.List1[0]);
        const EqStatusDiv = document.getElementById('EqStatus-<?php echo $key_div ?>');

        if (!EqStatusDiv) {
            console.error('Equipment status div not found');
            return;
        }

        if (messages.length > 0) {
            EqStatusDiv.innerHTML = messages[0];
            EqStatusDiv.style.color = colors[0] === "BLUE" ? "blue" : colors[0] === "RED" ? "red" : colors[0] === "GREEN" ? "green" : "black";
        }
    }

    function updateLPButtonName(data) {
        const LpButton = (data["<?php echo $key ?>"] || []).filter(item => item.Function === "UISetLPButtonName").map(item => item.List2[0]);
        const LpColors = (data["<?php echo $key ?>"] || []).filter(item => item.Function === "UISetLPButtonName").map(item => item.List1[0]);
        const EqButtonDiv = document.getElementById('LoadButton-<?php echo $key_div ?>');

        if (!EqButtonDiv) {
            console.error('Load button div not found');
            return;
        }

        if (LpButton.length > 0) {
            EqButtonDiv.innerHTML = LpButton[0];
            EqButtonDiv.style.fontSize = "15px";
            EqButtonDiv.style.fontWeight = "bold";
            EqButtonDiv.style.backgroundColor = LpColors[0] === "RED" ? "red" : "";

            EqButtonDiv.onclick = LpButton[0] === "LOAD" ? openLoadPopoutWindow : resetData;
            EqButtonDiv.addEventListener('mouseenter', function() {
                this.style.backgroundColor = LpButton[0] === "LOAD" ? 'darkgrey' : 'red';
            });
            EqButtonDiv.addEventListener('mouseleave', function() {
                this.style.backgroundColor = LpButton[0] === "LOAD" ? '' : 'red';
            });
        }
    }

    function RemoveItem(data) {
        const RemoveData = (data["<?php echo $key ?>"] || []).filter(item => item.Function === "RemoveWIPItem").map(item => item.List1[0]);

        if (RemoveData.length > 0) {
            $.ajax({
                url: '../include/removeWIP.php',
                type: 'POST',
                data: JSON.stringify({ RemoveData: RemoveData }),
                contentType: 'application/json',
                success: function(response) {
                    showLoading<?php echo $key_div ?>();
                    console.log('PHP script executed successfully');
                },
                error: function(xhr, status, error) {
                    console.error('Failed to execute PHP script', error);
                },
                complete: function() {
                    setTimeout(hideLoading<?php echo $key_div ?>, 8000);
                }
            });
        }
    }

    function resetData() {
        checkLoggedIn(() => {
            const eqpId = "<?php echo $key ?>";
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../send_json.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log('Reset response:', xhr.responseText);
                }
            };
            const data = JSON.stringify({ Function: "ResetLP", Data: "LP1", ActiveCCM: 1, EqpId: eqpId });
            xhr.send(data);
        });
    }

}

function showLoading<?php echo $key_div ?>() {
            document.getElementById('loading-<?php echo $key_div ?>').style.display = 'block';
        }
function hideLoading<?php echo $key_div ?>() {
            document.getElementById('loading-<?php echo $key_div ?>').style.display = 'none';
        }
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

</script>