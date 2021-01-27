<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="multiplication.css">
    <title>Table de multiplication</title>
</head>
<body>
    <h1>Table de multiplication</h1>
    <table>
    <?php
        for($i=0; $i<=10; $i++){
            print("<tr>");
            for($j=0; $j<=10; $j++){
                $calc = $j*$i;
                if ($i == 0) {
                    print("<th> $j </th>");
                } else if ($j == 0) {
                    print("<th> $i </th>");
                } else {
                    print("<td> $calc </td>");
                }
            }
            print("</tr>");
        }
    ?>
    </table>
</body>
</html>