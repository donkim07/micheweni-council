<?php
// Simple debug file
?>
<!DOCTYPE html>
<html>
<head>
    <title>Debug jQuery</title>
</head>
<body>
    <h1>jQuery Debug</h1>
    <div id="status"></div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        if (typeof jQuery != 'undefined') {
            document.getElementById('status').innerHTML = '<div style="color: green;">jQuery ' + jQuery.fn.jquery + ' is loaded</div>';
        } else {
            document.getElementById('status').innerHTML = '<div style="color: red;">jQuery is NOT loaded</div>';
        }
    </script>
</body>
</html> 