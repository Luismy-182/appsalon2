<?php 

namespace Controllers;

use Model\Cita;
use Model\Servicio;
use Model\CitaServicio;
use Models\CitasServicios;
use Model\CitasServicios as ModelCitasServicios;
use MVC\Router;

class APIController{


    public static function index(){
       $servicios = Servicio::all();

       echo json_encode($servicios);
       
    }


    public static function guardar(){

        //almacena las citas y debuelve el id
        $cita=new Cita($_POST);
       
        $resultado= $cita->guardar();

        $id = $resultado['id'];
   

        //almacena las cita y los servicios
        $idServicios = explode(",", $_POST['servicios']);
        foreach($idServicios as $idServicio){
            $args=[
                'citaId'=>$id,
                'servicioId'=>$idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }


        $respuesta =[
            'resultado'=>$resultado
        ];

        echo json_encode($respuesta);
    }


    public static function eliminar(Router $router){

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $id=$_POST['id'];
            $cita= Cita::find($id);
            $cita->eliminar();
            header('Location:'.$_SERVER['HTTP_REFERER']); //redirecciona ala misma pagina xD
        }
    }
}




?>