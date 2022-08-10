<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}
// Funcion que revisa que el usuario este autenticado
function isAuth() {
    session_start();
    if(isset($_SESSION['login']) != true){
        header('Location: /');
    }
}


function esUltimo($actual , $proximo){
    if($actual !== $proximo){
        return true;
    }

    return false;
}


function isAdmin(){
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}