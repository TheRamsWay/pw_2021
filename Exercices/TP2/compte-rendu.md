% PW-DOM  Compte rendu de TP

# Compte-rendu de TP

Sujet : Bornes wifi de la ville de Grenoble

## Participants 

* Samy WAGNER
* Damian CARMONA
* Florent BARBE


cat ./Exercices/TP2/borneswifi_EPSG4326.csv|wc -l 68 points d'accès

cat ./Exercices/TP2/borneswifi_EPSG4326.csv | cut -d"," -f2 | uniq -c | sort -r Celui qui a le plus de points d'accès est "bibliothèque étude" avec 5, et il y a 59 points d'accès différents.

Points à proximité de la place Grenette: 6
Le plus proche: "Place Grenette" (8 place Grenette, 1er étage)