<?php
require('funcMatriculas.php');
class MatriculasAPI{

    public function API(){
        header('Content-Type: application/JSON');
        $method = $_SERVER['REQUEST_METHOD'];

        //// FUNCIONES BACKEND ////

        $funcMatriculas = new Matriculas();
        switch($method){
            case 'GET':
                break;
            case 'POST':
                //Devuelve la lista de matriculas con el limit y el offset.
                if($_GET['action'] == 'get_matriculas_lista'){
                    error_log("api");
                    return "hola";
                    
                    //$funcMatriculas->selectListaMatriculas();
                }
                break;
            case 'PUT':
                break;
            case 'DELETE':
                break;
            default: //metodo NO soportado
                echo 'METODO NO SOPORTADO';
                break;
        }
    }
        //Funcion que sirve por si no se cumple ningun parametro establecido
        function response($code = 200, $status = "", $message = "") {
            http_response_code($code);
            if (!empty($status) && !empty($message)) {
              $response = array("status" => $status ,"message" => $message);
              echo json_encode($response,JSON_PRETTY_PRINT);
            }
          }
}
?>