<?php

require dirname(__DIR__) . '/src/Oikology/Parser.php';
USE Oikology\Parser AS Filter;

if (FALSE === ($_FILES["file"]["error"] > 0))
{
    Filter::EMIT();
}

else
{
    header('Content-type: text/plain');
    echo "Error: " . $_FILES["file"]["error"] . "\n";
}