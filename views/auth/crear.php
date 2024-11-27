<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Inicia Sesión con tus datos</p>


<?php 
   require_once __DIR__."/../plantillas/alertas.php";
?>
<form class="formulario" action="#" method="POST" >


<div class="campo">
    <label for="nombre">Nombre</label>
    <input type="text" placeholder="Tu Nombre" name="nombre" id="nombre" value="<?php echo $usuario->nombre?>"> 
</div>

<div class="campo">
    <label for="apellido">Apellido</label>
    <input type="apellido" placeholder="Tus Apelidos" name="apellido" id="apellido" value="<?php echo $usuario->apellido?>">
</div>


<div class="campo">
    <label for="telefono">Teléfono</label>
    <input type="telefono" placeholder="Tu teléfono" name="telefono" id="telefono" value="<?php echo $usuario->telefono?>">
</div>

<div class="campo">
    <label for="email">Email</label>
    <input type="email" placeholder="Tu Email" name="email" id="email" value="<?php echo $usuario->email?>">
</div>

<div class="campo">
    <label for="password">Password</label>
    <input type="password" placeholder="Tu password" name="password" id="password">
</div>

<input type="submit" value="Crear cuenta">
</form>

<div class="navegacion">
    <a href="/">¿Ya tienes cuenta? Inicia Session</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>