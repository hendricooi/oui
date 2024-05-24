<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" media="screen" href="/oui/style.css" />
        <script src="../include/script_eq.js" type="text/javascript"></script>
    <title>Input Lot ID (Cancel Lot)</title>
</head>
<body>
    <?php 
    include('../send_request.php');
    session_start();
    
    if(isset($_POST['submit'])){
        unset($_POST['value']);
    }
    ?>

<h1 style="display: flex; justify-content: center; margin-top: 100px;">Please input your Lot ID (Cancel Lot)</h1>
    <div class = 'container' style="margin-top:50px; justify-content:center">
    <form id="loadLotForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="checkEmpty(event);">
        <div class='row' style="margin-top: 10px;">
            <div class='col-25'>
                <span>Lot ID:</span>
            </div>
            <div class='col-75'>
                <input type='text' name='lotId' placeholder='Lot Id'style="height:25px; padding-left:5px; text-transform: uppercase;">
            </div>
        </div>
        <div class="button-container">
            <button type='submit' name='submit'>OK</button>
            <button onclick="closeWindow()">Cancel</button>
        </div>
    </form>
</div>

<?php
if(isset($_POST['submit'])) {
    $eqpId = $_SESSION['eqpId'];
    $info = array(
        "Lot ID" => strtoupper($_POST['lotId']),
        "Badge ID" => $_SESSION['ID'],
        "User Name" => $_SESSION['username'],
        "Computer Name" => $_SERVER['REMOTE_ADDR']
    );
        // Call the LoadLotRquest function with the provided parameters
        $response = CancelLotRequest($info, $eqpId);
        // Handle the response if needed
        echo '<script>window.close();</script>';
}
?>
</body>
<script>

</script>
</html>