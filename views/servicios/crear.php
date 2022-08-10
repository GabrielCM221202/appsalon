<h1 class="nombre-pagina">Añadir un nuevo servicio</h1>
<p class="descripcion-pagina">Llena el formulario para añadir un nuevo servicio</p>


<?php require_once __DIR__ .'/../templates/barra.php';?>

<?php include __DIR__.'/../templates/alertas.php' ?>

<form action="/servicios/crear" method="POST" class="formulario">

    <?php include __DIR__.'/formulario.php' ?>
    <input type="submit" value="Añadir servicio" class="boton">
</form>