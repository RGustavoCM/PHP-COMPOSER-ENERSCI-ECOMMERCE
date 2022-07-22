<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                         if($_SESSION["tipoUsuario"] == 'admin'){
                         header("Location: ../admin/inicioAdmin.php"); // This line triggers a redirect if thuser_type is admin
                     } else {
                  header("location: ../tiendaPrincipal.php"); // This line triggers for other user_types
                     }
    exit;
}
  
// Include config file
require_once "..\config.php";
 
// Define variables and initialize with empty values
$email = $contrasena = "";
$email_err = $contrasena_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Por Favor Ingresa Tu Correo.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if contrasena is empty
    if(empty(trim($_POST["contrasena"]))){
        $contrasena_err = "Por Favor Ingresa Una Contrasenia.";
    } else{
        $contrasena = trim($_POST["contrasena"]);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($contrasena_err)){
        // Prepare a select statement
        $sql = "SELECT idUsuario, email, contrasena, tipoUsuario FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if email exists, if yes then verify contrasena
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $idUsuario, $email, $hashed_contrasena, $tipoUsuario);
                    if(mysqli_stmt_fetch($stmt)){
                        if($contrasena == $hashed_contrasena){
                            // contrasena is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["idUsuario"] = $idUsuario;
                            $_SESSION["email"] = $email;
                            $_SESSION["tipoUsuario"] = $tipoUsuario;                             

                                if($tipoUsuario == 'admin'){
                                    header("Location: ../admin/inicioAdmin.php"); // This line triggers a redirect if the user_type is admin
                                } else {
                                    header("location: ../tiendaPrincipal.php"); // This line triggers for other user_types
                                }

                        } else{
                            // Display an error message if contrasena is not valid
                            $contrasena_err = "Tu Contrasenia No Es Correcta.";
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_err = "No Hay Registro De Ese Correo.";
                }
            } else{
                echo "Algo Ha Salido Mal Intentalo Mas Tarde.";
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
    <title>Enersc Tienda Online</title>
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
                <div class="col-md-4"></div>
                    <div class="col-md-4 bg-dark text-white">                
                            <div class="wrapper">
                                <h2>Inicia Sesion</h2>
                                <p>Llena Estos Datos Para IniciarSesion.</p>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                        <label>Correo Electronico</label>
                                        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                                        <span class="help-block"><?php echo $email_err; ?></span>
                                    </div>    
                                    <div class="form-group <?php echo (!empty($contr8asena_err)) ? 'has-error' : ''; ?>">
                                        <label>Contrasenia</label>
                                        <input type="password" name="contrasena" class="form-control">
                                        <span class="help-block"><?php echo $contrasena_err; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-danger" value="Login">
                                    </div>
                                    <p>Aun No Tienes Cuenta? <a href="registrate.php">Registrate Ahora</a>.</p>
                                </form>
                            </div>    
                         </div> 
                     </div> 
                 <div class="col-md-4"></div>
             </div> 
         </div>
     </body>
 </html>