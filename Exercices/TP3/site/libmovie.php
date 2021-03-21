<?php

/**
 * TMDB query function
 * @param string $urlcomponent (after the prefix)
 * @param array (associative) GET parameters (ex. ['language' => 'fr'])
 * @return string $content
**/
function tmdbget($urlcomponent, $params=null) {
    $apikey = 'ebb02613ce5a2ae58fde00f4db95a9c1';
    $apiprefix = 'http://api.themoviedb.org/3/';  //3rd API version
	
	$targeturl = $apiprefix . $urlcomponent . '?api_key=' . $apikey;
    $targeturl .= (isset($params) ? '&' . http_build_query($params) : '');
    list($content, $info) = smartcurl($targeturl);

    return $content;
}

/**
 * curl wrapper
 * @param string $url
 * @return string $content
 **/  
function smartcurl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "php-libcurl");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    $rawcontent = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    return [$rawcontent, $info];
}

/**
 * Obtenir un film par ID
 * @param int $id L'ID du film
 * @param string  $lang La langue à utiliser dans les données
**/
function getMovie($id, $lang = "fr") {
    return json_decode(tmdbget("movie/$id", ["language" => $lang]), true);
}

/**
 * Obtenir les crédits d'un film par ID
 * @param int $id L'ID du film
**/
function getMovieCredits($id) {
    return json_decode(tmdbget("movie/$id/credits"), true);
}

/**
 * Obtenir une collection par ID
 * @param int $id L'ID de la collection
 * @param string  $lang La langue à utiliser dans les données
**/
function getCollection($id, $lang = "fr") {
    return json_decode(tmdbget("collection/$id", ["language" => $lang]), true);
}

/**
 * Obtenir une personne par ID
 * @param int $id L'ID de la personne
 * @param string  $lang La langue à utiliser dans les données
**/
function getActor($id, $lang = "fr") {
    $actor = json_decode(tmdbget("person/$id", ["language" => $lang]), true);
    $movies = json_decode(tmdbget("person/$id/movie_credits", ["language" => $lang]), true)["cast"];
    $moviesShort = [];
    foreach ($movies as $movie) {
        array_push($moviesShort, [
            "id" => $movie["id"],
            "character" => $movie["character"],
            "title" => $movie["title"],
            "poster_path" => $movie["poster_path"]
        ]);
    }
    $actor["movies"] = $moviesShort;
    return $actor;
}

/**
 * Obtenir la configuration des images
 */
function getImageOptions() {
    $config = json_decode(tmdbget("configuration"), true)["images"];
    return [
        "path" => $config["secure_base_url"],
        "posterLow" => $config["poster_sizes"][1],
        "posterMed" => $config["poster_sizes"][2],
        "posterHigh" => $config["poster_sizes"][3],
        "backdrop" => $config["backdrop_sizes"][2],
        "profile" => $config["profile_sizes"][1],
        "profileHigh" => $config["profile_sizes"][2]
    ];
}

/**
 * Obtenir les vidéos d'un film par ID
 * @param int $id L'ID du film
**/
function getMovieTrailers($id) {
    $results = json_decode(tmdbget("movie/$id/videos"), true)["results"];
    $videos = [];
    foreach ($results as $video) {
        switch ($video["site"]) {
            case "YouTube":
                $src = "https://www.youtube.com/embed/" . $video["key"];
                break;
            case "Vimeo":
                $src = "https://player.vimeo.com/video/" . $video["key"];
                break;
        }
        if (isset($src)) {
            array_push($videos, [
                "src" => $src,
                "key" => $video["key"],
                "site" => $video["site"],
                "name" => $video["name"],
                "type" => $video["type"]
            ]);
        }
    }
    return $videos;
}

/**
 * Rechercher des films
 * @param string $query Le texte recherché
 * @param int $page La page de recherche à obtenir
 * @param string $lang La langue à utiliser dans les données
 */
function searchMovies($query, $page = 1, $lang = "fr") {
    return json_decode(tmdbget("search/movie", ["query" => $query, "language" => $lang, "page" => $page]), true);
}

/**
 * Rechercher des collections
 * @param string $query Le texte recherché
 * @param int $page La page de recherche à obtenir
 * @param string $lang La langue à utiliser dans les données
 */
function searchCollections($query, $page = 1, $lang = "fr") {
    return json_decode(tmdbget("search/collection", ["query" => $query, "language" => $lang, "page" => $page]), true);
}

/**
 * Rechercher des personnes
 * @param string $query Le texte recherché
 * @param int $page La page de recherche à obtenir
 * @param string $lang La langue à utiliser dans les données
 */
function searchActors($query, $page = 1, $lang = "fr") {
    return json_decode(tmdbget("search/person", ["query" => $query, "language" => $lang, "page" => $page]), true);
}

/**
 * Obtenir le texte indicatif d'une langue.
 * Retourne un emoji drapeau si disponible, ou "VO" sinon.
 * @param string $lang La langue à convertir
 */
function langFlag($lang) {
    switch ($lang) {
        case "fr":
            return "🇫🇷 (VO)";
        case "en":
            return "🇬🇧 (VO)";
        case "it":
            return "🇮🇹 (VO)";
        case "ja":
            return "🇯🇵 (VO)";
        case "es":
            return "🇪🇸 (VO)";
        case "ko":
            return "🇰🇷 (VO)";
        case "pt":
            return "🇵🇹 (VO)";
        default:
            return "VO";
    }
}

/**
 * Composant HTML barre de recherche
 * @param boolean $inNav Placer la barre dans un <nav>?
 * @param strng $query Valeur initiale à afficher dans la barre
 */
function componentSearch($inNav = false, $query = "") { ?>
    <?php if ($inNav): ?>
    <nav>
        <h1><a class="gradText" href="./">TBMDBB</a></h1>
    <?php endif; ?>
        <form class="search" method="get" action="Search.php">
            <input type="text" id="q" name="q" placeholder="Rechercher un film, une collection ou une personne" value="<?= $query ?>"/>
            <input type="submit" value="Rechercher"/>
        </form>
    <?php if ($inNav): ?>
    </nav>
    <?php endif;
}

/**
 * Composant head HTML (début du fichier)
 * @param string $backdrop L'URL de l'image de fond à utiliser
 */
function componentHeader($backdrop = "") { ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="">
        <title>The better movie database bootleg 2 2</title>
        <link rel="stylesheet" href="res/style.css">
        <style>
            body {
                <?php if ($backdrop != "") : ?>
                background-image: url(<?= "https://www.themoviedb.org/t/p/original" . $backdrop ?>);
                <?php else: ?>
                background-image: radial-gradient(circle, rgba(14,200,218,1) 0%, rgba(20,142,177,1) 45%, rgba(9,45,56,1) 75%);
                <?php endif; ?>
            }
        </style>
    </head>
    <?php
}

function componentFooter() { ?>
    <footer>
        <p>Copyright © <?= date("Y") ?> The Better Movie Database Bootleg. Tous droits réservés</p>
    </footer>
    <?php
}

?>