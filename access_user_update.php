<?php 

  require_once 'header.php';
  $controller = new ControllerAuthentication();
  

  $extras = new Extras();
  $authentication_id = $extras->decryptQuery1(KEY_SALT, $_SERVER['QUERY_STRING']);
  $user = $controller->getAccessUserByAuthenticationId($authentication_id);

  if($authentication_id != null) {
      if( isset($_POST['submit']) ) {
    
        $itm = new Authentication();
        $itm->authentication_id = $user->authentication_id;
        $itm->name = trim(strip_tags($_POST['name']));
        $itm->username = $user->username;

        $pass = trim(strip_tags($_POST['password']));
        $password_confirm = trim(strip_tags($_POST['password_confirm']));
        $password_current = trim(strip_tags($_POST['password_current']));
        $itm->password = md5( $pass );
        
        if(strlen($pass) < 8) {
            echo "<script >alert('Password field must be atleast 8 alphanumeric characters.');</script>";
        }
        else if($user->password != md5($password_current)) {
            echo "<script >alert('Current password does not match.');</script>";
        }
        else if($pass != $password_confirm) {
            echo "<script >alert('Password does not match.');</script>";
        }
        else {
            $controller->updateAccessUser($itm);
            echo "<script type='text/javascript'>location.href='admin_access.php';</script>";
        }

      }
  }

  else {
    echo "<script type='text/javascript'>location.href='403.php';</script>";
  }

?>


<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="http://www.iconj.com/ico/1/s/1s4lfgqz0m.ico" type="image/x-icon" />

    <title>LA VUELTA</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="bootstrap/css/navbar-fixed-top.css" rel="stylesheet">
    <link href="bootstrap/css/custom.css" rel="stylesheet">
    <script type="text/javascript">
        
        function validateField(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode( key );

            
            if(theEvent.keyCode == 8 || theEvent.keyCode == 127 || theEvent.keyCode == 9) {
                
            }
            else {
                var regex = /^([a-z0-9]+-)*[a-z0-9]+$/i;
                if( !regex.test(key) ) {
                  theEvent.returnValue = false;
                  if(theEvent.preventDefault) theEvent.preventDefault();
                }  
            }
        }
    </script>
    
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">


        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">LA VUELTA</a>
        </div>


        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li ><a href="home.php">Inicio</a></li>
            <li ><a href="categories.php">Categoria</a></li>
            <li ><a href="stores.php">Evento</a></li>
            <li ><a href="news.php">Pasado</a></li>
            <li class="active"><a href="admin_access.php">Admin</a></li>
            <li ><a href="users.php">Usuarios</a></li>
			<li><a href="ticket.php">Ticket</a></li>
          </ul>
          
          <ul class="nav navbar-nav navbar-right">
            <li ><a href="index.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
        
      </div>
    </div>

    <div class="container">

      <!-- Example row of columns -->
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Actualizar Acceso de Ingreso</h3>
        </div>

        <div class="panel-body">
              <div class="row">
                <div class="col-md-7">

                  <form action="" method="POST">

                      <div class="input-group">
                        <span class="input-group-addon"></span>
                        <input type="password" class="form-control" placeholder="Clave Actual" name="password_current" onkeypress='validateField(event)' required>
                      </div>

                      <br />
                      <div class="input-group">
                        <span class="input-group-addon"></span>
                        <input type="password" class="form-control" placeholder="Nueva Clave" name="password" onkeypress='validateField(event)' required>
                      </div>

                      <br />
                      <div class="input-group">
                        <span class="input-group-addon"></span>
                        <input type="password" class="form-control" placeholder="Confirma la Clave" name="password_confirm" onkeypress='validateField(event)' required>
                      </div>

                      <br />
                      <div class="input-group">
                        <span class="input-group-addon"></span>
                        <input type="text" class="form-control" placeholder="Nombre Completo" name="name" required value="<?php echo $user->name; ?>">
                      </div>

                      

                      <br /> 
                      <p>
                          <button type="submit" name="submit" class="btn btn-info"  role="button">Guardar</button> 
                          <a class="btn btn-info" href="admin_access.php" role="button">Cancelar</a>
                      </p>
                  </form> 
                  


                </div>
        </div>
      </div>


    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    
  

</body></html>