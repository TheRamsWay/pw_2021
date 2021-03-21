<?php
    require_once(__DIR__ . "/libmovie.php");

    $mid = (isset($_GET["mid"]) ? $_GET["mid"] : 15152);
    
    $arrfr = getMovie($mid, "fr");
    if (isset($arrfr["success"]) && !$arrfr["success"]) {
        $err = true;
    } else {
        $err = false;
        $arren = getMovie($mid, "en");
        $vo = $arrfr["original_language"];
        $arror = getMovie($mid, $vo);
        $videos = getMovieTrailers($mid);
        $actors = getMovieCredits($mid)["cast"];
        if (isset($arror["belongs_to_collection"])) {
            $collection = getCollection($arror["belongs_to_collection"]["id"], "fr");
        }
    }

    $imgconf = getImageOptions();
    
    if (!$err && isset($arrfr["backdrop_path"])) {
        componentHeader($arrfr["backdrop_path"]);
    } else {
        componentHeader();
    }
?>
<body>
    <?php componentSearch(true); ?>
    <?php if (!$err) : ?>
    <main>
        <div id="header" class="data">
            <?php if (!empty($arrfr["poster_path"])): ?>
            <img class="poster" src="<?= $imgconf["path"] . $imgconf["posterHigh"] . $arrfr["poster_path"] ?>">
            <?php else: ?>
            <img class="poster" src="res/noposter.svg">  
            <?php endif; ?>
            <div>
                <h1><?= $arrfr["title"] ?></h1>
                <p><b>🇬🇧 <?= $arren["title"] ?></b></p>
                <?php if ($vo != "en" && $vo != "fr") : ?>
                    <p><b><?= langFlag($vo) ?> <?= $arror["title"] ?></b></p>
                <?php endif; ?>
                <a target="_blank" href="<?= "https://www.themoviedb.org/movie/" . $mid . "?language=fr" ?>">
                    Page TMDB du film
                </a>
                <h2>Synopsis</h2>
                <?php if ($arrfr["overview"] != ""): ?>
                <p><?= $arrfr["overview"] ?></p>
                <?php else: ?>
                <p><i>Pas de synopsis</i></p>
                <?php endif; ?>
                <?php if ($arrfr["tagline"] != "") : ?>
                    <h3>Phrase d'accroche</h3>
                    <p><?= $arrfr["tagline"] ?></p>
                <?php endif; ?>
            </div>
        </div>
        <h2>Plus d'informations</h2>
        <div>
            <h3>Note moyenne</h3>
            <p><?= 10*$arrfr["vote_average"] ?> %</p>
            <?php if (count($videos) > 0) : ?>
            <h3>Bande-annonce</h3>
            <iframe width="560" height="315" src=<?= $videos[0]["src"] ?> frameborder="0" allowfullscreen></iframe>
            <?php endif; ?>
            <?php if (isset($collection)): ?>
            <h3>Collection</h3>
            <div class="data">
                <?php if (!empty($collection["poster_path"])): ?>
                <img class="poster" src="<?= $imgconf["path"] . $imgconf["posterMed"] . $collection["poster_path"] ?>">
                <?php else: ?>
                <img class="poster" src="res/noposter.svg">  
                <?php endif; ?>
                <div>
                    <h2><a href="CollectionInfo.php?cid=<?= $collection["id"] ?>"><?= $collection["name"] ?></a></h2>
                    <h3>Synopsis</h3>
                    <?php if ($collection["overview"] != ""): ?>
                    <p><?= $collection["overview"] ?></p>
                    <?php else: ?>
                    <p><i>Pas de synopsis</i></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <h2>Distribution</h2>
        <div class="dataGrid">
        <?php foreach ($actors as $actor): ?>
            <div>
                <?php if (!empty($actor["profile_path"])): ?>
                <img class="profile" src="<?= $imgconf["path"] . $imgconf["profile"] . $actor["profile_path"] ?>">
                <?php else: ?>
                <img class="profile" src="res/noprofile.svg">  
                <?php endif; ?>
                <div>
                    <h3><a href="ActorInfo.php?aid=<?= $actor["id"] ?>"><?= $actor["name"] ?></a></h3>
                    <p><?= $actor["character"] ?></p>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        <h2>En anglais</h2>
        <div class="data">
            <?php if (!empty($arren["poster_path"])): ?>
            <img class="poster" src="<?= $imgconf["path"] . $imgconf["posterMed"] . $arren["poster_path"] ?>">
            <?php else: ?>
            <img class="poster" src="res/noposter.svg">  
            <?php endif; ?>
            <div>
                <h3>Synopsis</h3>
                <?php if ($arren["overview"] != ""): ?>
                <p><?= $arren["overview"] ?></p>
                <?php else: ?>
                <p><i>Pas de synopsis</i></p>
                <?php endif; ?>
                <?php if ($arren["tagline"] != "") : ?>
                    <h4>Phrase d'accroche</h4>
                    <p><?= $arren["tagline"] ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($vo != "fr" && $vo != "en") : ?>
            <h2>Dans la langue originale</h2>
            <div class="data">
                <?php if (!empty($arror["poster_path"])): ?>
                <img class="poster" src="<?= $imgconf["path"] . $imgconf["posterMed"] . $arror["poster_path"] ?>">
                <?php else: ?>
                <img class="poster" src="res/noposter.svg">  
                <?php endif; ?>
                <div>
                    <h3>Synopsis</h3>
                    <?php if ($arror["overview"] != ""): ?>
                    <p><?= $arror["overview"] ?></p>
                    <?php else: ?>
                    <p><i>Pas de synopsis</i></p>
                    <?php endif; ?>
                    <?php if ($arror["tagline"] != "") : ?>
                        <h4>Phrase d'accroche</h4>
                        <p><?= $arror["tagline"] ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
    <main class="centered">
        <h1>Pas de film trouvé</h1>
    <?php endif; ?>
    </main>
    <?php componentFooter(); ?>
</body> 
</html>