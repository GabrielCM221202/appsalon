<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController{
    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);
        
    }

    public static function guardar(){
        $cita = new Cita($_POST);

        $resultado = $cita->guardar();

        // Guardar la cita y los servicios
        $idServicios = explode(',',$_POST['servicios']);

        foreach ($idServicios as $idServicio) {
            $args = [
                'servicioId' => $idServicio,
                'citaId' => $resultado['id']
            ];

            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        $respuesta = [
            'res' => $resultado
        ];

        echo json_encode($respuesta);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $cita = Cita::find($_POST['id']);
            $cita->eliminar();
    
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
}