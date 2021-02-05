% PW-DOM  Compte rendu de TP

# Compte-rendu de TP

## Participants 

* Samy WAGNER
* Damian CARMONA
* Florent BARBE

## Prise en main - diagnostic PHP

### Comparaison Server API

En ligne de commande: "Command Line Interface"
Dans le navigateur: Apache 2.0 Handler

### Erreur dans debogage.php

On a modifié la ligne 14: var_dump($b) => vardump($b)
Retour de la console:

```
 a=int(12)

 b=PHP Fatal error:  Uncaught Error: Call to undefined function vardump() in /home/rams/web/pw_2021/Exercices/TP1/debogage.php:14
Stack trace:
#0 {main}
  thrown in /home/rams/web/pw_2021/Exercices/TP1/debogage.php on line 14
```

## Calcul d’intérêts composés

Lorsque on utilise GET les variables s'affichent dans l'URL, alors que lorsque on utilise POST ça ne le fait pas. POST doit être utilisé si l'on travaille sur des données sécurisées telles qu'un mot de passe. Dans notre cas on peut utiliser GET.
Nous avons créé une fonction cumul dans libcacul.php puis nous faisons appelle à cette librairie pour faire de cumul.
Nous avons modifié resultat.php pour pourvoir l'éxecuter en ligne de commande en utilisant le script clicacul.php

## Un peu de style en CSS

L'élément de niveau le plus profond dans la hiérarchie:
html > body > table > tbody > tr > td (niveau 5)
Nous avons rajouté une bordure à la table et changé les couleurs des liens avec:
```css
table, th, tr, td {
    border: 1px solid black;
    border-collapse: collapse;
}

a {
    color: green;
    text-decoration: none;
}

ul a {
    color: green;
    font-weight: bold;
}
```

## Table de multiplication

Pour surligner les lignes, nous avons choisi de le faire au survol de la souris avec la pseudo-classe CSS `hover`:
```css
tr:hover {
    background-color: yellow;
}
```

## Analyse des Caractères Unicode

Pour obtenir les informations Unicode nous avons choisi d'utiliser les fonctions de la classe PHP 7.4 `IntlChar`:
```php
// Obtenir le point de code d'un caractère
$codepoint = IntlChar::ord($c);
// Obtenir le caractère d'un point de code
$char = IntlChar::chr($i);
// Obtenir le nom normalisé d'un point de code
$name = IntlChar::charName($i);
```
Nous avons mis le tooltip sur le `<td>` plutôt que le `<span>` afin d'afficher le nom normalisé au survol de n'importe quelle partie de la case de tableau:
```php
// On met aussi la case en jaune si il s'agit du caractère choisi
$color = ($i == $codepoint) ? " class='sel'" : "";
print("<td$color title='$name'>");
```
Plutôt que d'utiliser des classes CSS, nous utilisons les sélecteurs:
```css
td > span {
    font-size: 2em;
}
```

## Calendrier - agenda web

