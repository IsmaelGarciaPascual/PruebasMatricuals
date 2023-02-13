<?php
$j=1;
include('Conexion.php');
$base_de_datos = new PDO("pgsql:host=$rutaServidor;port=$puerto;dbname=$nombreBaseDeDatos", $usuario, $contraseña);
$base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
function selectCompleto($offset, $limit){
    global $base_de_datos;
    $sentencia = $base_de_datos->query("SELECT matricula, descripcion_etiqueta
    FROM matriculas INNER JOIN descripcion_etiquetas ON matriculas.tipo_etiqueta = descripcion_etiquetas.tipo_etiqueta Order by matricula Limit ".$limit." OFFSET ".$offset."");
    $matricula = $sentencia->fetchAll(PDO::FETCH_OBJ);
    return $matricula;
}

function selectMatricula($matricula){
    global $base_de_datos;
    $sentencia = $base_de_datos->prepare(" SELECT matricula, descripcion_etiqueta
    FROM matriculas INNER JOIN descripcion_etiquetas ON matriculas.tipo_etiqueta = descripcion_etiquetas.tipo_etiqueta WHERE LOWER(matricula) = LOWER(?)");
    $sentencia->execute([strtoupper($matricula)]);
    $matricula = $sentencia->fetchAll(PDO::FETCH_OBJ);
    return $matricula;
}

function selectDistintivo($distintivo){
    global $base_de_datos;
    $sentencia = $base_de_datos->prepare(" SELECT matricula, descripcion_etiqueta
    FROM matriculas INNER JOIN descripcion_etiquetas ON matriculas.tipo_etiqueta = descripcion_etiquetas.tipo_etiqueta WHERE LOWER(matriculas.tipo_etiqueta) = LOWER(?) OR LOWER(descripcion_etiquetas.descripcion_etiqueta) = LOWER(?) Order by matricula Limit 10 OFFSET 0");
    if(strtoupper($distintivo[0]) != "E" && strtoupper($distintivo[0]) != "S"){
        $sentencia->execute([strtoupper($distintivo), '']);
    }else{
        $sentencia->execute(['', $distintivo]);
    }
    $distintivo = $sentencia->fetchAll(PDO::FETCH_CLASS);
    return $distintivo;
}

function numeroDeRegistros($sql){
    global $base_de_datos;
    $sentencia = $base_de_datos->query('SELECT COUNT(*) as matricula FROM matriculas');
    $row = $sentencia->fetchColumn();
    return $row;
}

function imprimePaginado($TotalRegistros, $limit, $pag){
    $tabla = '';
    $j = 1;
    $totalPag=ceil($TotalRegistros/$limit);
    $links=array();
    $limitPag = 20 + $pag;

    $links[]="<a style='border:solid 1px blue; padding-left:.6%; padding-right:.6%; padding-top:.25%; padding-bottom:.25%;' href=\"?pag=1\">1</a>";
    for($i=$pag; $i<=$limitPag; $i++)
    {
        if( $i == 1 ){
            $i++;
        }
        if($pag == $totalPag){
            break 1;
        }
        $links[]="<a style='border:solid 1px blue; padding-left:.6%; padding-right:.6%; padding-top:.25%; padding-bottom:.25%;' href=\"?pag=$i\">$i</a>";

    }
    $links[]="<a style='border:solid 1px blue; padding-left:.6%; padding-right:.6%; padding-top:.25%; padding-bottom:.25%;' href=\"?pag=$totalPag\">$totalPag</a>";
    $tabla.=''.implode(" ", $links);
    return $tabla;
}

function subirArchivo($archivo){
    if($_FILES['txt']['name'] != ""){

        $errors= array();
        $file_name = $_FILES['txt']['name'];
        $file_size = $_FILES['txt']['size'];
        $file_tmp = $_FILES['txt']['tmp_name'];
        $file_ext=explode('.',$_FILES['txt']['name']);
        $file_ext = strtolower(end($file_ext));
       
        $expensions = array("txt");
       
        if(in_array($file_ext,$expensions)=== false){
           $errors[]="No es la extencion correcta, solo admite txt";
        }
       
        if($file_size > 646986969 ) {
           $errors[]='El archivo es mas grande de 646 MB';
        }
       
        if(empty($errors)==true) {
          if(is_file('archivos/' . $file_name)){
              unlink('archivos/' . $file_name);
          }
            move_uploaded_file($file_tmp,"archivos/".$file_name);
            cargarDatos();
            return "Archivo Subido";
        }else{
           //print_r($errors);
            return "error";
        }
    }
    return "Archivo Incorrecto o Vacio";
}

function cargarDatos(){
    global $base_de_datos;

    $sql = 'DELETE FROM matriculas';
    $stmt = $base_de_datos->prepare($sql);
    $stmt->execute();

    $sentencia = $base_de_datos->exec("COPY matriculas (matricula, tipo_etiqueta) FROM 'C:\wamp64\www\PruebasConCopy\archivos\\export_distintivo_ambiental.txt' WITH DELIMITER '|'");
    return $sentencia;
}