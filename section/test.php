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
</body>
</html>




