<?php
    require_once 'core/init.php';

    if (!$username = Input::get('user')) {
        Redirect::to('index.php');
    }else{
        $user = new User($username);
        if (!$user->exists()) {
            Redirect::to(404);
        }else{
            $data = $user->data();
        }
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile <?php echo Input::get('user'); ?></title>
</head>
<body>

    <ul>
        <li>
            <h3> Nombre de Usuario: <?php echo escape($data->username); ?> </h3>
        </li>
        <li>
            <h3> Nombre Personal: <?php echo escape($data->name); ?> </h3>
        </li>
        <li>
            <h3> Tipo de Usuario: <?php if ($data->type == 1) {
                echo 'Comun';
            }else if ($data->type == 2) {
                echo 'Administrador';
            } ?> </h3>
        </li>
    </ul>
    
</body>
</html>