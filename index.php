<?php

require_once 'core/init.php';

// RECIBIENDO EL REGISTRO EXITOSO 
if (Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Home</title>
</head>
<body>	

	<?php 
		$user = new User(); //CURRENT

		if ($user->isLoggedIn()) { ?>
	
		<p>Hello, 
			<a href="profile.php?user=<?php echo escape($user->data()->username);?>">
				<?php echo escape($user->data()->username); ?>
			</a>
		</p>

		<ul>
			<li><a href="update.php">Update Profile</a></li>
			<li><a href="changepassword.php">Change Password</a></li>
			<li><a href="logout.php">Log out</a></li>
		</ul>
	<?php 
			//VALIDANDO QUE TIPO DE USUARIO ERES
			if ($user->hasPermission('admin')) {
				echo '<h3> Eres un administrador! </h3>';
			}

		} else {
			echo '<p>Necesitas <a href="login.php">Iniciar Sesion</a> o <a href="register.php">Registrarte</a></p>';
		} 
	?>

</body>
</html>