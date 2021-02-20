<?php

    $lon = 5.736146;
    $lat = 45.187265;
    $top = 5;
    if (isset($_GET["lon"]) && isset($_GET["lat"]) && isset($_GET["top"])) {
        $lon = $_GET["lon"];
        $lat = $_GET["lat"];
        $top = $_GET["top"];
        $url = $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]);
        $list = json_decode(file_get_contents("http://$url/ap_ws.php?lon=$lon&lat=$lat&top=$top"), true);
    }

?>
<html>
    <head>
        <title>Formulaire exemple</title>
	    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <form method="get" action="<?= $_SERVER["PHP_SELF"] ?>">
            <label for="top">Nombre de résultats à afficher: </label>
            <input id="top" name="top" type="number" value="<?= $top ?>" />
            <br>
            <label for="lon">Longitude: </label>
            <input id="lon" name="lon" type="number" step="0.000001" value="<?= $lon ?>"/>
            <label for="lat">Latitude: </label>
            <input id="lat" name="lat" type="number" step="0.000001" value="<?= $lat ?>"/>
            <br>
            <input type="submit" />
            <?php if (isset($list)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Point d'accès</th>
                        <th>Adresse</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                        <th>Distance</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($list["ap"] as $apName => $ap): ?>
                    <tr>
                        <th><?= $apName ?></th>
                        <td><?= $ap["lieu"] ?></td>
                        <td><?= $ap["lon"] ?></td>
                        <td><?= $ap["lat"] ?></td>
                        <td><?= $ap["dist"] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </form>
    </body>
</html>
