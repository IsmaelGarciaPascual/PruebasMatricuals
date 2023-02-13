<?php

include('conexion.php');
/*try {
    $base_de_datos = new PDO("pgsql:host=$rutaServidor;port=$puerto;dbname=$nombreBaseDeDatos", $usuario, $contraseña);
    $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /*SELECT
    $sentencia = $base_de_datos->query("SELECT matricula, descripcion_etiqueta
    FROM matriculas INNER JOIN descripcion_etiquetas ON matriculas.tipo_etiqueta = descripcion_etiquetas.tipo_etiqueta;");
    $mascotas = $sentencia->fetchAll(PDO::FETCH_OBJ);
    print_r($mascotas);*/

    /*DELETE
    $sql = 'DELETE FROM matriculas';

    $stmt = $base_de_datos->prepare($sql);

    $stmt->execute();

    echo $stmt->rowCount();
    */

    //sentencia per a copiar el arxiu de les matricules.
    //$sentencia = $base_de_datos->exec("COPY matriculas (matricula, tipo_etiqueta) FROM 'C:\wamp64\www\PruebasConCopy\\export_distintivo_ambiental.csv' WITH DELIMITER '|'");

    //Select per a la paginacion.
    /* Select * FROM matriculas Order by matricula Limit 100 OFFSET 200*/

    /*$sentencia = $base_de_datos->query("SELECT matricula, descripcion_etiqueta
    FROM matriculas INNER JOIN descripcion_etiquetas ON matriculas.tipo_etiqueta = descripcion_etiquetas.tipo_etiqueta Order by matricula Limit 100 OFFSET 100");
    $mascotas = $sentencia->fetchAll(PDO::FETCH_OBJ);*/
    //print_r($mascotas);
    /*$sentencia = $base_de_datos->query("SELECT matricula, descripcion_etiqueta
    FROM matriculas INNER JOIN descripcion_etiquetas ON matriculas.tipo_etiqueta = descripcion_etiquetas.tipo_etiqueta LIMIT 100;");
    $matriculas = $sentencia->fetchAll(PDO::FETCH_OBJ);
    print_r($matriculas);*/
    //COPY matrculas[()] FROM 'export_distintivo_ambiental.txt' ( FORMAT CSV, DELIMITER('|') );
/*} catch (Exception $e) {
    echo "Ocurrió un error con la base de datos: " . $e->getMessage();
}*/

?>
<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
</head>
<body>

</body>
</html>

