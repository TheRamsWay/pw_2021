<?php
    ini_set('display_errors', 1);
    ini_set('error_reporting', E_ALL);

    require_once(__DIR__ . "/tp3-helpers.php");
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
    }
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>The better movie database bootleg 2 2</title>
    <link rel="stylesheet" href="MovieInfo.css">
    <?php if (!$err) : ?>
    <style>
        body {
            background-image: url(<?= "https://www.themoviedb.org/t/p/original" . $arror["backdrop_path"] ?>);
        }
    </style>
    <?php endif; ?>
</head>
<body>
    <nav>
        <form method="get" action="<?= $_SERVER["PHP_SELF"] ?>">
            <label for="mid">ID du film : </label>
            <input type="number" min=0 id="mid" name="mid" value="<?= $mid ?>"/>
            <input type="submit" />
        </form>
    </nav>
    <main>
        <?php if (!$err) : ?>
            <div id="header" class="data">
                <img class="poster" src="<?= "https://www.themoviedb.org/t/p/original" . $arrfr["poster_path"] ?>">
                <div>
                    <h1><?= $arrfr["title"] ?></h1>
                    <p><b>🇬🇧 <?= $arren["title"] ?></b></p>
                    <?php if ($vo != "en" && $vo != "fr") : ?>
                        <p><b><?= langFlag($vo) ?> <?= $arror["original_title"] ?></b></p>
                    <?php endif; ?>
                    <h2>Synopsis</h2>
                    <p><?= $arrfr["overview"] ?></p>
                    <?php if ($arrfr["tagline"] != "") : ?>
                        <h3>Phrase d'accroche</h3>
                        <p><?= $arrfr["tagline"] ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <h2>En anglais</h2>
            <div class="data">
                <img class="poster" src="<?= "https://www.themoviedb.org/t/p/original" . $arren["poster_path"] ?>">
                <div>
                    <h3>Synopsis</h3>
                    <p><?= $arren["overview"] ?></p>
                    <?php if ($arren["tagline"] != "") : ?>
                        <h4>Phrase d'accroche</h4>
                        <p><?= $arren["tagline"] ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($vo != "fr" && $vo != "en") : ?>
                <h2>Dans la langue originale</h2>
                <div class="data">
                    <img class="poster" src="<?= "https://www.themoviedb.org/t/p/original" . $arror["poster_path"] ?>">
                    <div>
                        <h3>Synopsis</h3>
                        <p><?= $arror["overview"] ?></p>
                        <?php if ($arror["tagline"] != "") : ?>
                            <h4>Phrase d'accroche</h4>
                            <p><?= $arror["tagline"] ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <h1>Pas de film trouvé</h1>
        <?php endif; ?>
    </main>
</body> 
</html>