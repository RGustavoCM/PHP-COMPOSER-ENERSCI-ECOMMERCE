<?php
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login/iniSesion.php");
    exit;
}
$IdUsuario = $_SESSION["idUsuario"]; 
   require_once "config.php";
// Check existence of id parameter before processing further
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $idProducto = $_POST["id"];
    $Precio = $_POST["precio"];

        $sql = "INSERT INTO pedidos (idProducto,idUsuario, precio ) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iid", $param_idProducto, $param_idUsuario, $param_precio);
            
            // Set parameters
            $param_idProducto = $idProducto;
            $param_idUsuario = $IdUsuario;
            $param_precio = $Precio;


            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: compras.php");
                exit();
            } else{
                echo "Algo Salio Mal, Intenta De Nuevo.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }else{
            if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            // Include config file

            
            // Prepare a select statement
            $sql = "SELECT * FROM productos WHERE idProducto = ?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "i", $param_id);
                
                // Set parameters
                $param_id = trim($_GET["id"]);
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    $result = mysqli_stmt_get_result($stmt);
            
                    if(mysqli_num_rows($result) == 1){
                        /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        
                        // Retrieve individual field value
                        $nombre = $row["nombre"];
                        $descripcion = $row["descripcion"];
                        $precio = $row["precio"];
                        $imagen = $row["imagen"];
                    } else{
                        // URL doesn't contain valid id parameter. Redirect to error page
                        header("location: error.php");
                        exit();
                    }
                    
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
             
            // Close statement
            mysqli_stmt_close($stmt);

            // Close connection
            mysqli_close($link);
        } else{
            // URL doesn't contain id parameter. Redirect to error page
            header("location: error.php");
            exit();
        }

}






?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Comprar Producto</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
       <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
            <style>
                .card {
                      padding-top: 5px;
                      padding-right: 5px;
                      padding-bottom: 5px;
                      padding-left: 5px;
                    }

                    div.col-md-4 {
                          padding-top: 20px;
                          padding-right: 20px;
                          padding-bottom: 5px;
                          padding-left: 20px;
                        } 
                        p {
                          text-align: center;
                            border: 1px solid lightgray;
                            border-radius: 5px;
                        } 
                        h2 {
                          text-align: center;
                          font-size: 20px;
                        }                                                                 
            </style>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>

  <body>
<!-- Barra Nav -->
<nav class="navbar navbar-expand-lg navbar-warning bg-light static-top">
  <div class="container">
    <a class="navbar-brand" href="#">
          <img src="img/logos/logo.png" width="100" height="60" alt="">
        </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="tiendaPrincipal.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="productos.php">Regresar</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<body>

<div class="container">
</div>

        <div class="container">
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-4 bg-primary ">
                    <div class="form-group">
                        <div class="card  " style="width:350px">
                          <img class="card-img-top" src="img/productos/<?php echo $row["imagen"]; ?>.jpg">
                          <div class="card-body">
                            <h3 class="form-control-static"><?php echo $row["nombre"]; ?></h3>
                          </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-4 bg-primary">
                    <div class="card">
                        <h2>Descripcion:</h2>
                        <p class="form-control-static"><?php echo $row["descripcion"]; ?></p>

                        <h2>Precio:</h2>
                        <p class="form-control-static"><?php echo $row["precio"]; ?></p>
                    <div >
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">                        
                    <a href="productos.php" class="btn btn-default">Atras</a> 
                    <input type="hidden" name="id" value="<?php echo $row['idProducto']; ?>"/>
                    <input type="hidden" name="precio" value="<?php echo $row['precio']; ?>"/>
                    <input type="submit" value="Comprar" class="btn btn-success">
                    </div> 
                    </div>  
                    <div class="col-md-2"></div>             
            </div>      
        </div>
</body>
</html>
