<?php
require_once(__DIR__ . "/tp2-helpers.php");

function apProchesN($ap, $lon, $lat, $n) {
    $proches = [];
    $dist = [];
    foreach ($ap as $nom => $point) {
        $p1 = geopoint($lon, $lat);
        $p2 = geopoint($point["lon"], $point["lat"]);
        $distance = distance($p1, $p2);
        if ($distance < 200) {
            $proches[$nom] = $point;
            $proches[$nom]["dist"] = $distance;
            array_push($dist, $distance);
        }
    }
    array_multisort($dist, $proches);
    return array_slice($proches, 0, $n);
}

function pointAdresse($lon, $lat) {
    $req = curl_init("https://api-adresse.data.gouv.fr/reverse/?lon=$lon&lat=$lat");
    curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($req);
    curl_close($req);
    $json = json_decode($res);
    $adr = count($json->features) > 0 ? $json->features[0]->properties->label : "Adresse introuvable";
    return $adr;
}

header("Content-Type: application/json");
if (empty($_GET["lon"]) || empty($_GET["lat"])) {
    print(json_encode(["ap" => []]));
} else {
    $top = empty($_GET["top"]) ? 5 : $_GET["top"];
    $lon = $_GET["lon"];
    $lat = $_GET["lat"];

    $ap = [];
    $json = json_decode(file_get_contents(__DIR__ . "/borneswifi_EPSG4326.json"));
    foreach ($json->features as $point) {
        $ap[$point->properties->AP_ANTENNE1] = [
            "lieu" => $point->properties->{"Antenne 1"},
            "lon" => $point->geometry->coordinates[0],
            "lat" => $point->geometry->coordinates[1]
        ];
    }

    $proches = apProchesN($ap, $lon, $lat, $top);
    foreach ($proches as $point) {
        $point["adr"] = pointAdresse($point["lon"], $point["lat"]);
    }

    print(json_encode(["ap" => $proches]));
}
?>