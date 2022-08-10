<h1 class="nombre-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Modifica los campos del formulario para actualizar la información del servicio</p>


<?php require_once __DIR__ .'/../templates/barra.php';?>

<?php include __DIR__.'/../templates/alertas.php' ?>

<form method="POST" class="formulario">

    <?php include __DIR__.'/formulario.php' ?>
    <input type="submit" value="Guardar Cambios" class="boton">
</form>