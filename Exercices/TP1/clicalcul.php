<?php
require_once("libcalcul.php");

if (!isset($argv[1])) {
    print("Pas de somme!\n");
} else if (!isset($argv[2])) {
    print("Pas de taux!\n");
} else if (!isset($argv[3])) {
    print("Pas de duree!\n");
} else {
    $somme = floatval($argv[1]);
    $taux = floatval($argv[2]);
    $duree = floatval($argv[3]);

    $cumul = cumul($somme, $taux, $duree);

    print("Résultat : $cumul \n");
}
?>