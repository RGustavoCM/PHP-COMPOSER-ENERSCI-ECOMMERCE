<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login/iniSesion.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tienda Online Enersci</title>
  <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/fixed.css">
</head>

<body data-spy="scroll" data-target="#navbarResponsive">


<!--- Inicia La Primera Seccion -->

<div id="inicio">
  

<!--- Inicia La Barra De NAvegacion -->

<nav class="navbar navbar-expand-md navbar-dark bg-light fixed-top">
  <a class="navbar-brand" href="#"><img src="img/logos/logo.png" width="100" height="60" alt="" > </a>
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
        <a class="nav-link" href="#funci">Productos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#compras">Mis Compras</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#contacto">Contacto</a>
      </li>      
      <li class="nav-item">
        <a class="nav-link"  href="login/logout.php">Cerrar Sesion</a>
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
  <h1>Bienvenido A La Tienda En Linea De Enersci!!!</h1>
  <a class="btn btn-outline-danger btn-lg" href="login/logout.php">Cerrar Sesion</a>
</div>
  
<!--- Termina La Parte De Inico --> 
</div>

<!--- Termina La Segunda Seccion -->


<!--- Inicia La Segunda Seccion -->
<div id="funci" class="offset">
  <div class="col-12 narrow text-center">
    <h1 class="negro"> Ahora Puedes Compar Y Consultar Mas Facil!!</h1>
    <p class="lead">Contamos Con Varios Alternativas Para Ahorrar Energia!!</p>
    <a class="btn btn-outline-warning btn-lg" href="productos.php">Ver Productos!!</a>
  </div>
</div>
<!--- Termina La Segunda Seccion -->


<!--- Inicia La tercera Seccion -->
<div id="info" class="offset">
  <!--- Inicia El Jumbotron -->
  <div class="jumbotron">
    <div class="narrow">
      <div class="col-12 text-center">
        <h3 class="heading">Productos</h3>
        <div class="heading-underline"></div>
      </div>
      
      <div class="row text-center">
        <div class=" col-md-4">
          <div class="obj">
            <i class="  fas fa-th fa-4x" data-fa-transform="shrink-3 up-5"></i>
            <h3 class="negro">Paneles Solares!!</h3>
            <p class="negro">Hay Varias Opciones De Acuerdo A Tu Consumo!!</p>
          </div>
        </div>
        <div class=" col-md-4">
          <div class="obj">
            <i class="  fas fa-wrench fa-4x" data-fa-transform="shrink-3 up-5"></i>
            <h3 class="negro">Accesorios !!</h3>
            <p class="negro">Cables Y Conectorios Necesarios!!</p>
          </div>
        </div>
        <div class=" col-md-4">
          <div class="obj">
            <i class="  fab fa-codepen fa-4x" data-fa-transform="shrink-3 up-5"></i>
            <h3 class="negro">Estructuras!!</h3>
            <p class="negro">Bases De Aluminio PAra Paneles En Masa!!</p>
          </div>
        </div>
      </div>

    </div><!-- Termina Narrow -->
  </div><!--- Termina El Jumbotron -->
  
</div>
<!--- Termina La tercera Seccion -->

<!--- Inicia La quinta Seccion -->
<div id="compras" class="offset">
  <div class="col-12 narrow text-center">
    <h1 class="negro"> Quieres Ver Tus Compras!!</h1>
    <a class="btn btn-outline-warning btn-lg" href="compras.php">Ver Compras!!</a>
  </div>
</div>
<!--- Termina La quinta Seccion -->

<!--- Inicia La Cuarta Seccion -->
<div id="contacto" class="offset">
  
<footer>
  <div class="row justify-content-center">
    <div class="col-md-5 text-center">
      <img src="img/logos/logo.png" width="100" height="60" alt="" >      
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

        
    