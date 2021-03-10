<?php

function getMovie($id, $lang) {
    return json_decode(tmdbget("movie/$id", ["language" => $lang]), true);
}

function langFlag($lang) {
    switch ($lang) {
        case "fr":
            return "🇫🇷";
        case "en":
            return "🇬🇧";
        case "ja":
            return "🇯🇵";
        case "es":
            return "🇪🇸";
        case "ko":
            return "🇰🇷";
        case "pt":
            return "🇵🇹";
        default:
            return "VO";
    }
}

?>