<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Modal tutorial from BootstrapBay.com">
    <meta name="author" content="BootstrapBay.com">
      <link rel="stylesheet" href="css/main.css">
      <link rel="stylesheet" href="css/Estilos.css">

  <script src="js/jquery-3.1.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/material.min.js"></script>
  <script src="js/ripples.min.js"></script>
  <script src="js/sweetalert2.min.js"></script>
  <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="js/main.js"></script>
  <script>
    $.material.init();
  </script>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <style type="text/css">
      img.zoom {
    width: 100%;
    height: 100%;
    -webkit-transition: all .2s ease-in-out;
    -moz-transition: all .2s ease-in-out;
    -o-transition: all .2s ease-in-out;
    -ms-transition: all .2s ease-in-out;
}
 
.transition {
    -webkit-transform: scale(1.8); 
    -moz-transform: scale(1.8);
    -o-transform: scale(1.8);
    transform: scale(1.8);
}
    </style>  

  </head>
 <body >  
  <img src="img/ministerio-pгblico.jpg" class="zoom"/>
  <?php 
include('validarnavegador.php');
$opbeterNavegador= getBrowser($user_agent);

if ($opbeterNavegador !='Google Chrome') {
  echo "<script>";
    echo "alert('Asegurese de que su navegador sea Google Chrome');";
    echo "window.location = 'index.php';";
    echo "</script>";
}

  ?>
  <div id="mostrar_datos"></div>
  <form method="POST" action="consultas.php" autocomplete="off" class="full-box logInForm">
    <p class="text-center text-muted"><i class="zmdi zmdi-account-circle zmdi-hc-5x"></i></p>
    <p class="text-center text-muted text-uppercase">Inicia sesión con tu cuenta</p>
    <div class="form-group label-floating">
      <label style="font-family: Arial" for="UserEmail"><strong>Codigo del Empleado</strong></label>
      <input class="form-control" name="UserEmail" type="text" placeholder="Escriba su E-mail" maxlength="6" required>
    </div>
    <div class="form-group label-floating">
      <label style="font-family: Arial" for="UserPass"><strong>Contraseña</strong></label>
      <input class="form-control" name="UserPass" type="password" placeholder="Escribe tú contraseña" required>

    </div>
    <div class="form-group text-center">
      <input type="submit" value="Iniciar sesión" id="Iniciar_sesion" name="Iniciar_sesion" class="btn btn-raised btn-danger">
    </div>
  </form>


 </body>  
</html>
 
