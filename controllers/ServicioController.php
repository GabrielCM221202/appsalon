<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController
{
    public static function index(Router $router)
    {
        session_start();

        isAdmin();
        $servicios = Servicio::all();

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }


    public static function crear(Router $router)
    {
        session_start();
        isAdmin();
        $servicio = new Servicio();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio = new Servicio($_POST);

            $servicio->validar();
            $alertas = Servicio::getAlertas();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /admin');
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'alertas' => $alertas,
            'servicio' => $servicio
        ]);
    }


    public static function actualizar(Router $router)
    {
        session_start();
        isAdmin();
        $id = is_numeric($_GET['id']);
        if(!$id){
            header('Location: /servicios');
        }
        $servicio = Servicio::find($_GET['id']);
        if(!$servicio){
            header('Location: /servicios');
        }
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $servicio->validar();
            $alertas = Servicio::getAlertas();

            if(empty($alertas)){
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'alertas' => $alertas,
            'servicio' => $servicio
        ]);
    }



    public static function eliminar(Router $router)
    {
        session_start();
        isAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           $servicio = Servicio::find($_POST['id']);

           $servicio->eliminar();
           header('Location: /servicios');
        }
    }
}
