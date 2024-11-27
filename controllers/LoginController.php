<?php 
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

$router = new Router();

 class LoginController{

    public static function login(Router $router){
       
        $alertas=[];

        if($_SERVER['REQUEST_METHOD']==='POST' ){


            $auth=new Usuario($_POST);
            $alertas=$auth->validarLogin();

            if(empty($alertas)){
             
                $usuario=Usuario::where('email', $auth->email);
               
                if($usuario){
                    //verificar el password 
                 
                   if($usuario->passwordAndVerificado($auth->password) ){

                    session_start();
                    $_SESSION['id']=$usuario->id;
                    $_SESSION['nombre']=$usuario->nombre. " " . $usuario->apellido;
                    $_SESSION['email']=$usuario->email;
                    $_SESSION['login']=true;
                   
                    //redireccionamiento
                    if($usuario->admin === "1"){
                        $_SESSION['admin']=$usuario->admin ?? null; //agrega el campo admin al objeto usuario en la ubicacion del admin
                        header('Location: /dashboard');
                    }else{
                        header('Location: /cita');
                    }

                   
                   }

                }else{
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                   
                }
                
            }

           $alertas=Usuario::getAlertas();

           
            
        }


        $router->render('auth/login',[
            'alertas' => $alertas,
        ]);
    }


    public static function olvide(Router $router){
        
        $alertas=[];

        if($_SERVER['REQUEST_METHOD']==='POST'){
            
            $auth=new Usuario($_POST);
            $alertas=$auth->validarEmail($auth->email);

            //si no hay alertas procedemos a reenviar instrucciones a su email
            if(empty($alertas)){
           
                $usuario=Usuario::where('email', $auth->email); //compruba si existe el usuario
             


               if($usuario && $usuario->confirmado ==="1"){
                //enviar instrucciones
                $usuario->crearToken();
                $usuario->guardar();

                $email= new Email($usuario->email, $usuario->nombre, $usuario->token);
                $email->recuperarCuenta();
                
                $alertas= Usuario::setAlerta('exito','Se enviaron las instrucciones a tu email registrado');
                return;
               }else{
               $usuario=Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
         
               }
            }

        }//fin post

        $alertas=Usuario::getAlertas();

        $router->render('auth/olvide-password',[
            'alertas' => $alertas,
        ]);
    }
    public static function recuperar(Router $router){
        $error=false;
        $alertas=[];
        $token=s($_GET['token']);

        $usuario=Usuario::where('token', $token);
        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
            $error=true;
        }


        if($_SERVER['REQUEST_METHOD']==='POST'){
            $password=new Usuario($_POST);
            $alertas=$password->confirmarPassword();

            if(empty($alertas)){

                $usuario->password=null;
                $usuario->password=$password->password;
                $usuario->hashPassword();
                $usuario->token=null;
                $resultado=$usuario->guardar();

                if($resultado){
                    header('Location: /');
                }
            }
        }

        $alertas= Usuario::getAlertas();
        $router->render('auth/recuperar',[
            'alertas'=>$alertas,
            'error'=>$error
        ]);
    }


    public static function crear(Router $router){

        
        $usuario=new Usuario($_POST);
        $alertas=[];
        
        if($_SERVER['REQUEST_METHOD']==='POST'){
           $usuario->sincronizar($_POST);
            $alertas=$usuario->validarFormularios();//ejecutamos el metodo de validar formulario
            

            //guardando registros
            if(empty($alertas)){
                //validar que el email no exista si ya se esta a punto de registrar
              $resultado=$usuario->existeUsuario();
                

              if($resultado->num_rows){
                $alertas=Usuario::getAlertas();
              }else {
                //no esta registrado, procedemos a crear la cuenta
                //hasheo de password
                $usuario->hashPassword();

                $usuario->crearToken();

                $email= new Email($usuario->email, $usuario->nombre, $usuario->token);
                
                $email->enviarConfirmacion();

                $resultado= $usuario->guardar();

                if($resultado){
                    header('Location: /mensaje');
                }

              }
            }

          
        }
        $router->render('auth/crear',[
            'usuario'=>$usuario,
            'alertas'=>$alertas, //enviamos el objeto ala vista
            
        ]);
    }



    public static function mensaje(Router $router){


        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router){
       
        $alertas=[];

        $token= s($_GET['token']);
        
        $usuario=Usuario::where('token',$token);
        if(empty( $usuario) ){

            $resultado= Usuario::setAlerta('error','Token no valido');
            
        }else{
            $usuario->confirmado="1";
            $usuario->token=null;
            $usuario->guardar();
            $resultado= Usuario::setAlerta('exito','Token validado correctamente');
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar',[
            'alertas'=>$alertas
        ]);
    }


    public static function logout(){
        isAuth();
        $_SESSION=[];
        header('Location: /');
    

    }


    


}



?>