% PW-DOM  Compte rendu de TP

# Compte-rendu de TP

Sujet : Bornes wifi de la ville de Grenoble

## Participants 

* Samy WAGNER
* Damian CARMONA
* Florent BARBE

## Points d'accès wifi

Nombre de points d'accès:
cat ./Exercices/TP2/borneswifi_EPSG4326.csv|wc -l
On trouve 68 points d'accès.

Points pour chaque emplacement:
cat ./Exercices/TP2/borneswifi_EPSG4326.csv | cut -d"," -f2 | sort | uniq -c | sort -r
Celui qui a le plus de points d'accès est "bibliothèque étude" avec 5.
En ajoutant "|wc -l" on trouve 58 lieux différents.

Points à proximité de la place Grenette: 6
Le plus proche: "Place Grenette" (8 place Grenette, 1er étage).
```php
array(7) {
  ["AP_ANTENNE2"]=>
  array(4) {
    ["lieu"]=>string(9) "Antenne 2"
    ["lon"]=>string(8) "5.727524"
    ["lat"]=>string(9) "45.192460"
    ["dist"]=>float(112.8)
  }
  ["AP_APP_GAGNANT"]=>
  array(4) {
    ["lieu"]=>string(35) "Musée Stendhal Appartement Gagnon "
    ["lon"]=>string(8) "5.728058"
    ["lat"]=>string(9) "45.191570"
    ["dist"]=>float(73.7)
  }
  ["AP_JDV1"]=>
  array(4) {
    ["lieu"]=>string(32) "Jardin de ville AP switch 470Bis"
    ["lon"]=>string(8) "5.727202"
    ["lat"]=>string(9) "45.192828"
    ["dist"]=>float(145.9)
  }
  ["AP_JDV2"]=>
  array(4) {
    ["lieu"]=>string(21) "Jardin de ville Port2"
    ["lon"]=>string(8) "5.727582"
    ["lat"]=>string(9) "45.192664"
    ["dist"]=>float(128.9)
  }
  ["AP_THEATRE1"]=>
  array(4) {
    ["lieu"]=>string(8) "Théatre"
    ["lon"]=>string(8) "5.727679"
    ["lat"]=>string(9) "45.193326"
    ["dist"]=>float(181.4)
  }
  ["AP_THEATRE2"]=>
  array(4) {
    ["lieu"]=>string(8) "Théatre"
    ["lon"]=>string(8) "5.727679"
    ["lat"]=>string(9) "45.193326"
    ["dist"]=>float(181.4)
  }
  ["Place Grenette"]=>
  array(4) {
    ["lieu"]=>string(38) "8 place Grenette, 1er étage (neptune)"
    ["lon"]=>string(8) "5.727342"
    ["lat"]=>string(9) "45.191064"
    ["dist"]=>float(20.1)
  }
}
```

## Antennes GSM

Nombre d'antennes GSM:
cat ./Exercices/TP2/DSPE_ANT_GSM_EPSG4326.csv|wc -l
On trouve 100 antennes.

Informations supplémentaires:
Ce jeu contient la technologie utilisée par les antennes ainsi que le type de réseaux supportés. On nous donne aussi directement l'adresse où se trouve l'antenne.
Dans le cadre d'une démarche OpenData, ces données sont intéressantes car cela nous permet d'avoir des informations plus détaillées sur les antennes, les types de réseaux sont notamment particulièrement utiles (par exemple, pour connaitre la couverture 4G de la région).

Statistiques opérateurs:
cat DSPE_ANT_GSM_EPSG4326.csv|cut -d";" -f4|sort|uniq|wc -l
On trouve 4 opérateurs.
En remplaçant "uniq|wc -l" par "uniq -c|sort -r" on observe que SFR a 30 antennes, Orange 26, Bouygues 26 et Free 18.
Nous avons utilisé la ligne de commandes car nous avions déjà une commande similaire dans la première partie et cela évite l'installation d'outils supplémentaires.

KML:
Le KML utilise un schéma XSD, on peut donc le valider facilement avec xmllint.
Il est simple à lire, on trouve facilement les attributs et leur valeur avec les éléments SimpleData ou les tableaux. Ces données sont cependant répétées plusieurs fois dans différents format, il y a donc beaucoup de redondance.

Top N opérateurs:
Les antennes GSM couvrent une large distance et sont donc relativement éloignées, nous avons donc choisi d'augmenter la distance minimale de sélection des antennes proches à 10 km au lieu de 200m afin d'obtenir plus de résultats (sinon, certains points ne donnaient même pas d'antenne proche).