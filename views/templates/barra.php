<div class="barra">
    <p>Hola: <strong> <?php echo s($nombre) ?></strong></p>
    <a class="btn" href="/logout">Cerrar Sesión</a>
</div>



<?php if (isset($_SESSION['admin'])) : ?>
<div class="barra-servicios">
    <a class="boton" href="/admin">Ver Citas</a>
    <a class="boton" href="/servicios">Ver Servicios</a>
    <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
</div>
<?php endif; ?>