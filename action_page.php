<?php
include("include/global.php");
include($path . "class/Login.class.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["ID"];
    $username = $_GET['username'];
    $password = $_GET['psw'];

    $loginSystem = new Login($id,$username, $password);
    $returnTo = $_SESSION['return_to'];
    unset($_SESSION['return_to']); // Clear the stored return URL
    if ($loginSystem->authenticate()) {
        // Authentication successful, redirect to original page
        if (isset($_SESSION['username'])) {
                header("Location: $returnTo");
                exit;
            }
        }
        else{
            $_SESSION['error_message'] = "Wrong ID/Password";
            header("Location: $returnTo");
        }
    }

?>
