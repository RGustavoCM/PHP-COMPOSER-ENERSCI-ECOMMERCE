<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$nombre = $descripcion = $precio = $imagen = "";
$nombre_err = $descripcion_err = $precio_err = $imagen_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["idProducto"]) && !empty($_POST["idProducto"])){
    // Get hidProductoden input value
    $idProducto = $_POST["idProducto"];
    
    // ValidProductoate nombre
    $input_nombre = trim($_POST["nombre"]);
    if(empty($input_nombre)){
        $nombre_err = "Por Favor Ingrese El Nombre Del Producto.";
    } elseif(preg_match("/([%\$#\@*]+)/",  trim($_POST["nombre"]))){
        $nombre_err = "Ingrese Un Nombre ValidProductoo.";
    } else{
        $nombre = $input_nombre;
    }
    
    // ValidProductoate descripcion descripcion
    $input_descripcion = trim($_POST["descripcion"]);
    if(empty($input_descripcion)){
        $descripcion_err = "Ingres Una Descripcion.";     
    } else{
        $descripcion = $input_descripcion;
    }
    
    // ValidProductoate precio
    $input_precio = trim($_POST["precio"]);
    if(empty($input_precio)){
        $precio_err = "Ingresa Un Precio.";     
    }elseif(!is_float(floatval($input_precio))){
        $precio_err = "Tiene Que Ser Un Numero Decimal.";
    }else{
        $precio = floatval($input_precio);
    }

    // ValidProductoate precio
    $input_imagen = trim($_POST["imagen"]);
    if(empty($input_imagen)){
        $imagen_err = "Ingresa El Numero De Piezas Existentes.";     
    } elseif(!ctype_digit($input_imagen)){
        $imagen_err = "Tiene Que Ser Un Numero Entero.";
    } else{
        $imagen = $input_imagen;
    } 
    
    // Check input errors before inserting in database
    if(empty($nombre_err) && empty($descripcion_err) && empty($precio_err) && empty($imagen_err) ){
        // Prepare an update statement
        $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, imagen=?  WHERE idProducto=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssdii", $param_nombre, $param_descripcion, $param_precio, $param_imagen, $param_idProducto);
            
            // Set parameters
            $param_nombre = $nombre;
            $param_descripcion = $descripcion;
            $param_precio = $precio;
            $param_imagen = $imagen;
            $param_idProducto = $idProducto;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: crudProductos.php");
                exit();
            } else{
                echo "Algo Salío MalIntentalo De Nuevo";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of idProducto parameter before processing further
    if(isset($_GET["idProducto"]) && !empty(trim($_GET["idProducto"]))){
        // Get URL parameter
        $idProducto =  trim($_GET["idProducto"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM productos WHERE idProducto = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_idProducto);
            
            // Set parameters
            $param_idProducto = $idProducto;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individProductoual field value
                    $nombre = $row["nombre"];
                    $descripcion = $row["descripcion"];
                    $precio = $row["precio"];
                    $imagen = $row["imagen"];
                } else{
                    // URL doesn't contain validProducto idProducto. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Algo Salío MalIntentalo De Nuevo.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain idProducto parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Actualizar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Actualizar Producto</h2>
                    </div>
                    <p>Llena Este Formulario.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nombre_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
                            <span class="help-block"><?php echo $nombre_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($descripcion_err)) ? 'has-error' : ''; ?>">
                            <label>Descripcion</label>
                            <textarea name="descripcion" class="form-control"><?php echo $descripcion; ?></textarea>
                            <span class="help-block"><?php echo $descripcion_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($precio_err)) ? 'has-error' : ''; ?>">
                            <label>Precio</label>
                            <input type="text" name="precio" class="form-control" value="<?php echo $precio; ?>">
                            <span class="help-block"><?php echo $precio_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($precio_err)) ? 'has-error' : ''; ?>">
                            <label>imagen</label>
                            <input type="number" name="imagen" class="form-control" value="<?php echo $imagen; ?>">
                            <span class="help-block"><?php echo $imagen_err;?></span>
                        </div>                        
                        <input type="hidden" name="idProducto" value="<?php echo $idProducto; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Actualizar">
                        <a href="crudProductos.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>