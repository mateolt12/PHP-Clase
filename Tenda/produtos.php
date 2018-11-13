<!DOCTYPE html>

<html  lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Tenda virtual - Produtos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <?php
        /* echo "<pre>";
          print_r($_POST);
          echo "</pre>"; */
        ?>





        <form action="logoff.php" method="POST">
            <?php
            include("config.php");
            session_start();
            echo "Ola " . $_SESSION['user'] . "!";
            ?>
            <input type="submit" value="Pechar sesión" name="pecharSesion"/>
        </form>

        <br><br>

        <table>
            <tr>
                <td>Código</td>
                <td>Nome</td>
                <td>PVP</td>
            </tr>

            <?php
            $produtosFich = json_decode(file_get_contents(PRODUTOS_FILENAME), true);

            foreach ($produtosFich as $arrayPro => $valores) {
                echo "<tr>";
                foreach ($valores as $infoProduto => $valorProduto) {
                    if ($infoProduto == "PVP") {
                        echo "<td>$valorProduto €</td>";
                    } elseif($infoProduto=="cod"){
                        echo "<td><input type='hidden' name='articulo' value='.$valorProduto.'";
                    }
                    else {
                        echo "<td>$valorProduto</td>";
                    }
                }
                echo "<td><form action='produtos.php' method='post'>"
                . "<input type='number' name='cantidade' min='1'/></td>";
                echo "<td><input type='submit' name='engadir' value='Engadir'/></td>";
                echo "</form></tr>";
            }
            ?>
        </table>
    </body>
</html>
