<h1 class="nombre-pagina">Olvide password</h1>
<p class="descripcion-pagina">Reestablece tu password escribiendo tu email a continuación</p>

<?php  require __DIR__.'/../plantillas/alertas.php';  ?>
<form class="formulario" action="#" method="POST" >

<div class="campo">
    <label for="email">Email</label>
    <input type="email" placeholder="Tu Email" name="email" id="email">
</div>

<input type="submit" class="boton" value="Enviar instrucciones">
</form>

<div class="navegacion">
    
    <a href="/">¿Ya tienes cuenta? Inicia Sesión</a>
    <a href="/crear">¿Aún no tienes cuenta? Crear una</a>
</div>