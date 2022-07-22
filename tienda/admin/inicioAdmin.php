<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ..\login/iniSesion.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tienda Online Enersci</title>
  <link rel="stylesheet" href="..\bootstrap-4.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="..\css/styleAdmin.css">
  <link rel="stylesheet" href="..\css/fixed.css">
</head>

<body data-spy="scroll" data-target="#navbarResponsive">


<!--- Inicia La Primera Seccion -->

<div id="inicio">
  

<!--- Inicia La Barra De NAvegacion -->

<nav class="navbar navbar-expand-md navbar-dark bg-light fixed-top">
  <a class="navbar-brand" href="#"><img src="..\img/logos/logo.png" width="100" height="60" alt="" > </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" > 
    <span class="navbar-toggler-icon" > </span> 
  </button>

  <div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav ml-auto" >
      <li class="nav-item">
        <a class="nav-link" href="#inicio">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#info">Info</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#usuarios">Usuarios</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#productos">Productos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#pedidos">Pedidos</a>
      </li>      
      <li class="nav-item">
        <a class="nav-link"  href="..\login/logout.php">Cerrar Sesion</a>
      </li> 
    </ul>
  </div>
</nav>
<!--- Termina La Barra De Navegacion -->

<!--- Inicia La Parte De Inico -->  
<div class="inicio">
  <div class="home-wrap">
    <div class="home-inner">  
    </div>
  </div>
</div>

<div class=" blanco caption text-center">
  <h1>Bienvenido Administrador!!!</h1>
</div>
  
<!--- Termina La Parte De Inico --> 
</div>

<!--- Termina La Segunda Seccion -->


<!--- Inicia La Segunda Seccion -->
<div id="pedidos" class="offset">
  <div class="col-12 narrow text-center">
    <h1 class="negro"> Consulta Los Pedidos!!</h1>
    <a class="btn btn-secondary btn-md" href="crudPedidos.php">Ver Pedidos</a>
  </div>
</div>
<!--- Termina La Segunda Seccion -->

<!--- Inicia La Segunda Seccion -->
<div id="productos" class="offset">
  <div class="col-12 narrow text-center">
    <p class="lead">Gestiona Los Productos!!!</p>
    <a class="btn btn-secondary btn-md" href="crudProductos.php">Ver Productos</a>
  </div>
</div>
<!--- Termina La Segunda Seccion -->

<!--- Inicia La Segunda Seccion -->
<div id="usuarios" class="offset">
  <div class="col-12 narrow text-center">
    <p class="lead">Gestiona Los Usuarios!!!</p>
    <a class="btn btn-secondary btn-md" href="crudUsuarios.php">Ver Usuarios</a>
  </div>
</div>
<!--- Termina La Segunda Seccion -->















<!--- Inicia La Cuarta Seccion -->
<div id="contacto" class="offset">
  
<footer>
  <div class="row justify-content-center">
    <div class="col-md-5 text-center">
      <img src="..\img/logos/logo.png" width="100" height="60" alt="" >      
      <p> Este Es Un Cascaron O Una Muestra De Como Planeamos Crear La Interfaz Para El Usuario!!</p>
      <strong> Info. De Contacto</strong>
      <p>418-105-0011<br>rgustavo674@gmail.com</p>
      <a href="www.facebook.com" target="_blank"><i class="fab fa-facebook-square"></i></a>
      <a href="www.twitter.com" target="_blank"><i class="fab fa-twitter-square"></i></a>
      <a href="www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
    </div>  
    <hr class="socket"> 
    &copy; Enersci.
  </div>
</footer>


</div>
<!--- Termina La Cuarta Seccion -->







<!--- Script Source Files -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.5.0/js/all.js"></script>
<!--- End of Script Source Files -->

</body>
</html>

        
    