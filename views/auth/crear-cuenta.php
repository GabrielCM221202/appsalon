<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

<?php
    include __DIR__. '/../templates/alertas.php';
?>

<form action="/crear-cuenta" method="POST" class="formulario">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" value="<?php echo s($usuario->nombre) ?>">
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" name="apellido" id="apellido" placeholder="Tu apellido" value="<?php echo s($usuario->apellido) ?>">
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" name="telefono" id="telefono" placeholder="Tu numero telefonico" value="<?php echo s($usuario->telefono) ?>">
    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu email" value="<?php echo s($usuario->email) ?>">
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu password" value="<?php echo s($usuario->password) ?>">
    </div>

    <input type="submit" value="Crear Cuenta" class="boton">
</form>


<div class="acciones">
    <a href="/">¿Ya tienes una cuenta?, Inicia Sesión</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>