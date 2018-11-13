<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Rexistro de usuarios</h2>
        <?php
        include("config.php");

        if (isset($_POST["rexistrar"])) {
            if((!empty($_POST["usuario"])) && (!empty($_POST["contrasinal"]))) {

                $usuario = $_POST["usuario"];
                $contrasinal = password_hash($_POST["contrasinal"], PASSWORD_DEFAULT, array("cost" => 12));
                $xaExiste = false;
                $usuariosFich = array();
                if (file_exists(FICHEIRO_USUARIOS)) {
                    $usuariosFich = json_decode(file_get_contents(FICHEIRO_USUARIOS), true);
                    foreach ($usuariosFich as $usuarioFich) {
                        if ($usuarioFich["user"] == $usuario) {
                            $xaExiste = true;
                            $mensaxe = "Usuario xa existe";
                            break;
                        }
                    }
                    echo "<pre>";
                    print_r(json_decode(file_get_contents(FICHEIRO_USUARIOS), true));
                    echo "</pre>";
                    
                }
                if (!$xaExiste) {
                    $usuariosFich[] = array("user" => $usuario, "pass" => $contrasinal);
                    $usuariosJson = json_encode($usuariosFich);
                    file_put_contents(FICHEIRO_USUARIOS, $usuariosJson);
                }
            } else{
               $mensaxe = "Debe introducir usuario e contrasinal.";
            }
        }
        
        if (isset($_POST["borrar"])) {
            if(!empty($_POST["usuario"])){
                $usuario = $_POST["usuario"];
                $usuariosFich = array();
                if(file_exists(FICHEIRO_USUARIOS)){
                    $usuariosFich = json_decode(file_get_contents(FICHEIRO_USUARIOS),true);
                    foreach($usuariosFich as $indice => $usuarioFich){
                        if($usuarioFich["user"]==$usuario){
                            unset($usuariosFich[$indice]);
                            $usuariosFich = array_values($usuariosFich);
                            $mensaxe = "Usuario borrado";
                            $borrado = true;
                            break;
                        }
                    }
                    if($borrado){
                        if(count($usuariosFich)==0){
                            unlink (FICHEIRO_USUARIOS);
                        }else{
                            
                        }
                    }
                }else{
                    $mensaxe = "Non han usuarios rexistrados";
                }
                
            } else{
                $mensaxe = "Debe introducir nome de usuario a borrar.";
            }
        }
        
        if (isset($_POST["listar"])) {
            
        }
        ?>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            Usuario:<input type="text" name="usuario">
            <br>
            Contrasinal:<input type="text" name="contrasinal">
            <br><br>
            <button type="submit" name="rexistrar">Rexistrar</button>
            <button type="submit" name="borrar">Borrar</button>
            <button type="submit" name="listar">Listar</button>
        </form>
    </body>
</html>
