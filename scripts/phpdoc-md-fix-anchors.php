<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

if (!isset($argv[1])) {
    die("No file specified");
}

$if = fopen($argv[1], 'rb');
if (false === $if) {
    die("Cannot open '{$argv[1]}'");
}

$fixed = '';
while ($line = fgets($if)) {
    if (1 === preg_match('/^#+ ((?:Class|Interface): .*)$/', $line, $m)) {
        $fixed .= sprintf(
            "<a name=\"%s\"></a>\n",
            strtolower(str_replace([':', ' ', '\\', '(', ')'], ['', '-', '', '', ''], $m[1]))
        );
    }

    $fixed .= $line;
}

fclose($if);

file_put_contents($argv[1], $fixed);
