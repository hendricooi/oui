<?php
include("include/global.php");
include($path .'class\Login.class.php'); // Include the Login class definition
// Check if the user is logged in
$isLoggedIn = Login::isLoggedIn();

// Return the login status as a response
echo $isLoggedIn ? 'true' : 'false';
?>