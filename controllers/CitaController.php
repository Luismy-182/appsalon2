<?php 

namespace Controllers;

use MVC\Router;

class citaController{

    public static function index(Router $router){
    isAuth();
    if(!$_SESSION){
        session_start();
    }
        


        $router->render('cita/index',[
            'nombre'=>$_SESSION['nombre'],
            'id'=>$_SESSION['id']
        ]);
    }
}


?>