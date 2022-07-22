<?php 
$connect = mysqli_connect("localhost", "root", "", "tiendae");

if(isset($_POST["idProducto"]) && !empty($_POST["idProducto"])){
session_start();
$_SESSION["idProducto"] = $_POST["idProducto"] ; 
$_SESSION["precioProd"] = $_POST["precio"] ; 
$_SESSION["nomProd"] = $_POST["nombre"] ; 
    header("location: pago/indexPago.php");
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Productos</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
      <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>




  <body>
 <nav class="navbar navbar-expand-sm bg-light navbar-light">
   <a class="navbar-brand" href="tiendaPrincipal.php" >
    <img src="img/logos/logo.png" alt="Logo" width="100" height="60">
  </a>
        <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="productos.php">Productos</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="tiendaPrincipal.php">Regresar</a>
        </li>
      </ul>
</nav> 




    <br />
    <div class="container">
      <div class="row">
      <br />
      <br />
      <br />
    
      <?php
        $query = "SELECT * FROM productos ORDER BY idProducto ASC";
        $result = mysqli_query($connect, $query);
        if(mysqli_num_rows($result) > 0)
        {
          while($row = mysqli_fetch_array($result))
          {
        ?>
      <div class="col-md-4">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">   
          <div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
            <img src="img/productos/<?php echo $row["imagen"]; ?>.jpg" class="img-fluid" /><br />

            <h4 class="text-info"><?php echo $row["nombre"]; ?></h4>

            <h4 class="text-danger">$ <?php echo $row["precio"]; ?></h4>

            <input type="hidden" name="nombre" value="<?php echo $row["nombre"]; ?>" />

            <input type="hidden" name="precio" value="<?php echo $row["precio"]; ?>" />
            <input type="hidden" name="idProducto" value="<?php echo $row["idProducto"]; ?>" />

            <input type="submit" value="Comprar" class="btn btn-success">

          </div>
        </form>
      </div>
      <?php
          }
        }
      ?>

    </div>
    </div>

  </div>
  <br />
  </body>
</html>
