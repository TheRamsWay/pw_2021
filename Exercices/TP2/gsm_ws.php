<?php
require_once(__DIR__ . "/tp2-helpers.php");

function antProchesN($ant, $lon, $lat, $isp, $n) {
    $proches = [];
    $dist = [];
    $i = 0;
    while ($i < $n && $i < count($ant)) {
        $id = array_keys($ant)[$i];
        $point = $ant[$id];
        $p1 = geopoint($lon, $lat);
        $p2 = geopoint($point["lon"], $point["lat"]);
        $distance = distance($p1, $p2);
        if ($distance < 10000 && ($isp == "ANY" || $isp == $point["isp"])) {
            $proches[$id] = $point;
            $proches[$id]["dist"] = $distance;
            array_push($dist, $distance);
        }
        $i++;
    }
    array_multisort($dist, $proches);
    return $proches;
}

header("Content-Type: application/json");
if (empty($_GET["lon"]) || empty($_GET["lat"])) {
    print(json_encode(["ant" => []]));
} else {
    $top = empty($_GET["top"]) ? 5 : $_GET["top"];
    $isp = empty($_GET["isp"]) ? "ANY" : $_GET["isp"];
    $lon = $_GET["lon"];
    $lat = $_GET["lat"];

    $ant = [];
    $json = json_decode(file_get_contents(__DIR__ . "/DSPE_ANT_GSM_EPSG4326.json"));
    foreach ($json->features as $point) {
        $ant["ant_" . $point->properties->ANT_ID] = [
            "adr" => $point->properties->ANT_ADRES_LIBEL,
            "lon" => $point->geometry->coordinates[0],
            "lat" => $point->geometry->coordinates[1],
            "isp" => $point->properties->OPERATEUR,
            "is_2g" => $point->properties->ANT_2G == "OUI",
            "is_3g" => $point->properties->ANT_3G == "OUI",
            "is_4g" => $point->properties->ANT_4G == "OUI",
        ];
    }

    $proches = antProchesN($ant, $lon, $lat, $isp, $top);

    print(json_encode(["ant" => $proches]));
}
?>