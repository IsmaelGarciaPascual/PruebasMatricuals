<?php
include("Conexion.php");
$base_de_datos = new PDO("pgsql:host=$rutaServidor;port=$puerto;dbname=$nombreBaseDeDatos", $usuario, $contraseña);
$base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$subido = false;
print_r($_POST);
   if(isset($_FILES['txt'])){

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
        echo "Success";
        $subido = true;
      }else{
         print_r($errors);
      }
   }


   if($subido){
    echo " subido";
   $subido = false;
   //header("Location: index.php");
   }
?>