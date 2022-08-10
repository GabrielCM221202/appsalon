<?php

namespace Model;

class Usuario extends ActiveRecord
{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = [
        'id',
        'nombre',
        'apellido',
        'email',
        'password',
        'telefono',
        'admin',
        'confirmado',
        'token'
    ];


    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    // Mensajes de validación para la creacion de una cuenta

    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::setAlerta('error' , 'El nombre es obligatorio');
        }
        if(!$this->apellido){
            self::setAlerta('error' , 'El apellido es obligatorio');
        }
        if(!$this->telefono){
            self::setAlerta('error' , 'El telefono es obligatorio');
        }
        if(strlen($this->telefono) < 10 && $this->telefono){
            self::setAlerta('error' , 'El telefono debe tener al menos 10 digitos');
        }
        if(!$this->email){
            self::setAlerta('error' , 'El email es obligatorio');
        }
        if(!$this->password){
            self::setAlerta('error' , 'El password es obligatorio');
        }
        if(strlen($this->password) < 6 && $this->password){
            self::setAlerta('error' , 'El password debe contener al menos 6 caracteres');
        }
    }


    public function validarLogin(){
        if(!$this->email){
            self::setAlerta('error' , 'El email es obligatorio');
        }
        if(!$this->password){
            self::setAlerta('error' , 'El password es obligatorio');
        }
    }


    public function existeUsuario(){
        $query = "SELECT * FROM ". self::$tabla ." WHERE email = '". $this->email ."' LIMIT 1;";
        $resultado = self::$db->query($query);
        if($resultado->num_rows){
            self::setAlerta('error' , 'Ya existe un usuario registrado con ese email');
        }

        return $resultado;
    }

    public function hashPassword(){
        $this->password = password_hash($this->password , PASSWORD_BCRYPT);
    }
    public function crearToken(){
        $this->token = uniqid();
    }


    // Login

    public function comprobarPasswordAndVerificado($password){
        $resultado = password_verify($password , $this->password);
        if(!$resultado){
            self::setAlerta('error' , 'Password Incorrecto');
        }elseif(!$this->confirmado){
            self::setAlerta('error' , 'Tu cuenta no ha sido confirmada');

        }elseif($resultado && $this->confirmado){
            return true;
        }
    }

    // Recuperar contraseña

    public function validarEmail(){
        if(!$this->email){
            self::setAlerta('error' , 'El email es obligatorio');
        }
    }

    public function validarPassword(){
        if(!$this->password){
            self::setAlerta('error' , 'El password es obligatorio');
        }
        if(strlen($this->password) < 6 && $this->password){
            self::setAlerta('error' , 'El password debe contener al menos 6 caracteres');
        }
    }


}
