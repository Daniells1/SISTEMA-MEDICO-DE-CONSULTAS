<?php 

require_once "db/conexao.php";

$consulta_medica = $_POST["consulta_medica"];
$idconsulta = $_POST["idconsulta"];

$sqlUpdateConsulta = "update tbconsulta set consulta = '".$consulta_medica."',status = 'FIN' where id =".$idconsulta;

if(mysqli_query($conn,$sqlUpdateConsulta)){
    $msg = "Consulta realizada com sucesso!";
}else{
    $msg = "Consulta não realizada";
}
mysqli_close($conn);
header("location: buscar-consulta.php?m=".base64_encode($msg));
