<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" media="screen" href="/oui/style.css" />
        <script src="../include/script_eq.js" type="text/javascript"></script>
    <title>Input Lot ID</title>
</head>
<body>
    <?php 
    include('../send_request.php');
    session_start();
    
    if(isset($_POST['submit'])){
        unset($_POST['value']);
    }
    ?>

<h1 style="display: flex; justify-content: center; margin-top: 100px;">Please input your Lot ID</h1>
    <div class = 'container' style="margin-top:50px; justify-content:center">
    <form id="loadLotForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="checkEmpty(event);">
        <div class='row' style="margin-top: 10px;">
            <div class='col-25'>
                <span>Lot ID:</span>
            </div>
            <div class='col-75'>
                <input type='text' name='lotId' placeholder='Lot Id'style="height:25px; padding-left:5px;">
            </div>
        </div>
        <div class="button-container">
            <button type='submit' name='submit'>Ok</button>
            <button onclick="closeWindow()">Cancel</button>
        </div>
    </form>
</div>

<?php
if(isset($_POST['submit'])) {
    $function = "LoadLotInputOK";
    $eqpId = $_SESSION['eqpId'];
    $data = array(
        "LP1" => $_POST['lotId'],
        "Computer Name" => $_SERVER['REMOTE_ADDR'],
        "Badge ID" => $_SESSION['ID'],
        "User Name" => $_SESSION['username']
    );
        // Call the LoadLotRquest function with the provided parameters
        $response = LotRequest($function,$data, $eqpId);
        // Handle the response if needed
        echo $response;
        $responseArray = json_decode($response, true);
        echo ($responseArray['Value'] == 0) ? 'true' : 'false';
    
}
?>
</body>
<script>
    function closeWindow() {
    // Close the pop-out window
    window.close();
}
function checkEmpty(event) {
    // Check if the event target is the submit button
    if (event.submitter && event.submitter.name === 'submit') {
        // Get the value of the lotId input field
        var lotId = document.querySelector('input[name="lotId"]').value;

        // Check if the value is empty
        if (lotId.trim() === '') {
            // Display an alert message
            alert("Please fill in the Lot ID.");
            // Prevent the form from submitting
            event.preventDefault();
            return false;
        }
    }
    // If the event target is not the submit button or the field is not empty, allow the form to submit
    return true;
}
</script>
</html>