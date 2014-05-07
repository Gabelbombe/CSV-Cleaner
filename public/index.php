<html>
    <body>

    <?php
    if ($_POST)
    {
/*
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$csv->file->base}-filter.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
*/
    ?>



    <?php
    } else {

    ?>

    <form enctype='multipart/form-data'
          action='Handler.php'
          method='post'
    >

        <input type='file' name='file' id='file'><br />
        <input type='submit' name='clean' value='Clean'>
        <input type='hidden' name='hhost' value='<?=$_SERVER['HTTP_HOST']?>' />

    </form>

    </body>
</html>

<?php } ?>