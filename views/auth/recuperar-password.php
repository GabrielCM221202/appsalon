<h1 class="nombre-pagina">Recupera tu Password</h1>
<p class="descripcion-pagina">Ingresa tu nuevo Password</p>

<?php
include __DIR__ . '/../templates/alertas.php';
?>
<?php
if($error) return;
?>

<form method="POST" class="formulario">
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu Nuevo Password">
    </div>

    <input type="submit" value="Guardar Password" class="boton">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aun no tienes una cuenta?, Crea Una</a>
    <a href="/">¿Ya tienes una cuenta?, Inicia Sesión</a>
</div>