<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>






    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Pedidos</h2>
                    </div>
                    <?php
                    session_start();
 
						// Check if the user is logged in, if not then redirect him to login page
						if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
						    header("location: login/iniSesion.php");
						    exit;
						}
						$IdUsuario = $_SESSION["email"]; 
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT id, name, item_name, created, paid_amount, paid_amount_currency
                            FROM orders
                            WHERE email = ?;";


                        if($stmt = mysqli_prepare($link, $sql)){
				        // Bind variables to the prepared statement as parameters
				        mysqli_stmt_bind_param($stmt, "s", $param_id);
				        // Set parameters
				        $param_id = $IdUsuario;

                    if(mysqli_stmt_execute($stmt)){
                    	$result = mysqli_stmt_get_result($stmt);
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Nombre Cliente</th>";
                                        echo "<th>Nombre Producto</th>";
                                        echo "<th>Fecha De Compra</th>";
                                        echo "<th>Monto Total</th>";
                                        echo "<th>Moneda</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['item_name'] . "</td>";
                                        echo "<td>" . $row['created'] . "</td>";
                                        echo "<td>" . $row['paid_amount'] . "</td>";
                                        echo "<td>" . $row['paid_amount_currency'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No Hay Compras.</em></p>";
                        }
                    } else{
                        echo "ERROR: No Se Pudo Ejecutar  $sql. " . mysqli_error($link);
                    }
 }
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>     
            <a href="tiendaPrincipal.php" class="btn btn-warning pull-right">Regresar</a>   
        </div>
    </div>
</body>
</html>