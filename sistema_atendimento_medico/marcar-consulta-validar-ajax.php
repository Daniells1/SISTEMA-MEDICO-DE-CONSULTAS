<?php
require_once "db/conexao.php";
require_once "util/funcao.php";

$medico = $_POST["medico"];
$dtconsulta = $_POST["dtconsulta"];
$hrconsulta = $_POST["hrconsulta"];

$dtconsultaDb = convertDate($dtconsulta);

$sqlValidarMedicoHorario ="select id from tbconsulta where medico_id = " .$medico. " and dt_consulta  = '".$dtconsultaDb."' 
and hr_consulta = '".$hrconsulta."'";

//echo  $sqlValidarMedicoHorario;
//exit;

$rsValidarMedicoHorario = mysqli_query($conn, $sqlValidarMedicoHorario);
$dtResposta = ["status" => 'ok'];

if(mysqli_num_rows($rsValidarMedicoHorario)>0){
    $dtResposta = (['status' => 'invalid','message' => 'Horário não disponível para este médico']);

}
mysqli_close($conn);
echo json_encode($dtResposta);
