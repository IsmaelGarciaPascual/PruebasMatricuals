<?php
include('funciones.php');

$limit=100;
$pag = 0;
if(isset($_GET['pag'])){
  $pag=(int)$_GET['pag'];
}
if(!isset($_POST['matricula']) && !isset($_POST['distintivo'])){
  $_POST['matricula'] = "";
  $_POST['distintivo'] = "";
}

if($pag<1)
{
	$pag=1;
  $_GET['pag'] = 1;
}
$offset=($pag-1)*$limit;
?>
<html>
    <header>
        <link href="style.css" rel="stylesheet" type="text/css">
    </header>
<body>

<h2>Prueba del proyecto</h2>

<table style="width:100%">
  <tr>
    <th>Matricula</th>
    <th>Tipo Etiqueta</th>
  </tr>
<?php
  if($_POST['matricula'] == "" && $_POST['distintivo'] == ""){
  
    //$matriculas = selectCompleto($offset, $limit);
    $data = array(
      'limit'=>$limit,
      'offset'=>$offset
    );
    $data_json = json_encode($data);
    $url = "http://localhost/PruebasConCopy/API/" . "get_matriculas_lista";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response_json  = curl_exec($ch);
   
   
    curl_close($ch);
  error_log("response".$response_json);
    $response = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response_json), true);
    echo json_encode($response, JSON_PRETTY_PRINT);
    
    //$TotalRegistros = numeroDeRegistros('SELECT COUNT(*) as matricula FROM matriculas');
    //print_r( $arrayUsersTickets);
    
    /*foreach($matriculas as $matricula){?>
      <tr>
        <th><?= $matricula->matricula ?></th>
        <th><?= $matricula->descripcion_etiqueta ?></th>
      </tr>
   <?php }*/ ?>
   <tr>
      <th class="text-center" colspan="4">
        <?php 
           echo imprimePaginado($TotalRegistros, $limit, $pag); 
       ?> 
      </th>
    </tr>
  <?php }elseif($_POST['matricula'] != "" && $_POST['distintivo'] != ""){
    $matricula = selectMatricula($_POST['matricula']);?>
      <tr>
        <th><?= $matricula[0]->matricula ?></th>
        <th><?= $matricula[0]->descripcion_etiqueta ?></th>
      </tr>
   <?php 
  }elseif($_POST['matricula'] != ""){
    $matricula = selectMatricula($_POST['matricula']);?>
      <tr>
        <th><?= $matricula[0]->matricula ?></th>
        <th><?= $matricula[0]->descripcion_etiqueta ?></th>
      </tr>
   <?php 
  } elseif($_POST['distintivo']){
    $distintivos = selectDistintivo($_POST['distintivo']);
    foreach($distintivos as $distintivo){?>
      <tr>
        <th><?= $distintivo->matricula ?></th>
        <th><?= $distintivo->descripcion_etiqueta ?></th>
      </tr>
   <?php } 
  }
  if(isset($_FILES["txt"])){
      $repuesta = subirArchivo($_FILES["txt"]);
      unset($_FILES['txt']);
      echo $repuesta;
  }
?>
</table>

<h1>Filtros</h1>

<form action="/PruebasConCopy/index.php" method="post">
  <label for="matricula">Matricula:</label><br>
  <input type="text" id="matricula" name="matricula" value=""><br>
  <label for="distintivo">Distintivo:</label><br>
  <input type="text" id="distintivo" name="distintivo" value=""><br><br>
  <input type="submit" value="Submit">
</form>


<form action="index.php" method="post" enctype="multipart/form-data">
        <input type="file" name="txt"/>
        <input type="submit" name="submit" value="upload"/>
</form>
</body>
</html>