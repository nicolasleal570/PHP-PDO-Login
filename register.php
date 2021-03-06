<?php

    require_once 'core/init.php';

    //var_dump(Token::check(Input::get('token')));
  
    if (Input::exists()) {

        if (Token::check(Input::get('token'))) {

            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'username' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 20,
                    'unique' => 'users'
                ),
                'password' => array(
                    'required' => true,
                    'min' => 6,
                ),
                'password_again' => array(
                    'required' => true,
                    'matches' => 'password'
                ),
                'name' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 50
                )
            ));

            if ($validation->passed()) {

                $user = new User();

                $salt = Hash::salt(32);

                try{

                    //DATOS DEL USUARIO QUE SE VAN A INSERTAR
                    $user->create(array(
                        'username' => Input::get('username'),
                        'password' => Hash::make(Input::get('password'), $salt),
                        'salt' => $salt,
                        'name' => Input::get('name'),
                        'joined' => date('Y-m-d H:i:s'),
                        'type' => 1
                    ));

                    //CREANDO LA VARIABLE home PARA PASARLA AL INDEX.PHP
                    Session::flash('home', 'Registrado Exitosamente! Ahora inicia sesion.');
                    Redirect::to('index.php');

                }catch(Exception $e){
                    die($e->getMessage());
                }



            }else{
                //LISTANDO LOS ERRORES
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
    <title>Register Page</title>
</head>
<body>
    
    <form action="" method="post">

        <!-- USERNAME -->
        <div class="input-group">
            <label for="username">Nombre de Usuario: 
                <input type="text" class ="input-control" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
            </label>
        </div>

        <!-- PASSWORD -->
        <div class="input-group">
            <label for="password">Escoge una password: 
                <input type="password" class ="input-control" name="password" id="password" value="" autocomplete="off">
            </label>
        </div>

        <!-- PASSWORD AGAIN -->
        <div class="input-group">
            <label for="password_again">Repite la password: 
                <input type="password" class ="input-control" name="password_again" id="password_again" value="" autocomplete="off">
            </label>
        </div>

        <!-- NAME -->
        <div class="input-group">
            <label for="name">Nombre: 
                <input type="text" class ="input-control" name="name" id="name" value="<?php echo escape(Input::get('name')); ?>" autocomplete="off">
            </label>
        </div>

        <!-- GUARDA UN TOKEN UNICO PARA CADA USUARIO -->
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

        <!-- BTN SUBMIT -->
        <button type="submit" class="btn-submit"> Registrate! </button>

    </form>


</body>
</html>