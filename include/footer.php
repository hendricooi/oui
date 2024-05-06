<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <footer>
    <p class="footer" style="color:black; margin-bottom:20px;">
    STP: <?php echo "" ?> &nbsp;
    PC Name: <?php echo htmlspecialchars(gethostname()); ?> &nbsp;
    IP Address: <?php echo htmlspecialchars($_SERVER['REMOTE_ADDR']); ?> &nbsp;
    Current Time:<span id="datetime"></span></p>
    <div>
        <p class="footer">Copyright @2024 | Designed by <a href="https://www.semi-tech.com/">SEMI Integration Sdn Bhd.</a> All Rights Reserved</p>
    </div>
    </footer>
</body>
</html>

<script>
        // Function to update the time and date
        function updateTimeAndDate() {
            var currentDate = new Date();
            var dateTime = currentDate.toLocaleTimeString() + " " + currentDate.toLocaleDateString();
            document.getElementById('datetime').innerHTML = dateTime;
        }

        // Refresh the time and date every second
        setInterval(updateTimeAndDate, 1000);
    </script>