<DOCTYPE html>
<head>
	<title>INICIO DE SESIÓN</title>
	<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/inicio.css')?>" rel="stylesheet">
</head>
<body>
	<div class="container child">
		<div class="panel panel-primary parent">
		  <div class="panel-heading">
		    <h3 class="panel-title">Inicio de Sesión</h3>
		  </div>
		  <div class="panel-body">
		  	<img src="<?php echo base_url('assets/imagenes/pf.png')?>" width="300"></br>
		    <form method="post" action="<?php echo site_url('usuario/inicio')?>">
			  <div class="form-group">
			    <label for="usunombre">Nombre de usuario</label>
			    <input type="text" class="form-control" name="usunombre" id="usunombre" placeholder="Nombre de usuario">
			  </div>
			  <div class="form-group">
			    <label for="usupassword">Password</label>
			    <input type="password" class="form-control" name="usupassword" id="usupassword" placeholder="Password">
			  </div>
			  <button type="submit" class="btn btn-primary">Iniciar sesión</button>
			</form>
		  </div>
		</div>
	</div>
</body>
</html>