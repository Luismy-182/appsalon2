<h1 class="text-center">Servicios</h1>
<p class="text-center">Administracion de servicios</p>



<?php require_once __DIR__ .'/../plantillas/barra.php' ?>

<ul class="servicios">
    <?php foreach($servicios as $servicio){ ?>

        <li>
            <p>Nombre: <span><?php echo $servicio->nombre; ?></span></p>
            <p>Precio: <span><?php echo $servicio->precio; ?></span></p>

            <div class="acciones">
                <a href="/servicios/actualizar?id=<?php echo $servicio->id?> " class="boton">Actualizar</a>

                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">
                    <input type="submit" value="Borrar" class="boton-eliminar">
                </form>
            </div>
        </li>
        <?php } ?>
</ul>