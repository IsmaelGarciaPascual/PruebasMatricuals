<?php
require('conexion.php');
$limit=100;
$pag = 0;
class Matriculas {

    public function getMatriculas(){

    }

    function selectListaMatriculas(){
        $obj = json_decode( file_get_contents('php://input') );
        $limit = $obj->limit;
        $offset = $obj->offset;
        $obcon = new Conexion();
        $conexionEstablecida = $obcon->getConexion();
        //printf(($conexionEstablecida));
        $sql = "SELECT matricula, descripcion_etiqueta FROM matriculas INNER JOIN descripcion_etiquetas ON matriculas.tipo_etiqueta = descripcion_etiquetas.tipo_etiqueta Order by matricula Limit $1 OFFSET $2";
        $ejecquery = pg_query_params($conexionEstablecida, $sql, array($limit, $offset));
        $result = pg_fetch_all($ejecquery);
        //print_r($result);
        pg_close($conexionEstablecida);
        
        return $result;
    }
}