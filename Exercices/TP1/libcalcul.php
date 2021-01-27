<?php

function cumul($somme, $taux, $duree) {
    return $somme * ((1 + $taux / 100)**$duree);
}

?>