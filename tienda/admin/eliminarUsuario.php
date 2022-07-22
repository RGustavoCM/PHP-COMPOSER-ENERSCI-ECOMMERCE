<?php
// Process delete operation after confirmation
if(isset($_POST["idUsuario"]) && !empty($_POST["idUsuario"])){
    // Include config file
    require_once "config.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM Users WHERE idUsuario = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_idUsuario);
        
        // Set parameters
        $param_idUsuario = trim($_POST["idUsuario"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: crudUsuarios.php");
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
    // Check existence of idUsuario parameter
    if(empty(trim($_GET["idUsuario"]))){
        // URL doesn't contain idUsuario parameter. Redirect to error page
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
                        <h1>Eliminar Usuario</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="idUsuario" value="<?php echo trim($_GET["idUsuario"]); ?>"/>
                            <p>Estas Seguro De Eliminar Este Usuario?</p><br>
                            <p>
                                <input type="submit" value="Si" class="btn btn-danger">
                                <a href="crudUsuarios.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>