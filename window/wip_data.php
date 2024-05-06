<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" media="screen" href="/oui/style.css" />
<title>WIP Data</title>
</head>

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
            <tr>
                <td>Item 1</td>
                <td>Value 1</td>
            </tr>
            <tr>
                <td>Item 2</td>
                <td>Value 2</td>
            </tr>
            <tr>
                <td>Item 3</td>
                <td>Value 3</td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
    <div class="button-container">
            <button type='submit' name='submit'>Ok</button>
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