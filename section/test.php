<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" media="screen" href="/oui/style.css" />

    <title>EAP UI </title>
</head>
<body>
<?php
include("..\include\global.php");
include($path . 'send_request.php');
include($path .  'include\header.php');
include($path .  'class\section.class.php');
include($path .  'class\Login.class.php');
$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];

    $Test = array_search($Test, get_defined_vars());
    $response=makeCurlRequest("RequestEquipmentListArea",$Test);
    $sideEq= Section::convertJsonToListView($Test,$response);

echo"<div class='container'>";
    //Side equipment list
    
    echo'<div class="sideEq">';
        echo  $sideEq;
    echo '</div>';


    //Equipment information
    echo "<div class='content'>";
        $display=Section::displayEquipmentInfo($Test,$response);
        echo $display;
    //close display div tag, display, content, container
    echo "</div>
    </div>
</div>";

include($path .  'include\footer.php');
?>

<script src="../include/script_eq.js" type="text/javascript"></script>
<script src="../include/script_jquery.js" type="text/javascript"></script>
<script>

let idleTime = 0;
const idleLimit = 5 * 60 * 1000; // 5 minutes

// Reset the idle timer on user activity
function resetIdleTimer() {
    idleTime = 0;
}

function checkIdleTime() {
    idleTime += 1000;
    console.log(idleTime);
    if (idleTime >= idleLimit) {
        alert('Your session has timed out due to inactivity.');
        // Redirect to the main page and destroy the session
        window.location.href = '../logout_main.php';
    }
}

// Increment the idle timer every second
setInterval(checkIdleTime, 1000);

// Reset the idle timer on various user events
window.onload = resetIdleTimer;
window.onmousemove = resetIdleTimer;
window.onmousedown = resetIdleTimer;
window.ontouchstart = resetIdleTimer;
window.onclick = resetIdleTimer;
window.onkeypress = resetIdleTimer;
window.addEventListener('scroll', resetIdleTimer, true);

</script>
</body>
</html>




