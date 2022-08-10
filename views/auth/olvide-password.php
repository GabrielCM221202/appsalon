<h1 class="nombre-pagina">Olvide mi Password</h1>
<p class="descripcion-pagina">Reestablece tu password, escribiendo tu email a continuación</p>

<?php 
    include __DIR__.'/../templates/alertas.php';
?>

<form action="/olvide" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu email">
    </div>

    <input type="submit" value="Enviar Instrucciones" class="boton">
</form>


<div class="acciones">
    <a href="/crear-cuenta">¿Aun no tienes una cuenta?, Crea Una</a>
    <a href="/">¿Ya tienes una cuenta?, Inicia Sesión</a>
</div>