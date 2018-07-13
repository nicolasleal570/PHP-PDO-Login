<?php

    require_once 'core/init.php';

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
            
            $validate = new Validate();

            $validation = $validate->check($_POST, array(
                'username' => array(
                    'required' => true
                ),
                'password' => array(
                    'required' => true
                )
            ));

            if ($validation->passed()) {

                //LOG USER IN
                $user = new User();
                $login = $user->login(Input::get('username'), Input::get('password'));

                if ($login) {
                    Redirect::to('index.php');
                }else{
                    echo '<p> El inicio de sesion no pudo completarse </p>';
                }

            }else{

                //LISTANDO LOS ERRORES
                foreach ($validation->errors() as $error) {
                    echo $error . '<br>';
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
    <title>Inicia Sesion</title>
</head>
<body>
    
    <form action="" method="post">

        <!-- USERNAME -->
        <div class="input-group">
            <label for="username">Nombre de Usuario: 
                <input type="text" name="username" id="">
            </label>
        </div>

        <!-- PASSWORD -->
        <div class="input-group">
            <label for="password">Nombre de Usuario: 
                <input type="password" name="password" id="">
            </label>
        </div>

        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <button type="submit">Iniciar Sesion</button>

    </form>



</body>
</html>