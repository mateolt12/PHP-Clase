<!DOCTYPE html>

<html>
    <head lang="es">
        <meta charset="UTF-8">
        <title>Tenda virtual - Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>

            table, tr, td{
                border: 2px black solid;
                border-collapse: collapse;
            }

            tr td:last-child{
                text-align: center;
            }


        </style>

    </head>
    <body>

        <?php
        include ("config.php");
        $usuarioValidado = false;
        $passValida = false;

        if (isset($_POST["entrar"])) {
            $usuariosFich = json_decode(file_get_contents(USERS_FILENAME), true);

            foreach ($usuariosFich as $pos => $ArrayValores) {
                foreach ($ArrayValores as $campoUser) {

                    if ($ArrayValores["user"] == $_POST["user"]) {
                        $usuarioValidado = true;
                    }
                    if (password_verify($_POST["pass"], $ArrayValores["pass"])) {
                        $passValida = true;
                    }
                    if ($passValida && $usuarioValidado) {
                        session_start();
                        $_SESSION['user'] = $_POST['user'];
                        header('Location: produtos.php');
                        break 2;
                    }
                }
            }

            if (!$usuarioValidado || !$passValida) {
                $mensaxe = "Usuario ou contrasinal erroneo.";
            }
        }
        ?>

        <h2>Autenticación de usuario</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

            Usuario: <input type="text" name="user" autofocus/><br><br>
            Contrasinal: <input type="password" name="pass"/><br><br>

            <input type="submit" name="entrar" value="Entrar"/> <br><br>

        </form>

        <?php
        if (isset($_POST["entrar"])) {
            if (!$usuarioValidado || !$passValida) {
                /*
                 * echo "<pre>";
                 * print_r($usuariosFich);
                 * echo "</pre>";
                 */
                echo $mensaxe;
            }
        }
        ?>

        <p>Produtos para mercar: </p><br>
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
                    } else {
                        echo "<td>$valorProduto</td>";
                    }
                }
                echo "</tr>";
            }
            ?>

        </table>
    </body>
</html>
