<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat du cumul</title>
</head>
<body>
    <h1>Résultat</h1>
    <?php
    require_once("libcalcul.php");

    if (!isset($_REQUEST["somme"])) {
        print("Pas de somme! <br>");
    } else if (!isset($_REQUEST["taux"])) {
        print("Pas de taux! <br>");
    } else if (!isset($_REQUEST["duree"])) {
        print("Pas de duree! <br>");
    } else {
        $somme = $_REQUEST["somme"];
        $taux = $_REQUEST["taux"];
        $duree = $_REQUEST["duree"];

        $cumul = cumul($somme, $taux, $duree);

        $method = (empty($_GET) ? "post" : "get");
        print("Méthode : $method <br>");
        print("Résultat : $cumul <br>");
    }
    ?>
</body>
</html>