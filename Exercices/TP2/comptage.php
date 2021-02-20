<?php
require_once(__DIR__ . "/tp2-helpers.php");

$arr = file(__DIR__ . "/borneswifi_EPSG4326.csv");

//print("Nombre de lignes : " . count($arr) . "\n");

$ap = [];
foreach ($arr as $line) {
    $res = str_getcsv($line);
    $ap[$res[0]] = [
        "lieu" => $res[1],
        "lon" => $res[2],
        "lat" => $res[3],
        "adr" => pointAdresse($res[2], $res[3])
    ];
}


/*function distance($lonA, $latA, $lonB, $latB) {
    $lonA = ($lonA*pi())/180;
    $lonB = ($lonB*pi())/180;
    $latA = ($latA*pi())/180;
    $latB = ($latB*pi())/180;
    return 6371000*acos(sin($latA) * sin($latB) + cos($latA) * cos($latB) * cos($lonA - $lonB));
}*/

function pointAdresse($lon, $lat) {
    $req = curl_init("https://api-adresse.data.gouv.fr/reverse/?lon=$lon&lat=$lat");
    curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($req);
    curl_close($req);
    $json = json_decode($res);
    $adr = count($json->features) > 0 ? $json->features[0]->properties->label : "Adresse introuvable";
    return $adr;
    
}

function distance2($lonA, $latA, $lonB, $latB) {
    $p1 = geopoint($lonA, $latA);
    $p2 = geopoint($lonB, $latB);
    return distance($p1, $p2);
}

function apProches($lon, $lat) {
    global $ap;
    $proches = [];
    foreach ($ap as $nom => $point) {
        $distance = distance2($lon, $lat, $point["lon"], $point["lat"]);
        if ($distance < 200) {
            $proches[$nom] = $point;
            $proches[$nom]["dist"] = $distance;
        }
    }
    return $proches;
}

function apProchesN($lon, $lat, $n) {
    $proches = apProches($lon, $lat);
    $dist = array_column($proches, "dist");
    array_multisort($dist, $proches);
    return array_slice($proches, 0, $n);
}

$nb = ($argc == 2 ? intval($argv[1]) : 5);
var_dump(apProchesN(5.72752, 45.19102, $nb));

?>