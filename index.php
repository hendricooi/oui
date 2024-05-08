<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <script src="./include/script_jquery.js" type="text/javascript"></script>


    <title>AMD OUI : Penang OTA </title>
</head>
<?php
session_start();
include("include/global.php");
include($path . "send_request.php");
include($path . "class/Section.class.php");
?>

<div id="navbar-animmenu">
        <ul class="show-dropdown main-navbar">
            <div class="hori-selector"><div class="left"></div><div class="right"></div></div>
            <li class="active">
                <a href=# id="dashboardLink"></i>Dashboard</a>
            </li>
            <li>
            <a href="#" id="addressBookLink"></i>Sample #1</a>
            </li>
            <li>
                <a href="javascript:void(0);"></i>Sample $2</a>
            </li>
            <li>
                <a href="javascript:void(0);"></i>Sample #3</a>
            </li>
            <li>
                <a href="javascript:void(0);"></i>Sample #4</a>
            </li>
            
            <img src="/oui/img/logo.jpg" alt="logo site" id="logo_site"/>
            
        </ul>
    </div>
    <div id="dashboardContent" style="display: block;">
        <h2 style="text-align: center; padding-top: 100px;padding-bottom: 20px;">Welcome to Shop Floor (OTA) Dashboard!</h2>
        <p style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">

<?php
    $replacedSection= str_replace(['[', ']', '"'], '', $response_section);
    $array = explode(',',$replacedSection);
    $sections_count = count($array);
    $buttons_per_row = 4;
    $rows = ceil($sections_count / $buttons_per_row);
foreach ($array as $index => $arrays) {
    $trimmed_string = trim($arrays);
    echo '<button style="width:100%; height:50px; " onclick="cellController(\''.$trimmed_string.'\')">'. $trimmed_string . '</button>';
}

    ?>
    </p>
    </div>
    <div id="addressBookContent" style="display: none;">
    <?php
        echo  $_SESSION['eqpId'];;
    ?>
    </div>

<?php 
include($path .  'include\footer.php');
?>
<script src="./include/script.js" type="text/javascript"></script>
