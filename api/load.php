<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Runtime Info Container</title>
<style>
    /* CSS styles for the runtime info container */
    .runtime-info {
        width: 98%;
        height: 130px;
        background-color: lightgray;
        margin-top: 10px;
        padding: 10px;
        border-radius: 10px;
        overflow-y: auto; /* Enable vertical scrollbar if content exceeds height */
    }
</style>
</head>
<body>

<div class="runtime-info">
    <h2>Run Time Info</h2>
    <?php
    // Your PHP code to fetch and display runtime information goes here
    // Example data:
    $runtimeInfo = [
        "Message 1",
        "Message 2",
        "Message 3",
        "Message 4",
        "Message 5",
        "Message 6",
        "Message 7",
        "Message 8",
        "Message 9",
        "Message 10",
    ];

    // Display each runtime information message
    foreach ($runtimeInfo as $message) {
        echo "<div>$message</div>";
    }
    ?>
</div>

</body>
</html>