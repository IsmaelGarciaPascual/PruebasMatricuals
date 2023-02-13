<?php
  /**
   * Clase de conexion con la base de datos
   *
   * */
  class Conexion {

     const LOCALHOST = "localhost";
     const USER = "postgres";
     const PASSWORD = "8775332kK";
     const DATABASE = "pruebas";
     const PORT = "5432";
     public $base_url_api = "http://localhost/PruebasConCopy/API/";

   /**
    * Constructor de clase
    */
    public function __construct() {
      try {
          //conexión a base de datos
          $this->con = pg_pconnect("host=".self::LOCALHOST." port=".self::PORT." dbname=".self::DATABASE." user=".self::USER." password=".self::PASSWORD);
            
          if (!$this->con) {
            die("Ocurrio un error al intentar la conexion");
          }
      } catch (Exception $e){
          //Si no se puede realizar la conexión
          Echo $e->getMessage();
      }
    }

    public function getConexion() {        
      return $this->con;
    }
  } //class
 ?>
