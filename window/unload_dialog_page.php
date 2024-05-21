<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" media="screen" href="/oui/style.css" />
<title>Unload Dialog</title>
</head>
<?php 
    session_start();
    include('../send_request.php');

    $UnloadData = json_decode($_SESSION['UnloadDialog'], true);
    $LotInfo = $UnloadData['List2'][0][1];
    $RejectInfo = $UnloadData['List2'][1][1];
    $WIPInfo = $UnloadData['List2'][2][1];
?>

<body>

<div class="row" style="display:flex; justify-content:space-between;margin: 20px 200px 20px 25px;">
    <h2>Reject Info</h2>  
    <h2> Lot Info </h2>
</div>
<form id="UnloadDialogForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="container-wip">
        <div class="table-container">
            <table id="unload">
                <thead>
                    <tr>
                        <th style="width:100px;">Loss Reason</th>
                        <th>Description</th>
                        <th>Reject Qty</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($RejectInfo as $reject) {
                    echo "<tr>";
                    echo "<td>" . ($reject[0][1]) . "</td>";
                    echo "<td>" . ($reject[1][1]) . "</td>";
                    echo '<td><input id="Reject'.$reject[0][1].'" type="number" min="0" style="border:none; font-size:18px; background-color: transparent;" name="reject_qty[]" oninput="calculateTotal(); collectRejects();" value="0"></td>';
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        
        <div class="vertical-info">
            <?php foreach ($LotInfo as $item): ?>
                <div class="input-group">
                    <label><?= $item[0] ?>:</label>
                    <input type="text" id="<?= $item[0] ?>" style="font-size:15px;" value="<?= $item[1] ?>" readonly>
                </div>
            <?php endforeach; ?>
            <div class="input-group">
                <label>Reject Qty:</label>
                <input id="rejectqty" type="text" style="font-size:15px;" value="0" readonly>
            </div>
        </div>
    </div>

<input type="hidden" id="trackOutQtyHidden" name="trackOutQtyHidden">
<!-- Hidden input field for reject values -->
<input type="hidden" id="rejectValuesHidden" name="rejectValuesHidden">

    <div class="reject-code">
        <label for="rejectCode">Reject Code:</label>
        <input style="padding:5px; margin-left:40px;" type="text" id="rejectCode" name="rejectCode">
    </div>

    <div style="margin-top:45px; margin-left:25px;">
        <h4>Others Info</h4>
        <button type="button" style="padding:5px;width:100px; height:30px; margin:10px;" id="WIPButton" onclick="openWIPWindow()">WIP Data</button>
    </div>

    <div class="buttons" style="padding:30px;">
        <button id="okButton" name="submit" type="submit">OK</button>
        <button type="button" id="cancelButton" onclick="window.close()">Cancel</button>
    </div>
</form>

<?php
if(isset($_POST['submit'])) {
    if (isset($_POST['trackOutQtyHidden']) && !empty($_POST['trackOutQtyHidden'])) {
        $trackOutQty = intval($_POST['trackOutQtyHidden']);
        $rejectValuesJSON = $_POST['rejectValuesHidden'];
        $rejectValues = json_decode($rejectValuesJSON, true);
        $data = array(
            "Lot ID" => $LotInfo[2][1],
            "Computer Name" => $_SERVER['REMOTE_ADDR'],
            "User ID" => $_SESSION['username'],
            "Service Name"=>"TrackOutLot"
        );
        $wipdata = array(
            "LINE_NO" => $WIPInfo[0][1][1],
            "MACHINE_NO" => $WIPInfo[1][1][1],
            "PROCESSED_BY" => $WIPInfo[2][1][1],
            "ANGSUK" => $WIPInfo[3][1][1]
        );
        $eqpId = $_SESSION['eqpId'];
        $response = UnloadWIPData($data, $wipdata, $eqpId);
        //get response then proceed with Unload Lot Data
        $responseArray = json_decode($response, true);
        if ($responseArray['Value'] == 0) {
            $unloaddata = array(
                "Lot ID" => $LotInfo[2][1],
                "TrackOut Qty" => $trackOutQty,
                "Computer Name" => $_SERVER['REMOTE_ADDR'],
                "Badge ID" => $_SESSION['ID'],
                "User Name" => $_SESSION['username'] 
            );
            // $rejectinfo
            $unloadDataResponse = UnloadLotData($unloaddata, $rejectValues, $eqpId);
        } else {
            echo "Error in updating WIP data";
        }
    } else {
        echo "TrackOutQtyHidden is not set or is empty.";
    }
}
?>
<script> 
function collectRejects() {
    // Get all inputs with id starting with "Reject"
    const rejectInputs = document.querySelectorAll('input[id^="Reject"]');
    const rejectValues = [];

    // Loop through the inputs and get their values if they are greater than 0
    rejectInputs.forEach(input => {
        const value = input.value;
        if (value > 0) {
            // Remove "Reject" from input id
            const code = input.id.replace("Reject", "");
            // Push an object with the desired structure to the array
            rejectValues.push({
                Data: {
                    Code: code,
                    Qty: value
                }
            });
        }
    });
    // Convert the JavaScript array to a JSON string
    const rejectValuesJSON = JSON.stringify(rejectValues, null, 4);

    // Set the value of the hidden input field
    document.getElementById('rejectValuesHidden').value = rejectValuesJSON;
    // Display the results (for testing purposes, you can process as needed)
    console.log(rejectValuesJSON);
}

function openWIPWindow() {

    var url = "wip_data.php";

    // Define the dimensions and position of the pop-out window
    var width = 600;
    var height = 400;
    var left = (screen.width - width) / 2;
    var top = (screen.height - height) / 2;

    // Open the pop-out window with specified dimensions and position
    window.open(url, "popoutWindow", "width=" + width + ", height=" + height + ", left=" + left + ", top=" + top);
}
let initialTrackOutQty = parseFloat(document.getElementById('Track Out Qty').value);
function calculateTotal() {
    let total = 0;
    let trackOutQty = initialTrackOutQty;    
    document.querySelectorAll('input[id^="Reject"]').forEach(function(element) {
        let value = element.value.trim();
        if(value === "" || value === null){
            value = 0;
        }
        let rejectQty = parseFloat(value);
        if (isNaN(rejectQty)) {
            alert("Please enter a numerical value for the reject quantity.");
            exit;// Stop further execution of the loop
        }

        if (total > trackOutQty) {
            alert("Reject Quantity <" + total + "> is more than Track Out Qty <" + trackOutQty + ">");
            exit;  // Skip adding this reject quantity to the total
        }
        else{
            total += rejectQty;
        }
    });

    document.getElementById('rejectqty').value = total;
    updateTrackOutQty(trackOutQty);
}
function updateTrackOutQty(trackOutQty) {
    const rejectQty = parseFloat(document.getElementById('rejectqty').value) || 0;
    document.getElementById('Track Out Qty').value = Math.max(trackOutQty - rejectQty, 0);
}

function searchData() {
    var searchValue = document.getElementById('rejectCode').value;
    var table = document.querySelector('tbody');
    var rows = table.getElementsByTagName('tr');

    for (var i = 0; i < rows.length; i++) { // Start from 1 to skip the header row
        var reject = rows[i].getElementsByTagName('td')[0].innerText;
        if (reject.toLowerCase().includes(searchValue.toLowerCase()) ) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}
function setupInputListeners() {
    document.querySelectorAll('input[id^="Reject"]').forEach(function(element) {
        element.addEventListener('focus', function() {
            if (element.value.trim() === "0") {
                element.value = "";
            }
        });

        element.addEventListener('blur', function() {
            if (element.value.trim() === "") {
                element.value = "0";
            }
        });
    });
}
function passTrackOutQty() {
    let trackOutQty = document.getElementById('Track Out Qty').value;
    document.getElementById('trackOutQtyHidden').value = trackOutQty;
}

document.getElementById('UnloadDialogForm').addEventListener('submit', function(event) {
    collectRejects();
    passTrackOutQty();
});

document.getElementById('rejectCode').addEventListener('input', searchData);
setupInputListeners();
</script>
</body>
</html>
