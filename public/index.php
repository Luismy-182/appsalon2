<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use MVC\Router;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServicioController;

$router = new Router();


$router->get('/', [LoginController::class,'login']);
$router->post('/', [LoginController::class,'login']);


//cerrar sesión
$router->get('/logout', [LoginController::class, 'logout']);
//recuperar cuenta
$router->get('/olvide', [LoginController::class,'olvide']);
$router->post('/olvide', [LoginController::class,'olvide']);
$router->get('/recuperar', [LoginController::class,'recuperar']);
$router->post('/recuperar', [LoginController::class,'recuperar']);


//crear cuenta
$router->get('/crear', [LoginController::class,'crear']);
$router->post('/crear', [LoginController::class,'crear']);


//confirmar Cuenta

$router->get('/confirmar-cuenta', [LoginController::class,'confirmar']);
$router->get('/mensaje', [LoginController::class,'mensaje']);


//dashboard
$router->get('/cita',[CitaController::class, 'index']);
//admin
$router->get('/dashboard',[AdminController::class, 'index']);



//eliminar un usuario y su servicio
$router->post('/api/eliminar',[APIController::class, 'eliminar']);

//CRUD de servicios
$router->get('/servicios', [ServicioController::class, 'index']);
$router->get('/servicios/crear', [ServicioController::class, 'crear']);
$router->post('/servicios/crear', [ServicioController::class, 'crear']);
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/eliminar', [ServicioController::class, 'eliminar']);




//API de servicios o endpoint a consumir
$router->get('/api/servicios',[APIController::class, 'index']);



//respuesta de la api
$router->post('/api/citas', [APIController::class, 'guardar']);















// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();