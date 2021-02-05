<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="multiplication.css">
    <title>Table de multiplication</title>
</head>
<body>
    <table>
    <?php
      
    $lignes = $_REQUEST["lignes"];
    $colonnes = $_REQUEST["colonnes"];
    if (empty($lignes)) {
        $lignes = 10;
    }
    if (empty($colonnes)) {
        $colonnes = 10;
    }

    if(isset($lignes) && isset($colonnes)){
        for($i=0; $i<=$lignes; $i++){
            print("<tr>");
            for($j=0; $j<=$colonnes; $j++){
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
    }
           
    ?>
    </table>
    
</body>
</html>