<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="bootstrap.min.css">
        
        <style>
            body{
                background: linear-gradient(90deg, red, yellow);
            }
        </style>

        <title>Las brasas del bajío | Iniciar sesión</title>
    </head>

    <body>
        <div class="container">
            <div class="row mt-5">
                <div class="col-sm-10 col-5 col-lg-5 mx-auto my-3">
                    <div class="card text-white" style="background: linear-gradient(45deg, purple, darkblue);">
                        <div class="card-header">
                            <h4 class="text-center my-0">Iniciar sesión</h4>
                        </div>

                        <div class="col bg-white py-4">
                            <div class="row mx-auto">
                                <img src="logo.jpg" class="mx-auto">
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <form method="post">
                                <label for="correo" class="mt-4">E-mail:</label>
                                <div class="input-group">
                                    <input type="email" class="form-control form-control-lg" id="correo" name="email" required>
                                    <div class="input-group-append">
                                        <p class="input-group-text">
                                            <img src="email.svg" style="width: 30px;">
                                        </p>
                                    </div>
                                </div>

                                <label for="contraseña" class="mt-4">Contraseña:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg" id="contraseña" name="password" required>
                                    <div class="input-group-append">
                                        <p class="input-group-text">
                                            <img src="password.svg" style="width: 30px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="input-group my-4">
                                    <input type="image" src="login.svg" class="mx-auto" name="login" style="width: 75px;">
                                </div>
                            </form>

                            <?php
                                $conexion = mysqli_connect("localhost", "root", "", "restaurante");

                                if(!$conexion) {
                                    die("Conexion fallida");
                                }

                                if( isset($_POST["login_x"]) ) {
                                    $correo_usuario = $_POST["email"];
                                    $contraseña_usuario = $_POST["password"];

                                    $consulta = "SELECT * FROM usuarios WHERE correo = '$correo_usuario';";
                                    $resultado = mysqli_query($conexion, $consulta);
                                    
                                    if(mysqli_num_rows($resultado) == 0) {
                                        echo "
                                                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                                    <strong>Advertencia!</strong> No existe cuenta registrada con este correo.
                                                </div>
                                            ";
                                    }

                                    else {
                                        $dato = mysqli_fetch_assoc($resultado);
                                        $contraseña = $dato["contraseña"]; 
                                        
                                        if($contraseña_usuario == $contraseña) {
                                            session_start();

                                            $tipo = $dato["tipo"];

                                            $_SESSION["nombre"] = $dato["nombre"];
                                            $_SESSION["apellido"] = $dato["apellido"];
                                            $_SESSION["skin"] = $dato["skin"];

                                            mysqli_free_result($resultado);
                                            mysqli_close($conexion);

                                            // Para administradores
                                            if($tipo == 1) {
                                                header("Location: administracion.html");
                                                die("Redireccionando");
                                            }

                                            // Para clientes
                                            else {
                                                header("Location: cliente.html");
                                                die("Redireccionando");
                                            }
                                            
                                        }

                                        else {
                                            echo "
                                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                                    <strong>Alerta!</strong> La contraseña ingresada es incorrecta.
                                                </div>
                                            ";
                                        }
                                    }
                                    
                                }

                                /*else {
                                    echo "Error 404";
                                }*/
                            ?>
                        </div>

                        <div class="card-footer">
                            <p class="lead text-center my-0">¿Aún no tienes cuenta? <a href="register.html" class="text-warning">Regístrate aquí</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    </body>
</html>