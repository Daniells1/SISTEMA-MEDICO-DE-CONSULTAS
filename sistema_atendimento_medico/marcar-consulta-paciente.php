<?php 
require_once "db/conexao.php";
$cpf =mysqli_escape_string($conn, $_GET["cpf"]);

$sql = "select id, nome, cpf, foto from tbpaciente where cpf = ".$cpf;

$resultSet = mysqli_query($conn, $sql);
if(mysqli_num_rows($resultSet)>0){
    $paciente = mysqli_fetch_assoc($resultSet);

    echo json_encode(['status' => 'ok', 'paciente' => $paciente]);
}else{
    echo json_encode(['status' => 'error','paciente' => []]);
}
mysqli_close($conn);