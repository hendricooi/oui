<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" media="screen" href="/oui/style.css" />
<title>WIP Data</title>
</head>
<?php
session_start();
$UnloadData = json_decode($_SESSION['UnloadDialog'], true);
// print_r($data);
$LotInfo = $UnloadData['List2'][0][1];
$RejectInfo = $UnloadData['List2'][1][1];
$WIPInfo = $UnloadData['List2'][2][1];

?>
<body>
    <h2>WIP Data</h2>
    <table id="WIP">
        <thead>
            <tr>
                <th>WIP Data Name</th>
                <th>WIP Data Value</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($WIPInfo as $WIP) {
                echo "<tr>";
                echo "<td>" . ($WIP[0][1]) . "</td>";
                echo "<td><input type='text' style='border:none; font-size:15px;' value='" . htmlspecialchars($WIP[1][1], ENT_QUOTES, 'UTF-8') . "'></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="button-container">
            <button type='submit' name='submit' onclick="closeWindow()">OK</button>
            <button onclick="closeWindow()">Cancel</button>
        </div>
</body>
</html>

<script>
    function closeWindow() {
    // Close the pop-out window
    window.close();
}
</script>