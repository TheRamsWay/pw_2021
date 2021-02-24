<?php

    $lon = 5.736146;
    $lat = 45.187265;
    $top = 5;
    if (isset($_GET["lon"]) && isset($_GET["lat"])) {
        $lon = $_GET["lon"];
        $lat = $_GET["lat"];
        $top = $_GET["top"];
        $isp = $_GET["isp"];
        $url = $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]);
        $list = json_decode(file_get_contents("http://$url/gsm_ws.php?lon=$lon&lat=$lat&top=$top&isp=$isp"), true);
    }

?>
<html>
    <head>
        <title>Antennes GSM</title>
	    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <form method="get" action="<?= $_SERVER["PHP_SELF"] ?>">
            <label for="top">Nombre de résultats à afficher: </label>
            <input id="top" name="top" type="number" value="<?= $top ?>" />
            <br>
            <label for="lon">Longitude: </label>
            <input id="lon" name="lon" type="number" step="0.000001" required value="<?= $lon ?>"/>
            <label for="lat">Latitude: </label>
            <input id="lat" name="lat" type="number" step="0.000001" required value="<?= $lat ?>"/>
            <br>
            <label for="isp">Opérateur: </label>
            <select name="isp" id="isp" required>
                <option value="ORA" <?= $isp == "ORA" ? "selected" : "" ?> >Orange</option>
                <option value="BYG" <?= $isp == "BYG" ? "selected" : "" ?> >Bouygues</option>
                <option value="FREE" <?= $isp == "FREE" ? "selected" : "" ?> >Free</option>
                <option value="SFR" <?= $isp == "SFR" ? "selected" : "" ?> >SFR</option>
                <option value="ANY" <?= !isset($isp) || $isp == "ANY" ? "selected" : "" ?> >Tous</option>
            </select>
            <br>
            <input type="submit" />
            <?php if (isset($list)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Adresse</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                        <th>Distance</th>
                        <?php if ($isp == "ANY"): ?>
                        <th>Opérateur</th>
                        <?php endif; ?>
                        <th>2G</th>
                        <th>3G</th>
                        <th>4G</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($list["ant"] as $id => $ant): ?>
                    <tr>
                        <td><?= $ant["adr"] ?></td>
                        <td><?= $ant["lon"] ?></td>
                        <td><?= $ant["lat"] ?></td>
                        <td><?= $ant["dist"] ?></td>
                        <?php if ($isp == "ANY"): ?>
                        <td><?= $ant["isp"] ?></td>
                        <?php endif; ?>
                        <td><?= $ant["is_2g"] ? "X" : "" ?></td>
                        <td><?= $ant["is_3g"] ? "X" : "" ?></td>
                        <td><?= $ant["is_4g"] ? "X" : "" ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </form>
    </body>
</html>
