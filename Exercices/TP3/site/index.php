<?php
    require_once(__DIR__ . "/libmovie.php");
    componentHeader();
?>
<body>
    <main class="centered">
        <h1 class="gradText">TBMDBB</h1>
        <h3>The Better Movie Database Bootleg</h3>
        <?php componentSearch(); ?>
    </main>
    <?php componentFooter(); ?>
</body> 
</html>