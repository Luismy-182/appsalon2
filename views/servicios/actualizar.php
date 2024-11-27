<?php require_once __DIR__ .'/../plantillas/barra.php' ?>

<h1>Actualizar servicio</h1>

<p>Llena todos los campos para actualizar un servicio</p>

<?php 
require_once __DIR__ . '/../plantillas/alertas.php';
require_once __DIR__ .'/../plantillas/barra.php'; 
?>


<form method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php' ?>
<input type="submit" class="boton" value="Crear servicio nuevo">

</form>