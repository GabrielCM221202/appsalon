<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{

    public static function login(Router $router)
    {
        $alertas = [];
        $auth = new Usuario();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $auth = new Usuario($_POST);
            $auth->validarLogin();
            $alertas = Usuario::getAlertas();
            if (empty($alertas)) {
                // Verificar si el usuario existe
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . ' ' . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;


                        //Redireccionar dependiendo su ROL

                        if ($usuario->admin === '1') {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }
    public static function logout(Router $router)
    {
        session_start();

        $_SESSION = [];
        header('Location: /');
    }
    public static function olvide(Router $router)
    {
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $auth = new Usuario($_POST);
            $auth->validarEmail();
            $alertas = Usuario::getAlertas();

            if (empty($alertas)) {
                // Verificar si el usuario existe
                $usuario = Usuario::where('email', $auth->email);

                if (!$usuario) {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                } elseif (!$usuario->confirmado) {
                    Usuario::setAlerta('error', 'Confirma tu cuenta');
                } elseif ($usuario && $usuario->confirmado) {
                    // Generar Token
                    $usuario->crearToken();
                    $usuario->guardar();
                    //Enviar el email

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito', 'Revisa tu email');
                }


                $alertas = Usuario::getAlertas();
            }
        }

        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }
    public static function recuperar(Router $router)
    {
        $alertas = [];
        $error = false;

        // Validar el token
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if (!$usuario) {
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = new Usuario($_POST);
            $password->validarPassword();

            $alertas = Usuario::getAlertas();

            if (empty($alertas)) {

                // Asignamos en nuevo password
                $usuario->password = null;
                $usuario->password = $password->password;
                // Hashear el password
                $usuario->hashPassword();
                //Eliminar Token 
                $usuario->token = null;

                // Guardar cambios

                $resultado = $usuario->guardar();

                if ($resultado) {

                    // Redireccionar

                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }
    public static function crear(Router $router)
    {
        $usuario = new Usuario;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $usuario->validarNuevaCuenta();
            $alertas = $usuario->getAlertas();

            if (empty($alertas)) {
                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();
                    // Genarar un token unico
                    $usuario->crearToken();

                    // Enviar el email

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    // Guardar el registro 

                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router)
    {
        // Ver si existe el usuario en la base de datos

        $token = s($_GET['token']);
        $alertas = [];

        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            // Mostrar mensaje de error
            Usuario::setAlerta('error', 'Usuario inexistente');
        } else {
            // Modificar al usuario
            $usuario->confirmado = '1';
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Confirmada Correctamente');
        }


        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
