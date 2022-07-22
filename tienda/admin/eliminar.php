<?php
// Process delete operation after confirmation
if(isset($_POST["idProducto"]) && !empty($_POST["idProducto"])){
    // Include config file
    require_once "config.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM productos WHERE idProducto = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_idProducto);
        
        // Set parameters
        $param_idProducto = trim($_POST["idProducto"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: crudProductos.php");
            exit();
        } else{
            echo "Algo Salio Mal, Intentalo De Nuevo.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of idProducto parameter
    if(empty(trim($_GET["idProducto"]))){
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
    <title>ELiminar</title>
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
                        <h1>Eliminar Producto</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="idProducto" value="<?php echo trim($_GET["idProducto"]); ?>"/>
                            <p>Estas Seguro De Eliminar Este Producto?</p><br>
                            <p>
                                <input type="submit" value="Si" class="btn btn-danger">
                                <a href="crudProductos.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>