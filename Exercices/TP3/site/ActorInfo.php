<?php
    require_once(__DIR__ . "/libmovie.php");

    $aid = (isset($_GET["aid"]) ? $_GET["aid"] : 1325962);
    
    $actor = getActor($aid, "fr");
    if (isset($actor["success"]) && !$actor["success"]) {
        $err = true;
    } else {
        $err = false;
        $date = new DateTime($actor["birthday"]);
        $birthdate = $date->format("d/m/Y");
    }

    $imgconf = getImageOptions();
    
    componentHeader()
?>
<body>
    <?php componentSearch(true); ?>
    <?php if (!$err) : ?>
    <main>
        <div id="header" class="data">
            <?php if (!empty($actor["profile_path"])): ?>
            <img class="profileHigh" src="<?= $imgconf["path"] . $imgconf["profileHigh"] . $actor["profile_path"] ?>">
            <?php else: ?>
            <img class="profileHigh" src="res/noprofile.svg">  
            <?php endif; ?>
            <div>
                <h1><?= $actor["name"] ?></h1>
                <?php if (count($actor["also_known_as"]) > 0): ?>
                <h2>Alias</h2>
                <p>
                <?php
                    print($actor["also_known_as"][0]);
                    for ($i = 1; $i < count($actor["also_known_as"]); $i++) {
                        print(", " . $actor["also_known_as"][$i]);
                    }
                ?>
                <?php endif; ?>
                </p>
                <a target="_blank" href="<?= "https://www.themoviedb.org/person/" . $aid . "?language=fr" ?>">
                    Page TMDB de la personne
                </a>
                <h2>Naissance</h2>
                <p><?= $birthdate ?>, <?= $actor["place_of_birth"] ?></p>
                <?php if (isset($actor["deathday"])): ?>
                <h2>Mort</h2>
                <p><?= $actor["deathday"] ?></p>
                <?php endif; ?>
                <?php if (isset($actor["homepage"])): ?>
                <h2><a target="_blank" href="<?= $actor["homepage"] ?>">Site web</a></h2>
                <?php endif; ?>
            </div>
        </div>
        <h2>Biographie</h2>
        <?php if ($actor["biography"] != ""): ?>
        <p><?= $actor["biography"] ?></p>
        <?php else: ?>
        <p><i>Pas de biographie</i></p>
        <?php endif; ?>
        <h2>Rôles (<?= count($actor["movies"]) ?>)</h2>
        <div class="dataGrid">
        <?php foreach ($actor["movies"] as $movie): ?>
            <div>
                <?php if (!empty($movie["poster_path"])): ?>
                <img class="posterSmall" src="<?= $imgconf["path"] . $imgconf["posterLow"] . $movie["poster_path"] ?>">
                <?php else: ?>
                <img class="posterSmall" src="res/noposter.svg">  
                <?php endif; ?>
                <div>
                    <h3><a href="MovieInfo.php?mid=<?= $movie["id"] ?>"><?= $movie["title"] ?></a></h3>
                    <p><?= $movie["character"] ?></p>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    <?php else: ?>
    <main class="centered">
        <h1>Pas de personne trouvée</h1>
    <?php endif; ?>
    </main>
    <?php componentFooter(); ?>
</body> 
</html>