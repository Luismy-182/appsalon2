<?php 
namespace Model;


class Servicio extends ActiveRecord{
    protected static $tabla='servicios';
    protected static $columnasDB=['id','nombre','precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args=[]){
        $this->id=$args['id']?? null;
        $this->nombre=$args['nombre']??'';
        $this->precio=$args['precio'] ?? '';
    }

    function validar(){
        if(!$this->nombre){
            self::$alertas['error'][]='Error, el nombre del servicio no puede estar vacío';
        }
        if(!$this->precio){
            self::$alertas['error'][]='Error, el precio del servicio no puede estar vacío';
        }
        if(!is_numeric($this->precio) ){
            self::$alertas['error'][]='Error, el precio del servicio tiene que ser un número';
        }

        return self::$alertas;
    }
    
    
}


?>