<?php
require_once(__DIR__ . "/tp2-helpers.php");

$arr = file(__DIR__ . "/borneswifi_EPSG4326.csv");
//var_dump($arr);
print("Nombre de lignes : " . count($arr) . "\n");

$ap = [];
foreach ($arr as $line) {
    $res = str_getcsv($line);
    print($res[3]);
    $ap[$res[0]] = [
        "lieu" => $res[1],
        "lon" => $res[2],
        "lat" => $res[3]
    ];
}
//var_dump($ap);

/*function distance($lonA, $latA, $lonB, $latB) {
    $lonA = ($lonA*pi())/180;
    $lonB = ($lonB*pi())/180;
    $latA = ($latA*pi())/180;
    $latB = ($latB*pi())/180;
    return 6371000*acos(sin($latA) * sin($latB) + cos($latA) * cos($latB) * cos($lonA - $lonB));
}*/

function distance2($lonA, $latA, $lonB, $latB) {
    $p1 = geopoint($lonA, $latA);
    $p2 = geopoint($lonB, $latB);
    return distance($p1, $p2);
}

function apProches($lon, $lat) {
    global $ap;
    $proches = [];
    //5.727342, 45.191064
    foreach ($ap as $nom => $point) {
        //print($lon . " - " . $lat . " / " . $point["lon"] . " - " . $point["lat"]);
        print(distance2($lon, $lat, $point["lon"], $point["lat"]) . "\n");
        if (distance2($lon, $lat, $point["lon"], $point["lat"]) < 200) {
            $proches[$nom] = $point;
        }
    }
    return $proches;
}

var_dump(apProches(5.72752, 45.19102));
?>