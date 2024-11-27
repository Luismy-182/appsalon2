<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Sesión con tus datos</p>

<?php require_once __DIR__ .'/../plantillas/alertas.php' ?>
<form class="formulario" action="#" method="POST" >

<div class="campo">
    <label for="email">Email</label>
    <input type="email" placeholder="Tu Email" name="email" id="email">
</div>

<div class="campo">
    <label for="password">Password</label>
    <input type="password" placeholder="Tu password" name="password" id="password">
</div>

<input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="navegacion">
    <a href="/crear">¿Aún no tienes cuenta? Crear una</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>