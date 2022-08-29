<?php
require_once "db/conexao.php";

$id =mysqli_escape_string($conn, $_GET["id"]);

$sql = " UPDATE tbconsulta set status ='CAN' where id = ".$id;
if(mysqli_query($conn, $sql)){
    $msg = "Consulta cancelada com sucesso";
    }else{
    $msg = "Consulta não pode ser cancelada";   
    }
mysqli_close($conn);
header("location: buscar-consulta.php?m=". base64_encode($msg));