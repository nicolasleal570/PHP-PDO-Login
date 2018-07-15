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
				'name' => array(
					'required' => true,
					'min' => 2,
					'max' => 50
				)
			));

			if ($validation->passed()) {
				//UPDATE
				try{
					//PASANDO LOS PARAMETROS QUE SE VAN A ACTUALIZAR EN LA DB
					$user->update(array(
						'name' => Input::get('name')
					));

					Session::flash('home', 'Tu perfil fue actualizado satisfactoriamente!');
					Redirect::to('index.php');
				}catch(Exception $e){
					die($e->getMessage());
				}
			}else {
				//ERRORS
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
	<title>Update Your Profile</title>
</head>
<body>
	
	<form action="" method="post">
		<!-- NAME -->
		<div class="input-group">
			<label for="name">Nombre: 
				<input type="text" name="name" id="name" value="<?php echo escape($user->data()->name); ?>">
			</label>
		</div> 

		<button type="submit">Aplicar cambios</button>
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	</form>


</body>
</html>