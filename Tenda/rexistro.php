<h2>Rexistro de usuarios</h2 ><br>
<?php
include "config.php";
$mensaxe = "";
if (isset($_POST['rexistrar'])) {
    if ((!empty($_POST['usuario'])) && (!empty($_POST['contrasinal']))) {
        $xaExiste = false;
        $usuario = strtolower($_POST['usuario']);
        $contrasinal = password_hash($_POST['contrasinal'], PASSWORD_DEFAULT, array("cost" => 12));
        $usuariosFich = array();
        if (file_exists(USERS_FILENAME)) {
            $usuariosFich = json_decode(file_get_contents(USERS_FILENAME), true);
            foreach ($usuariosFich as $usuarioFich) {
                if ($usuarioFich['user'] == $usuario) {
                    $xaExiste = true;
                    $mensaxe = "Usuario xa existe";
                }
            }
        }
        if (!$xaExiste) {
            $usuariosFich[] = array("user" => $usuario, "pass" => $contrasinal);
            $usuariosJson = json_encode($usuariosFich);
            if (file_put_contents(USERS_FILENAME, $usuariosJson) > 0) {
                $mensaxe = "Usuario rexistrado";
            } else {
                $mensaxe = "Erro na creación do usuario";
            }
        }
    } else {
        $mensaxe = "Debe introducir usuario e contrasinal";
    }
}
if (isset($_POST['borrar'])) {
    if (!empty($_POST['usuario'])) {
        $borrado = false;
        $usuario = strtolower($_POST['usuario']);
        $usuariosFich = array();
        if (file_exists(USERS_FILENAME)) {
            $usuariosFich = json_decode(file_get_contents(USERS_FILENAME), true);
            foreach ($usuariosFich as $indice => $usuarioFich) {
                if ($usuarioFich['user'] == $usuario) {
                    unset($usuariosFich["$indice"]);
                    $usuariosFich = array_values($usuariosFich);
                    $borrado = true;
                    $mensaxe = "Usuario borrado";
                }
            }
            if ($borrado) {
                if (count($usuariosFich) == 0) {
                    unlink(USERS_FILENAME);
                } else {
                    $usuariosJson = json_encode($usuariosFich);
                    file_put_contents(USERS_FILENAME, $usuariosJson);
                }
            } else {
                $mensaxe = "Usuario NON rexistrado";
            }
        } else {
            $mensaxe = "Non hai usuarios rexistrados";
        }
    } else {
        $erro = 2;
        $mensaxe = "Debe introducir nome de usuario a borrar";
    }
}
if (isset($_POST['listar'])) {
    $usuariosFich = array();
    if (file_exists(USERS_FILENAME)) {
        $usuariosFich = json_decode(file_get_contents(USERS_FILENAME), true);
        echo "Usuarios rexistrados:<br><br>";
        foreach ($usuariosFich as $indice => $usuarioFich) {
            echo $usuarioFich['user'] . "<br>";
        }
        echo '<br>';
    } else {
        $mensaxe = "Non hai usuarios rexistrados";
    }
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    Usuario: <input type="text" name="usuario" autofocus><br><br>
    Contrasinal: <input type="text" name="contrasinal"><br><br>
    <input type="submit" name="rexistrar" value="Rexistrar">
    <input type="submit" name="borrar" value="Borrar">
    <input type="submit" name="listar" value="Listar">
</form>
<?php
if (isset($mensaxe)) {
    echo $mensaxe;
}
?>
