<?php

header('Content-type: text/plain');
define('MARKER', ':::MARKER:::');

if (FALSE === ($_FILES["file"]["error"] > 0))
{

    function outputCSV($data)
    {
        $outputBuffer = fopen("php://output", 'w');
        foreach($data AS $val) fputcsv($outputBuffer, $val);
        fclose($outputBuffer);
    }



    $trim = [];
    foreach(array_map('str_getcsv', file($_FILES['file']['tmp_name'])) AS $inc => $subarray)
    {
        foreach($subarray AS $value) $trim[$inc][] = str_replace(["\n", "\r", '\n', '\r'], '', fixWordBullshit($value));
    }

    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename={$_FILES["file"]["name"]}-CLEAN.csv");
    header("Pragma: no-cache");
    header("Expires: 0");

    outputCSV($trim);

} else {
    echo "Error:     " . $_FILES["file"]["error"] . "\n";
}