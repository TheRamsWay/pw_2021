<?php
    require_once(__DIR__ . "/libmovie.php");

    $cid = (isset($_GET["cid"]) ? $_GET["cid"] : 661031);
    
    $arrfr = getCollection($cid, "fr");
    if (isset($arrfr["success"]) && !$arrfr["success"]) {
        $err = true;
    } else {
        $err = false;
        $arren = getCollection($cid, "en");
        $vo = $arrfr["parts"][0]["original_language"];
        $arror = getCollection($cid, $vo);
        $note = 0;
        $noted = 0;
        $actors = [];
        foreach ($arrfr["parts"] as $movie) {
            if ($movie["vote_count"] > 0) {
                $note += $movie["vote_average"];
                $noted++;
            }
            $movieActors = getMovieCredits($movie["id"])["cast"];
            foreach ($movieActors as $actor) {
                $id = "act_" . $actor["id"];
                if (array_key_exists($id, $actors)) {
                    array_push($actors[$id]["appears_in"], $movie["id"]);
                    if (!in_array($actor["character"], $actors[$id]["characters"])) {
                        array_push($actors[$id]["characters"], $actor["character"]);
                    }
                } else {
                    $actor["appears_in"] = [$movie["id"]];
                    $actor["characters"] = [$actor["character"]];
                    $actors[$id] = $actor;
                }
            }
        }
        $note /= $noted;
        $note = round($note, 1);
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
                <h1><?= $arrfr["name"] ?></h1>
                <p><b>🇬🇧 <?= $arren["name"] ?></b></p>
                <?php if ($vo != "en" && $vo != "fr") : ?>
                    <p><b><?= langFlag($vo) ?> <?= $arror["name"] ?></b></p>
                <?php endif; ?>
                <a target="_blank" href="<?= "https://www.themoviedb.org/collection/" . $cid . "?language=fr" ?>">
                    Page TMDB de la collection
                </a>
                <h2>Synopsis</h2>
                <?php if ($arrfr["overview"] != ""): ?>
                <p><?= $arrfr["overview"] ?></p>
                <?php else: ?>
                <p><i>Pas de synopsis</i></p>
                <?php endif; ?>
                <h2>Note moyenne</h2>
                <p><?= 10*$note ?> %</p>
            </div>
        </div>
        <h2>Dans cette collection (<?= count($arrfr["parts"]) ?>)</h2>
        <div>
        <?php foreach ($arrfr["parts"] as $movie): ?>
            <div class="data">
                <?php if (!empty($movie["poster_path"])): ?>
                <img class="poster" src="<?= $imgconf["path"] . $imgconf["posterMed"] . $movie["poster_path"] ?>">
                <?php else: ?>
                <img class="poster" src="res/noposter.svg">  
                <?php endif; ?>
                <div>
                    <h3><a href="MovieInfo.php?mid=<?= $movie["id"] ?>"><?= $movie["title"] ?></a></h3>
                    <?php if ($movie["overview"] != ""): ?>
                    <p><?= $movie["overview"] ?></p>
                    <?php else: ?>
                    <p><i>Pas de synopsis</i></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
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
                    <?php

                    $appears = count($actor["appears_in"]);
                    $text = $actor["name"] . " (" . $appears . "/" . count($arrfr["parts"]) . ")";

                    ?>
                    <h3><a href="ActorInfo.php?aid=<?= $actor["id"] ?>"><?= $text ?></a></h3>
                    <p><?php
                    
                    print($actor["characters"][0]);
                    for ($i = 1; $i < count($actor["characters"]); $i++) {
                        print(", " . $actor["characters"][$i]);
                    }

                    ?></p>
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
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
    <main class="centered">
        <h1>Pas de collection trouvée</h1>
    <?php endif; ?>
    </main>
    <?php componentFooter(); ?>
</body> 
</html>