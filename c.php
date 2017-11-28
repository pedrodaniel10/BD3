<html>
  <body>
    <h3>Listar eventos de reposi&ccedil;&atilde;o</h3>
    <form action="c.php" method="post">
      <p><input type="hidden" name="mode" value="list"/></p>
      <p>EAN: <input type="text" name="ean"/>
        <input type="submit" value="Listar"/>
      </p>
    </form>
<?php
  try{
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    include 'config.php';

    $mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : "";
    $ean = isset($_REQUEST['ean']) ? $_REQUEST['ean'] : "";
    if ($mode == "home"){

      $prep = $db->prepare("SELECT ean, design FROM produto");
      $prep->execute();
      $result = $prep->fetchAll();

      echo("<table border=\"1\" cellspacing=\"5\" style=\"text-align: center\">\n");
      echo("<tr>\n");
      echo("<td><b>EAN</b></td>\n");
      echo("<td><b>Designa&ccedil;&atilde;o</b></td>\n");
      echo("<td><b>Listar</b></td>\n");
      echo("</tr>\n");
        foreach($result as $row){
            echo("<tr>\n");
            echo("<td>{$row['ean']}</td>\n");
            echo("<td>{$row['design']}</td>\n");
            echo("<td><a href=\"c.php?mode=list&ean={$row['ean']}\">Listar reposi&ccedil;&otilde;es;</a></td>\n");
            echo("</tr>\n");
        }
        echo("</table>\n");
        echo("<br><br><a href='index.html'>Voltar</a><br><br>");
    }
    elseif ($mode == "list"){

        echo("<h3>EAN = $ean</h3>");
        $prep = $db->prepare("SELECT operador, instante, unidades
                              FROM evento_reposicao NATURAL JOIN reposicao
                              WHERE ean = :ean");
        $prep->bindParam(":ean",$ean);
        $prep->execute();
        $result = $prep->fetchAll();

        echo("<table border=\"1\" cellspacing=\"5\" style=\"text-align: center\">\n");
        echo("<tr>\n");
        echo("<td><b>Operador</b></td>\n");
        echo("<td><b>Instante</b></td>\n");
        echo("<td><b>Unidades</b></td>\n");
        echo("</tr>\n");
        foreach($result as $row){
            echo("<tr>\n");
            echo("<td>{$row['operador']}</td>\n");
            echo("<td>{$row['instante']}</td>\n");
            echo("<td>{$row['unidades']}</td>\n");
            echo("</tr>\n");
        }
        echo("</table>\n");
        echo("<br><br><a href='c.php?mode=home'>Voltar</a><br><br>");
    }
  }
  catch (PDOException $e){
    echo("<p>ERROR: {$e->getMessage()}</p>");
  }
?>
  </body>
</html>
