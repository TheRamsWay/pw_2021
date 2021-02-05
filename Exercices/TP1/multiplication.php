<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="multiplication.css">
    <title>Table de multiplication</title>
</head>
<body>
    <?php
      
    if(!isset($_REQUEST["lignes"])) {
        print("Pas de lignes entrées! <br>");
    } else if (!isset($_REQUEST["colonnes"])) {
        print("Pas de colonnes entrées! <br>");
    } else {
        print("<table>");
        $lignes = $_REQUEST["lignes"];
        $colonnes = $_REQUEST["colonnes"];
    
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
        print("</table>");
    }
           
    ?>
    
</body>
</html>