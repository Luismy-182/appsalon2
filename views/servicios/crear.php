<h1>Nuevo servicio</h1>

<p class="text-center">Llena todos los campos para añadir un nuevo servicio</p>

<?php 
require_once __DIR__ . '/../plantillas/alertas.php';
require_once __DIR__ .'/../plantillas/barra.php'; 
?>


<form action="/servicios/crear" method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php' ?>
<input type="submit" class="boton" value="Crear servicio nuevo">

</form>