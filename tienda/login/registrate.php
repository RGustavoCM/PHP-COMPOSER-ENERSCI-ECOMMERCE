<?php
// Include config file
require_once "..\config.php";
 
// Define variables and initialize with empty values
$email = $contrasena = $confirm_contrasena = $nomUsuario = $apeUsuario = $estado = $municipio = $calle = $numero = "";
$email_err = $contrasena_err = $confirm_contrasena_err = $nomUsuario_err = $apeUsuario_err = $estado_err = $municipio_err = $calle_err = $numero_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Ingresa Un Correo Electronico.";
    } else{
        // Prepare a select statement
        $sql = "SELECT idUsuario FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "Ya Existe Ese Correo.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["contrasena"]))){
        $contrasena_err = "Por Favor INgresa Una Contrasena.";     
    } elseif(strlen(trim($_POST["contrasena"])) < 6){
        $contrasena_err = "Debe Tener Minimo 8 Caracteres.";
    } else{
        $contrasena = trim($_POST["contrasena"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_contrasena"]))){
        $confirm_contrasena_err = "Confirma Tu Contrasena.";     
    } else{
        $confirm_contrasena = trim($_POST["confirm_contrasena"]);
        if(empty($contrasena_err) && ($contrasena != $confirm_contrasena)){
            $confirm_contrasena_err = "Mo Coinciden Las 2.";
        }
    }
    
    // Validacion Nombre
    if(empty(trim($_POST["nomUsuario"]))){
        $nomUsuario_err = "Por Favor Ingrese Sus Nombres";     
    } elseif(preg_match("/([%\$#\@*]+)/",  trim($_POST["nomUsuario"]))){
        $nomUsuario_err = "Su Nombre No Debe Tener Caracteres Especiales.";
    } else{
        $nomUsuario = trim($_POST["nomUsuario"]);
    }

        // Validacion Apellidos
    if(empty(trim($_POST["apeUsuario"]))){
        $apeUsuario_err = "Por Favor Ingrese Sus Apellidos";     
    } elseif(preg_match("/([%\$#\*@]+)/",  trim($_POST["apeUsuario"]))){
        $apeUsuario_err = "Sus Apellidos No Debe Tener Caracteres Especiales.";
    } else{
        $apeUsuario = trim($_POST["apeUsuario"]);
    }

        // Validacion Estado
    if(empty(trim($_POST["estado"]))){
        $estado_err = "Por Favor Ingrese Su Estado";     
    } elseif(preg_match("/([%\$#\*@]+)/",  trim($_POST["estado"]))){
        $estado_err = "Su Estado No Debe Tener Caracteres Especiales.";
    } else{
        $estado = trim($_POST["estado"]);
    }    

        // Validacion Municipio
    if(empty(trim($_POST["municipio"]))){
        $municipio_err = "Por Favor Ingrese Su Municipio";     
    } elseif(preg_match("/([%\$#\@*]+)/",  trim($_POST["municipio"]))){
        $municipio_err = "Su Municipio No Debe Tener Caracteres Especiales.";
    } else{
        $municipio = trim($_POST["municipio"]);
    } 
    if(empty(trim($_POST["calle"]))){
        $calle_err = "Por Favor Ingrese Su calle";     
    } elseif(preg_match("/([%\$#\@*]+)/",  trim($_POST["calle"]))){
        $calle_err = "Su calle No Debe Tener Caracteres Especiales.";
    } else{
        $calle = trim($_POST["calle"]);
    } 
    // Validcion Numero
    if(empty(trim($_POST["numero"]))){
        $numero_err = "Por Favor Ingresa Tu Numero.";     
    } elseif(strlen(trim($_POST["numero"])) > 3){
        $numero_err = "No Puede Tener Mas De 3 Caracteres.";
    } else{
        $numero = trim($_POST["numero"]);
    }    

          




    // Check input errors before inserting in database
    if(empty($email_err) && empty($contrasena_err) && empty($confirm_contrasena_err) && empty($nomUsuario_err) && empty($apeUsuario_err) && empty($estado_err) && empty($municipio_err) && empty($calle_err) && empty($numero_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users ( nomUsuario, apeUsuario, email, contrasena, estado, municipio, calle, numero) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_nomUsuario, $param_apeUsuario, $param_email, $param_contrasena, $param_estado, $param_municipio, $param_calle, $param_numero);
            
            // Set parameters
            $param_nomUsuario = $nomUsuario;
            $param_apeUsuario = $apeUsuario;
            $param_email = $email;
            $param_contrasena = $contrasena; // Creates a password hash
            $param_estado = $estado;
            $param_municipio = $municipio;
            $param_calle = $calle;
            $param_numero = $numero;

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: iniSesion.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
<head>
    <title>Enersci Tienda Online</title>
</head>
<body>
    <!-- Barra Nav -->
<nav class="navbar navbar-expand-lg navbar-warning bg-light static-top">
  <div class="container">
    <a class="navbar-brand" href="#">
          <img src="..\img/logos/logo.png" width="100" height="60" alt="">
        </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="..\tiendaPrincipal.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="iniSesion.php">Iniciar Sesion</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="registrate.php">Registrate</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Regresar</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="jumbotron card card-image"  style="background-image: url(../img/fondos/fondoreg.jpg);">

    <div class="row">
        <div class="col-md-2"></div>
            <div class="col-md-4 bg-dark text-white">
                <div class="wrapper">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nomUsuario_err)) ? 'has-error' : ''; ?>">
                            <label>Nombres</label>
                            <input type="text" name="nomUsuario" class="form-control" value="<?php echo $nomUsuario; ?>">
                            <span class="help-block text-danger"><?php echo $nomUsuario_err; ?></span>
                        </div> 
                        <div class="form-group <?php echo (!empty($apeUsuario_err)) ? 'has-error' : ''; ?>">
                            <label>Apellidos</label>
                            <input type="apeUsuario" name="apeUsuario" class="form-control" value="<?php echo $apeUsuario; ?>">
                            <span class="help-block text-danger"><?php echo $apeUsuario_err; ?></span>
                        </div>                                                 
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block text-danger"><?php echo $email_err; ?></span>
                        </div>    
                        <div class="form-group <?php echo (!empty($contrasena_err)) ? 'has-error' : ''; ?>">
                            <label>Contrasena</label>
                            <input type="password" name="contrasena" class="form-control" value="<?php echo $contrasena; ?>">
                            <span class="help-block text-danger"><?php echo $contrasena_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($confirm_contrasena_err)) ? 'has-error' : ''; ?>">
                            <label>Confirma Contrasena</label>
                            <input type="password" name="confirm_contrasena" class="form-control" value="<?php echo $confirm_contrasena; ?>">
                            <span class="help-block text-danger"><?php echo $confirm_contrasena_err; ?></span>
                        </div>
                </div> 
                        <p>Ya Tienes Cuenta?  <a href="iniSesion.php">Inicia Sesion Aqui</a>.</p>                
            </div>
            <div class="col-md-4 bg-dark text-white ">
                <div class="wrapper">
                        <div class="form-group <?php echo (!empty($estado_err)) ? 'has-error' : ''; ?>">
                            <label>Estado</label>
                            <input type="text" name="estado" class="form-control" value="<?php echo $estado; ?>">
                            <span class="help-block text-danger"><?php echo $estado_err; ?></span>
                        </div> 
                        <div class="form-group <?php echo (!empty($municipio_err)) ? 'has-error' : ''; ?>">
                            <label>Municipio</label>
                            <input type="text" name="municipio" class="form-control" value="<?php echo $municipio; ?>">
                            <span class="help-block text-danger"><?php echo $municipio_err; ?></span>
                        </div>                                                 
                        <div class="form-group <?php echo (!empty($calle_err)) ? 'has-error' : ''; ?>">
                            <label>Calle</label>
                            <input type="text" name="calle" class="form-control" value="<?php echo $calle; ?>">
                            <span class="help-block text-danger"><?php echo $calle_err; ?></span>
                        </div>    
                        <div class="form-group <?php echo (!empty($numero_err)) ? 'has-error' : ''; ?>">
                            <label>Numero</label>
                            <input type="number" name="numero" class="form-control" value="<?php echo $numero; ?>">
                            <span class="help-block text-danger "><?php echo $numero_err; ?></span>
                        </div>
                        <div class="form-group ">
                            <input type="submit" class="btn btn-danger" value="Enviar">
                        </div>
                </div> 
            </div            
                 </form>
            <div class="col-md-2"></div>
    </div>
</div>    


</body>
</html>