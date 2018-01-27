<?php 
require_once 'classes/DB.class.php';
//connect to the database  
$db = new DB();  
$db->connect(); 
mysql_query("SET NAMES 'utf8'");

$types = $db->select('entities_types', ' 1');

$msg = '';

if(isset($_POST['submit-form'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];
	$type = $_POST['type'];

	$success = true;

	$exist = $db->select('entities', 'email = "'.$email.'"');

	if(!empty($exist)){
		$msg = "<div class='alert msg'>El email ya ha sido registrado.</div>";
	    $success = false;
	}

	if($password != $repassword) {
	    $msg = "<div class='alert msg'>Las contraseñas no coinciden.</div>";
	    $success = false;
	}

	if($success){
		$data =  array(
			'name' => '"'.$name.'"',
			'email' => '"'.$email.'"',
			'password' => '"'.md5($password).'"',
			'id_e_type' => $type
			);

		if($db->insert($data, 'entities')){
			$msg = "<div class='success msg'>Entidad agregada correctamente.</div>";
		}
	}
}

?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Registro de Entidad | Digital ID SV</title>
        <link rel="stylesheet" href="assets/css/style.css">        
    </head>
    <body>
        <div class="container">
        	<div class="logo">
        		<img src="assets/img/icon.png" alt="Digital ID SV">
        	</div>
        	<div class="title">Registro de Entidades</div>
        	<br><br>

        	<?php
        	if($msg != ''){
        		echo $msg;
        	} 
        	?>

        	<form action="#" method="post" accept-charset="utf-8">
        		<div class="row">
        			<div class="col-half">
        				Nombre de la entidad: <br>
        				<input type="text" name="name" required>
        			</div>
        			<div class="col-half">
        				Correo electrónico: <br>
        				<input type="email" name="email" required>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-half">
        				Contraseña: <br>
        				<input type="password" name="password" required>
        			</div>
        			<div class="col-half">
        				Repetir contraseña: <br>
        				<input type="password" name="repassword" required>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-half">
        				Tipo de información a solicitar: <br>
        				<select name="type" required>
        				<?php
        				foreach ($types as $key => $value) {
        					?>
        					<option value="<?=$value['id_e_type']?>"><?=$value['name']?></option>
        					<?php
        				}
        				?>
        				</select>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-full ac">
        				<input type="submit" name="submit-form" value="Registrar">
        			</div>
        		</div>
        	</form>
        </div>
    </body>
</html>