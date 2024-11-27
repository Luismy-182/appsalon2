<?php 
namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id','nombre','apellido', 'email','password','telefono','admin','confirmado','token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $password1;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
 
    public function __construct($args =[])
    {
        $this->id=$args['id'] ?? null;
        $this->nombre=$args['nombre'] ?? '';
        $this->apellido=$args['apellido'] ?? '';
        $this->telefono=$args['telefono'] ?? '';
        $this->email=$args['email'] ?? '';
        $this->password=$args['password'] ?? '';
        $this->password1=$args['password1'] ?? '';
        $this->admin=$args['admin'] ?? '0';
        $this->confirmado=$args['confirmado'] ?? '0';
        $this->token=$args['token'] ?? '';
    }

   
    //mensajes de validacion para la creacion de la cuenta
    public function validarFormularios(){
        if(!$this->nombre){
            self::$alertas['error'][]='El campo nombre no puede estar vacío';
        }
        if(!$this->apellido){
            self::$alertas['error'][]='El campo apellido no puede estar vacío';
        }
        if(!$this->telefono){
            self::$alertas['error'][]='El campo teléfono no puede estar vacío';
        }
        if(!$this->email){
            self::$alertas['error'][]='El campo email no puede estar vacío';
        }
        if(!$this->password){
            self::$alertas['error'][]='El campo password no puede estar vacío';
        }else{
            if(strlen($this->password)<6){
                self::$alertas['error'][]='El campo password debe ser mayor a 6 caracteres';
            }
        }

     //puedes agregar una validacion de que sean 10 digitos y que sea un numero
        return self::$alertas;
    }

    public function confirmarPassword(){
        if($this->password !== $this->password1){
            self::$alertas['error'][]='Error, los passwords no coinciden';
        }
        if(strlen($this->password)<5){
            self::$alertas['error'][]='El password debe ser mayor a 6 caracteres';
        }
        return self::$alertas;
    }

    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][]='El campo email no puede estar vacío';
        }
        if(!$this->password){
            self::$alertas['error'][]='El campo password no puede estar vacío';
        }
        return self::$alertas;
    }


    public function existeUsuario(){

        $query="SELECT * FROM ". self::$tabla. " WHERE email = '$this->email' ";
       
        $resultado=self::$db->query($query);

      

        if($resultado->num_rows){
            self::$alertas['error'][]='Error, email de usuario ya esta registrado';
        }

        return $resultado;

    }

    public function hashPassword(){
        $this->password=password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token=uniqid();
        
    }

    public function passwordAndVerificado($password){
        $resultado= password_verify($password, $this->password);
       
        if(!$resultado||!$this->confirmado){
            self::$alertas['error'][]='Password incorrecto o email aun no verificado'; 
        }else{
            return true;
        }

    }


    public function validarEmail($email){

        if(!$this->email){
            self::$alertas['error'][]='El campo email no puede estar vacío';
           
        }
        return self::$alertas;
    }



}




?>