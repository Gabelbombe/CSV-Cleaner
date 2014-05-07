<?php

if (file_exists($_POST['parameter']))
{
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($_POST['parameter']));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($_POST['parameter']));
    ob_clean();
    flush();
    readfile($_POST['parameter']);
    exit;
}
?>
<html>
<head>
    <script>
        function loaded() {
            alert("Beep!");
            window.setTimeout(CloseMe, 500);
        }

        function CloseMe() {
            window.close();
        }
    </script>
</head>
<body onLoad="loaded()" />
</html>