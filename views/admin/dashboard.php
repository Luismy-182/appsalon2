<?php require_once __DIR__ .'/../plantillas/barra.php' ?>
<h1>Buscar citas</h1>


<div class="busqueda">
    <form  class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha?>">
        </div>
    </form>
</div>

<?php 

if(count ($citas)===0){
    echo "<h2> No hay citas para este día </h2>";
}
?>


<div id="citas-admin">
    <ul class="citas">
    <?php
    $idCita= 0;
    foreach($citas as $key => $cita){

        if($idCita !== $cita->id){
            $total=0;
            
        ?>
    <li>
            <h2 class="text-center">Cliente</h2>
            <p>ID: <span><?php echo $cita->id; ?></p></span></p>
            <p>Hora: <span><?php echo $cita->hora; ?></p></span></p>
            <p>Cliente: <span><?php echo $cita->cliente; ?></p></span></p>
            <p>Email: <span><?php echo $cita->email; ?></p></span></p>
            <p>Télefono: <span><?php echo $cita->telefono; ?></p></span></p>


            <h3>Servicios</h3>
            <?php 
            
            $idCita=$cita->id;
        }
        $total+=$cita->precio;
        //fin del IF ?>

        <p class="servicio"><?php echo $cita->servicio . " " . $cita->precio;
        $cita->precio; ?></p>


        <?php 
        $actual=$cita->id;
        $proximo=$citas[$key + 1]->id ?? 0;

        if(esUltimo($actual, $proximo)){ ?>
            <p class="total">Total: <span> $ <?php echo $total; ?></span> </p>


            <form action="/api/eliminar" method="POST">
                <input type="hidden" name="id" value="<?php echo $cita->id; ?>">

                <input type="submit" class="boton-eliminar" value="Eliminar">

            </form>
       <?php  
       }
     }
    ?>
    </ul>
</div>



<?php 
    $script ="
    <script src='/build/js/buscador.js'></script>
    "
?>