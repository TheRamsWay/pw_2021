<?php

for ($i = 1; $i < $argc; $i++) {
    $codepoint = IntlChar::ord(mb_substr($argv[$i], 0, 1));
    //print("U+" . dechex($codepoint) . "\n");
    //print($codepoint . "\n");
    print("U+" . sprintf("%04X", $codepoint) . "\n");
}

?>