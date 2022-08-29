<?php

require_once 'db/conexao.php';


$idEspecialidade =mysqli_escape_string($conn, $_GET["idespecialidade"]);

$sqlMedico ="select id, nome from tbmedico m inner join tbespecialidademedico espmed ON m.id = espmed.medico_id 
WHERE espmed.especialidade_id = ".$idEspecialidade;

$resultSetMedico = mysqli_query($conn, $sqlMedico);
if(mysqli_num_rows($resultSetMedico)>0){
    $listamedico = [];
    while($medico = mysqli_fetch_assoc($resultSetMedico)){
        array_push($listamedico,$medico);
    }
    echo json_encode(['status' => 'ok','medicos' => $listamedico]);
}else{
    echo json_encode(['status' => 'error','medicos' => []]);
}
mysqli_close($conn);