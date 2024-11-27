<h2 class="text-center">Recuperación de la cuenta</h2>

<p class="">Solicitaste la recuperacion de tu password, por favor introduce tu nuevo password</p>



<?php require_once __DIR__ .'/../plantillas/alertas.php' ;
   
if($error){//si error es igual a true entonces no muestra el contenido del form
    return null;
}

?>
<form class="formulario" method="POST" >

<div class="campo">
    <label for="password">Password</label>
    <input type="password" placeholder="Tu password" name="password" id="password1">
</div>

<div class="campo">
    <label for="password2">Confirmar password</label>
    <input type="password" placeholder="Confirma tu password" name="password1" id="password">
</div>

<input type="submit" value="Guardar nuevo password">
</form>

<div class="navegacion">
    <a href="/">¿Ya tienes cuenta?. Inicia sessión</a>
    <a href="/crear">¿Aún no tienes cuenta? Crear una</a>
 
</div>