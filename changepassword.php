<?php

	require_once 'core/init.php';

	$user = new User();

	if (!$user->isLoggedIn()) {
		Redirect::to('index.php');
	}

	if (Input::exists()) {
		if (Token::check(Input::get('token'))) {
			
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'password_current' => array(
					'required' => true,
					'min' => 6
				),
				'password_new' => array(
					'required' => true,
					'min' => 6
				),
				'password_new_again' => array(
					'required' => true,
					'min' => 6,
					'matches' => 'password_new'
				)
			));

			if ($validation->passed()) {

				//CHANGE PASSWORD
				if (Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
					echo 'Tu contraseña actual es incorrecta';	
				}else{
					$salt = Hash::salt(32);

					$user->update(array(
						'password' => Hash::make(Input::get('password_new'), $salt),
						'salt' => $salt
					));

					Session::flash('home', 'Password actualizada correctamente!');
					Redirect::to('index.php');
				}

			}else{
				foreach ($validation->errors() as $error) {
					echo $error, '<br>';
				}
			}

		}
	}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Change Password</title>
</head>
<body>
	
	<form action="" method="post">
		<!-- PASSWORD ACTUAL -->
		<div class="input-group">
			<label for="password_current">Password Actual: 
				<input type="password" name="password_current" id="password_current">
			</label>
		</div>

		<!-- PASSWORD NNUEVA -->
		<div class="input-group">
			<label for="password_new">Password Nueva: 
				<input type="password" name="password_new" id="password_new">
			</label>
		</div>

		<!-- PASSWORD NUEVA OTRA VEZ -->
		<div class="input-group">
			<label for="password_new_again">Repetir Password Nueva: 
				<input type="password" name="password_new_again" id="password_new_again">
			</label>
		</div>		

		<button type="submit">Aplicar cambios</button>
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	</form>

</body>
</html>