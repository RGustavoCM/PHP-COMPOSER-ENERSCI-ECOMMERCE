<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$nombre = $descripcion = $precio = $imagen = "";
$nombre_err = $descripcion_err = $precio_err = $imagen_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate nombre
    $input_nombre = trim($_POST["nombre"]);
    if(empty($input_nombre)){
        $nombre_err = "Por Favor Ingrese El Nombre Del Producto.";
    }elseif(preg_match("/([%\$#\@*]+)/",  trim($_POST["nombre"]))){
        $nombre_err = "Ingrese Un Nombre Valido.";
    } else{
        $nombre = $input_nombre;
    }
    
    // Validate descripcion
    $input_descripcion = trim($_POST["descripcion"]);
    if(empty($input_descripcion)){
        $descripcion_err = "Ingres Una Descripcion.";     
    } else{
        $descripcion = $input_descripcion;
    }
    
    // Validate precio
    $input_precio = trim($_POST["precio"]);
    if(empty($input_precio)){
        $precio_err = "Ingresa Un Precio.";     
    }elseif(!is_float(floatval($input_precio))){
        $precio_err = "Tiene Que Ser Un Numero Decimal.";
    }else{
        $precio = floatval($input_precio);
    }

    // Validate precio
    $input_imagen = trim($_POST["imagen"]);
    if(empty($input_precio)){
        $imagen_err = "Ingresa El Numero De Piezas Existentes.";     
    } elseif(!ctype_digit($input_imagen)){
        $imagen_err = "Tiene Que Ser Un Numero Entero.";
    } else{
        $imagen = $input_imagen;
    }
    
    // Check input errors before inserting in database
    if(empty($nombre_err) && empty($descripcion_err) && empty($precio_err) && empty($imagen_err) ){
        // Prepare an insert statement
        $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssdi", $param_nombre, $param_descripcion, $param_precio, $param_imagen);
            
            // Set parameters
            $param_nombre = $nombre;
            $param_descripcion = $descripcion;
            $param_precio = $precio;
            $param_imagen = $imagen;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: crudProductos.php");
                exit();
            } else{
                echo "Algo Salio Mal, Intenta De Nuevo.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
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
                        <h2>Crear Producto</h2>
                    </div>
                    <p>Llena Este Formulario.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        <div class="form-group <?php echo (!empty($imagen_err)) ? 'has-error' : ''; ?>">
                            <label>imagen</label>
                            <input type="text" name="imagen" class="form-control" value="<?php echo $imagen; ?>">
                            <span class="help-block"><?php echo $imagen_err;?></span>
                        </div>                        
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="crudProductos.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>