<?php
// Check existence of id parameter before processing further
if(isset($_GET["idUsuario"]) && !empty(trim($_GET["idUsuario"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM users WHERE idUsuario = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["idUsuario"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $nomUsuario = $row["nomUsuario"];
                $apeUsuario = $row["apeUsuario"];
                $email = $row["email"];
                $estado = $row["estado"];
                $municipio = $row["municipio"];
                $calle = $row["calle"];
                $numero = $row["numero"];
                $tipoUsuario = $row["tipoUsuario"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Algo Salio Mal.";
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ver Usuario</title>
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
                        <h1>Ver Usuario</h1>
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <p class="form-control-static"><?php echo $row["nomUsuario"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Apellidos</label>
                        <p class="form-control-static"><?php echo $row["apeUsuario"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Correo</label>
                        <p class="form-control-static"><?php echo $row["email"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Estado </label>
                        <p class="form-control-static"><?php echo $row["estado"]; ?></p>
                    </div>  
                    <div class="form-group">
                        <label>Municipio</label>
                        <p class="form-control-static"><?php echo $row["municipio"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Calle</label>
                        <p class="form-control-static"><?php echo $row["calle"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Numero</label>
                        <p class="form-control-static"><?php echo $row["numero"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Tipo Usuario</label>
                        <p class="form-control-static"><?php echo $row["tipoUsuario"]; ?></p>
                    </div> 
                    <p><a href="crudUsuarios.php" class="btn btn-primary">Atras</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>