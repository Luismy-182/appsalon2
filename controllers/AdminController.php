<?php 

namespace Controllers;

use Model\AdminCita;
use MVC\Router;


class AdminController{

    public static function index(Router $router){
        isAuth();

        isAdmin();
        //obtenemos fecha de nuestro servidor

        //debuguear($_GET); // con esto te daras cuenta que ya esta aqui la fecha selecciconada
        $fecha=$_GET['fecha'] ?? date('Y-m-d');
       

        $fechas=explode('-', $fecha);

       
        if( !checkdate($fechas[1], $fechas[2], $fechas[0]) ){
            header('Location: /404');
        };
       
       
       

        //cita compleja de Joins para tomar todos los cmapos de interesdel cliente y sus cita
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        $consulta .= " WHERE fecha =  '{$fecha}' ";

        $citas=AdminCita::SQL($consulta);


        $router->render('admin/dashboard',[
            'nombre'=>$_SESSION['nombre'],
            'citas'=>$citas,
            'fecha'=>$fecha
        ]);
    }
}


?>