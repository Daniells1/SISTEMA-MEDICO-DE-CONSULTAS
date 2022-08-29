<?php
$crm = $_POST["crm"];

require_once 'db/conexao.php';

$sql ="select id, nome, foto from tbmedico where crm ='" .$crm. "' limit 1";
$rsMedico = mysqli_query($conn, $sql);
if(mysqli_num_rows($rsMedico) > 0){
    $medico = mysqli_fetch_assoc($rsMedico);
    echo json_encode(['status' => 'ok', 'medico' => [
        'nome' => $medico["nome"], 'id' => $medico["id"], 'foto' => $medico["foto"]
    ]]);
}else{
echo json_encode([ 'status' => 'error' , 'message' => 'CRM não encontrado']);
}