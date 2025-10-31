<?php
/**
 * @title: Proyecto integrador Ev01 - Acceso al sistema.
 * @description:  Script PHP para acceder al sistema
 *
 * @version    1.1 - Estilos mejorados
 *
 * @author ander_frago@cuatrovientos.org (Modificado por Markel Alvarado)
 */

declararRutas();

$error = "";

if (isset($_POST['user']))
{
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $error = validacionesDeInicioSesion($user, $pass);
}
else if (SessionHelper::loggedIn()){
    header('Location: ./../index.php');
    exit();
}
?>

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header bg-dark text-white text-center">
                <h3 class="font-weight-light my-3">Acceso al Sistema</h3>
            </div>
            <div class="card-body p-4">
                <form class="form-horizontal" role="form" method="POST" action="login.php">

                    <div class="form-floating mb-3">
                        <input type="text" name="user" class="form-control" id="email"
                               placeholder="yoxti@ejemplo.com" required autofocus>
                        <label for="email">Email:</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="pass" class="form-control" id="password"
                               placeholder="Contraseña" required>
                        <label for="pass">Contraseña:</label>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <div class="d-grid mt-4 mb-0">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            Acceder
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small">
                    <a href="signup.php">¿No tienes cuenta? Regístrate</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
/**
 * @return void
 */
function declararRutas(): void
{
    $dir = __DIR__;
    require_once $dir . '/../templates/header.php';
    require_once $dir . '/../persistence/DAO/UserDAO.php';
}

/**
 * @param $user
 * @param $pass
 * @return string|void
 */
function validacionesDeInicioSesion($user, $pass)
{
    if ($user == "" || $pass == "") {
        $error = "Debes completar todos los campos";
    } else {
        $userDAO = new UserDAO();

        if (!$userDAO->checkUserExists($user, $pass)) {
            $error = "Email o Contraseña inválida";
        } else {
            SessionHelper::setSession($user);

            header('Location: ./../index.php');
            exit();
        }
    }
    return $error;
}
