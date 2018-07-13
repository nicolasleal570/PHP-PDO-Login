<?php

require_once 'core/init.php';

// RECIBIENDO EL REGISTRO EXITOSO 
if (Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User(); //CURRENT

if ($user->isLoggedIn()) {
	?>

    <p>Hello, <a href="profile.php?user=<?php echo escape($user->data()->username);?>"><?php echo escape($user->data()->username); ?></p>

    <ul>
        <li><a href="update.php">Update Profile</a></li>
        <li><a href="changepassword.php">Change Password</a></li>
        <li><a href="logout.php">Log out</a></li>
    </ul>
<?php

} else {
    echo '<p>Necesitas <a href="login.php">Iniciar Sesion</a> o <a href="register.php">Registrarte</a></p>';
}






?>