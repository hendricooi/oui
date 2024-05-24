<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" media="screen" href="/oui/style.css" />
        <script src="../include/script_eq.js" type="text/javascript"></script>
    <title>Unload Lot ID</title>
</head>
<body>
    <?php 
    include('../send_request.php');
    session_start();
    
    if(isset($_POST['submit'])){
        unset($_POST['value']);
    }
    ?>

<h1 style="display: flex; justify-content: center; margin-top: 100px;">Please input your Lot ID (Unload)</h1>
    <div class = 'container' style="margin-top:50px; justify-content:center">
    <form id="loadLotForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="checkEmpty(event);">
        <div class='row' style="margin-top: 10px;">
            <div class='col-25' style='width:40%;'>
                <span>Lot ID:</span>
            </div>
            <div class='col-75' style='width:40%'>
                <input type='text' name='lotId' placeholder='Lot Id'style="height:25px; padding-left:5px; text-transform: uppercase;">
            </div>
        </div>
        <div class='row' style="margin-top: 50px;">
            <div class='col-25' style='width:40%; font-size: 18px; margin-top:13px;'>
                <span>TrackOut Qty: </span>
            </div>
            <div class='col-75' style="width:60%">
                <input style="width:35%; height:25px; padding-left:5px; margin-right:10px;" type='text' name='track' disabled>
                <input  style='margin-top:10px;' type="checkbox" name="checkBox"> <a  style="font-size:12px;">Partial Qty TrackOut </a></input>

            </div>
        </div>

        <div class="button-container row" style="display:block;">
            <button type='submit' name='submit' >OK</button>
            <button onclick="closeWindow()">Cancel</button>
        </div>
    </form>
</div>

<script>
function UnloadDialogWindow(){
var url = "unload_dialog_page.php";

// Define the dimensions and position of the pop-out window
var width = 900;
var height = 700;
var left = (screen.width - width) / 2;
var top = (screen.height - height) / 2;
console.log("abc");
// Open the pop-out window with specified dimensions and position
window.open(url, "newpopoutWindow", "width=" + width + ", height=" + height + ", left=" + left + ", top=" + top);
window.close();
}

</script>
<?php
if(isset($_POST['submit'])) {
    $function = "UnloadLot";
    $eqpId = $_SESSION['eqpId'];
    $info = array(
        "Lot ID" => strtoupper($_POST['lotId']),
        "TrackOut Qty" => "",
        "Badge ID" => $_SESSION['ID'],
        "User Name" => $_SESSION['username'],
        "Service Name" => "TrackOutLot"
    );
        // Call the LoadLotRquest function with the provided parameters
        $response = UnloadLotRequestAfter($function,$info,$eqpId);
        $responseArray = json_decode($response, true);
        if ($responseArray['Value'] == 0) {
        // Handle the response if needed
        $_SESSION['UnloadDialog'] = $response;
        echo " <script> UnloadDialogWindow(); </script>";
        }
        else{
            echo '<script>alert("The Lot is NOT in WIP list. Please enter another Lot.")</script>'; 
        }
}
?>
</body>

</html>