<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="unicode.css">
    <title>Code Unicode des 16 caractères</title>
</head>
<body>
    <table>
        <tr>
        <?php

        $c = (empty($_GET["txt"])) ? "A" : mb_substr($_GET["txt"], 0, 1);
        $codepoint = IntlChar::ord($c);
        $linestart = $codepoint - ($codepoint % 16);
        for ($i = $linestart; $i < ($linestart + 16); $i++) {
            $char = IntlChar::chr($i);
            $hex = sprintf("%04X", $i);
            $color = ($i == $codepoint) ? " class='sel'" : "";
            $name = IntlChar::charName($i);
            print("<td$color title='$name'>");
            print("<span>$char</span><br>");
            print("<a href='http://unicode.org/cldr/utility/character.jsp?a=$hex'>U+$hex</a>");
        } 
                
        ?>
        </tr>
    </table>
    
</body> 
</html>