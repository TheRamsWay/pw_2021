<?php

    require_once(__DIR__ . "/tp3-helpers.php");

    var_dump(smartcurl("http://api.themoviedb.org/3/movie/550?api_key=ebb02613ce5a2ae58fde00f4db95a9c1&language=fr"));
    
    json_decode(smartcurl("http://api.themoviedb.org/3/movie/550?api_key=ebb02613ce5a2ae58fde00f4db95a9c1&language=fr") , true);

?>