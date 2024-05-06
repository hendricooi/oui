<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" media="screen" href="/oui/style.css" />
<title>Unload Dialog</title>
</head>


<body>

<div class="row" style="display:flex; justify-content:space-between;margin: 20px 200px 20px 25px;">
    <h2>Reject Info</h2>  
    <h2> Lot Info </h2>
</div>
<div class="container-wip">

    <div class="table-container">
 <!-- Added title here -->
        <table id="unload">
            <thead>
                <tr>
                    <th>Loss Reason</th> <!-- Modified header here -->
                    <th>Description</th> <!-- Modified header here -->
                    <th>Reject Qty</th> <!-- Modified header here -->
                </tr>
            </thead>
            <tbody>
                <!-- Sample data rows -->
                <tr>
                    <td>Reason 1</td>
                    <td>Description of Reason 1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Reason 1</td>
                    <td>Description of Reason 1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Reason 1</td>
                    <td>Description of Reason 1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Reason 1</td>
                    <td>Description of Reason 1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Reason 1</td>
                    <td>Description of Reason 1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Reason 1</td>
                    <td>Description of Reason 1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Reason 1</td>
                    <td>Description of Reason 1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Reason 1</td>
                    <td>Description of Reason 1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Reason 1</td>
                    <td>Description of Reason 1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Reason 1</td>
                    <td>Description of Reason 1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Reason 1</td>
                    <td>Description of Reason 1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Reason 1</td>
                    <td>Description of Reason 1</td>
                    <td>5</td>
                </tr>

                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
    
    <div class="vertical-info">
        <div class="input-group">
            <label for="lotID">Lot ID:</label>
            <input type="text" id="lotID" name="lotID">
        </div>
        
        <div class="input-group">
            <label for="operation">Operation:</label>
            <input type="text" id="operation" name="operation">
        </div>
        
        <div class="input-group">
            <label for="lotQty">Lot Qty:</label>
            <input type="text" id="lotQty" name="lotQty">
        </div>
        
        <div class="input-group">
            <label for="device">Device:</label>
            <input type="text" id="device" name="device">
        </div>
        
        <div class="input-group">
            <label for="package">Package:</label>
            <input type="text" id="package" name="package">
        </div>
        
        <div class="input-group">
            <label for="leadCount">Lead Count:</label>
            <input type="text" id="leadCount" name="leadCount">
        </div>
        
        <div class="input-group">
            <label for="trackInQty">Track In Qty:</label>
            <input type="text" id="trackInQty" name="trackInQty">
        </div>
        
        <div class="input-group">
            <label for="goodQty">Good Qty:</label>
            <input type="text" id="goodQty" name="goodQty">
        </div>
        
        <div class="input-group">
            <label for="rejectQty">Reject Qty:</label>
            <input type="text" id="rejectQty" name="rejectQty">
        </div>
        
        <div class="input-group">
            <label for="trackOutQty">Track Out Qty:</label>
            <input type="text" id="trackOutQty" name="trackOutQty">
        </div>
        
        <div class="input-group">
            <label for="processSpec">Process Spec:</label>
            <input type="text" id="processSpec" name="processSpec">
        </div>
    </div>
</div>

<div class="reject-code">
    <label for="rejectCode">Reject Code:</label>
    <input style="padding:5px; margin-left:40px;" type="text" id="rejectCode" name="rejectCode">
</div>

<div style="margin-top:45px; margin-left:25px;">
    <h4>Others Info</h4>
    <button style="padding:5px;width:100px; height:30px; margin:10px;"id="WIPButton" onclick=openWIPWindow()>WIP Data</button>
</div>

<div class="buttons" style="padding:30px;">
    <button id="okButton" >OK</button>
    <button id="cancelButton" onclick= window.close()>Cancel</button>
</div>

<script> 
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
</script>
</body>
</html>
