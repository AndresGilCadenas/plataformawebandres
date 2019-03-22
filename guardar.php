<?php
	
	require 'conexion.php';
	
	$nombre = $_POST['nombre'];
	$email = $_POST['email'];
	$telefono = $_POST['telefono'];
	$estado_civil = $_POST['estado_civil'];
	$hijos = isset($_POST['hijo']) ? $_POST['hijos'] : 0;
	$intereses = isset($_POST['intereses']) ? $_POST['intereses'] : null;
	
	$arrayIntereses = null;
	
	$num_array = count($intereses);
	$contador = 0;
	
	if($num_array>0){
		foreach ($intereses as $key => $value) {
			if ($contador != $num_array-1)
			$arrayIntereses .= $value.' ';
			else
			$arrayIntereses .= $value;
			$contador++;
		}
	}
	
	$sql = "INSERT INTO personas (nombre, correo, telefono, estado_civil, hijos, intereses) VALUES ('$nombre', '$email', '$telefono', '$estado_civil', '$hijos', '$arrayIntereses')";
	$resultado = $mysqli->query($sql);
	$id_insert = $mysqli->insert_id;
	
	if($_FILES["archivo"]["error"]>0){
		echo "Error al Subir el archivo";
	}else{
		$permitidos = array("images/png","application/pdf","application/msword","application/vnd.ms-excel");
		$limit_kb=200000;

		if(in_array($_FILES["archivo"]["type"],$permitidos)&& $_FILES["archivo"]["size"]<= $limit_kb*1024){


			$ruta = 'files/'.$id_insert.'/';
			$archivo = $ruta.$_FILES["archivo"]["name"];

			if(!file_exists($ruta)){
				mkdir($ruta);
			}
			if(!file_exists($archivo)){
				$r = @move_uploaded_file($_FILES["archivo"]["tmp_name"],$archivo);
				if($r){
					echo "Archivo Guardado Correctamente";
				}else{
					echo "Hubo un Error";
				}

			}else{
				echo "Archivo ya existe";
			}
		}else{
			echo "Archivo no permitido o excede el puto limite";
		}
	}
?>
 
<html lang="es">
	<head>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.css" rel="stylesheet">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>	
	</head>
	
	<body>
		<div class="container">
			<div class="row">
				<div class="row" style="text-align:center">
					<?php if($resultado) { ?>
						<h3>REGISTRO GUARDADO</h3>
						<?php } else { ?>
						<h3>ERROR AL GUARDAR</h3>
					<?php } ?>
					
					<a href="index.php" class="btn btn-primary">Regresar</a>
					
				</div>
			</div>
		</div>
	</body>
</html>