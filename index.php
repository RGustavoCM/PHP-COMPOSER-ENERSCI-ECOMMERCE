<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                         if($_SESSION["tipoUsuario"] == 'admin'){
                         header("Location: tienda/admin/inicioAdmin.php"); // This line triggers a redirect if thuser_type is admin
                     } else {
                  header("location: tienda/tiendaPrincipal.php"); // This line triggers for other user_types
                     }
    exit;
}

?>