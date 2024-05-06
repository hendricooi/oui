<?php
$buttonText = "Log In";
if (isset($_SESSION['username'])) {
    // If the user is logged in, display "Log Out"
    $buttonText = "Log Out";
    // Provide the logout action in the button's onclick event
    $buttonAction = "logout()";
} else {
    // If the user is not logged in, display "Log In"
    // Provide the login form opening action in the button's onclick event
    $buttonAction = "openForm()";
}
?>


<button class='open-button' onclick='<?php echo $buttonAction; ?>'><?php echo $buttonText; ?></button>

<div class='form-popup' id='myForm'>
    <form action='/oui/action_page.php' class='form-container' style='padding:5px;'>
    <h1>Login</h1>
    <label for='ID'><b>Badge ID</b></label>
    <input type='text' placeholder='Enter Badge ID' id='ID' name='ID' required>

    <label for='username'><b>Username</b></label>
    <input type='text' placeholder='Enter Username' id='username' name='username'required>

    <label for='psw'><b>Password</b></label>
    <input type='password' placeholder='Enter Password' id='psw' name='psw' required>

    <button type='submit' class='btn'>Login</button>
    <button type='button' class='btn cancel' onclick='closeForm()'>Close</button>
    </form>
</div>

<?php
    if (isset($_SESSION['error_message'])) {
        // Retrieve the error message
        $errorMessage = $_SESSION['error_message'];
        // Display the error message using JavaScript
        echo "<script>alert('$errorMessage');</script>";
        // Clear the session variable after displaying the message
        unset($_SESSION['error_message']);
    }
    ?>
