<?php
/**
 * @title: Proyecto integrador Ev01 - Registro en el sistema.
 * @description:  Script PHP para almacenar un nuevo usuario en la base de datos
 *
 * @version    1.1 - Estilos mejorados
 *
 * @author     Ander Frago & Miguel Goyena (Modificado por Markel Alvarado)
 */

rutasAFicherosInternos();

$error = $user = $pass = "";


if (isset($_POST['email'])) {

    $user = $_POST['email'];
    $pass = $_POST['password'];

    $error = validacionDeRegistroDeUsuario($user, $pass);
}
?>

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header bg-success text-white text-center">
                <h3 class="font-weight-light my-3">Crear una Cuenta</h3>
            </div>
            <div class="card-body p-4">
                <form class="form-horizontal" role="form" method="POST" action="signup.php">

                    <div class="form-floating mb-3">
                        <input type="text" name="email" class="form-control" id="email"
                               placeholder="yoxti@ejemplo.com" required autofocus
                               value="<?php echo htmlspecialchars($user); ?>">
                        <label for="email">Email:</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" id="password"
                               placeholder="Contraseña" required>
                        <label for="pass">Contraseña:</label>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <div class="d-grid mt-4 mb-0">
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            Registrarme
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small">
                    <a href="login.php">¿Ya tienes cuenta? Entra aquí</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
/**
 * @return void
 */
function rutasAFicherosInternos(): void
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
function validacionDeRegistroDeUsuario($user, $pass)
{
    if ($user == "" || $pass == "") {
        $error = "Debes completar todos los campos.";
    } else {
        $userDAO = new UserDAO();

        if ($userDAO->checkUserExists($user)) {
            $error = "Ese nombre de usuario (email) ya está registrado.";
        } else {
            $userDAO->insert($user, $pass);

            SessionHelper::setSession($user);
            header('Location: ./../index.php');
            exit();
        }
    }
    return $error;
}