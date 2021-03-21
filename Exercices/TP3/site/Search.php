<?php
    require_once(__DIR__ . "/libmovie.php");

    if (isset($_GET["q"]) && $_GET["q"] != "") {
        $query = $_GET["q"];
        $page = (isset($_GET["page"]) ? $_GET["page"] : 1);
        $err = false;
        $movies = searchMovies($query);
        $collections = searchCollections($query);
        $actors = searchActors($query);
    } else {
        $query = "";
        $page = 1;
        $err = true;
        $movies = [
            "page" => 1,
            "results" => [],
            "total_pages" => 0,
            "total_results" => 0
        ];
        $collections = [
            "page" => 1,
            "results" => [],
            "total_pages" => 0,
            "total_results" => 0
        ];
        $actors = [
            "page" => 1,
            "results" => [],
            "total_pages" => 0,
            "total_results" => 0
        ];
    }

    $results = $movies["total_results"] + $collections["total_results"] + $actors["total_results"];

    $imgconf = getImageOptions();

    componentHeader();
?>
<body>
    <?php componentSearch(true, $query); ?>
    <main>
        <?php if (!$err && $results > 0) : ?>
            <h1>Résultats pour: <?= $query ?> (<?= $results ?>)</h1>
            <h2>Films (<?= $movies["total_results"] ?>)</h2>
            <div>
            <?php foreach ($movies["results"] as $movie): ?>
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
            <h2>Collections (<?= $collections["total_results"] ?>)</h2>
            <div>
            <?php foreach ($collections["results"] as $collection): ?>
                <div class="data">
                    <?php if (!empty($collection["poster_path"])): ?>
                    <img class="poster" src="<?= $imgconf["path"] . $imgconf["posterMed"] . $collection["poster_path"] ?>">
                    <?php else: ?>
                    <img class="poster" src="res/noposter.svg">  
                    <?php endif; ?>
                    <div>
                        <h3><a href="CollectionInfo.php?cid=<?= $collection["id"] ?>"><?= $collection["name"] ?></a></h3>
                        <?php if ($collection["overview"] != ""): ?>
                        <p><?= $collection["overview"] ?></p>
                        <?php else: ?>
                        <p><i>Pas de synopsis</i></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <h2>Personnes (<?= $actors["total_results"] ?>)</h2>
            <div>
            <?php foreach ($actors["results"] as $actor): ?>
                <div class="data">
                    <?php if (!empty($actor["profile_path"])): ?>
                    <img class="profile" src="<?= $imgconf["path"] . $imgconf["profile"] . $actor["profile_path"] ?>">
                    <?php else: ?>
                    <img class="profile" src="res/noprofile.svg">  
                    <?php endif; ?>
                    <div>
                        <h3><a href="ActorInfo.php?aid=<?= $actor["id"] ?>"><?= $actor["name"] ?></a></h3>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php else: ?>
            <h1>Aucun résultat</h1>
            <h2>Essayez de chercher autre chose.</h2>
        <?php endif; ?>
    </main>
    <?php componentFooter(); ?>
</body> 
</html>