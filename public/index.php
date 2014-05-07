<?php header('Content-Type: text/html; charset=utf-8'); ?>

<html>

    <head> <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script> </head>
    <body>

    <?php
    if ($_GET)
    {
        if (! empty($_GET['mods']))
        {
            echo "<h3>Issues found</h3>";
            foreach (unserialize(base64_decode($_GET['mods'])) AS $line => $issues)
            {
                echo "{$line}<br />";
                foreach($issues AS $row => $issue)
                {
                    echo ($issue === (str_replace(['\n', '\r'], '', $issue)))
                        ? "&nbsp;{$row}: " . preg_replace('/[a-z\d ]/i', '', $issue)
                        : "&nbsp;{$row}: Newline detected";

                    echo '<br />';
                }
            }
            echo '<br />';
        }
    } ?>

    <form enctype='multipart/form-data'
          action='Handler.php'
          method='post'
    >

        <input type='file' name='file' id='file'><br />
        <input type='submit' name='clean' value='Clean'>
        <input type='hidden' name='hhost' value='<?=$_SERVER['HTTP_HOST']?>' />

    </form>
    <form id="invisible_form" action="download.php" method="post" target="_blank">
        <input id="path" name="parameter" type="hidden" value="default" />
    </form>


    <?php
    if ($_GET)
    {
        echo "
            <script>
              $('#path').val('{$_GET['name']}');
              $('#invisible_form').submit();
            </script>";
    }
    ?>
    </body>
</html>