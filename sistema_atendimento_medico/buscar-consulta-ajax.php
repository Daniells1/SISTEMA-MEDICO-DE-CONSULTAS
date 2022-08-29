<?php

require_once "db/conexao.php";
require_once "util/funcao.php";

$cpf=$_POST["cpf"];
$medico = $_POST["medico"];
$data =$_POST["data"];
$status =$_POST["status"];

$cpf = onlyNumber($cpf);

if($data != ""){
     $dataDb = convertDate($data);
      }else{
    $dataDb =date('Y-m-d');
}

$sqlConsulta = "select c.id as idconsulta, c.dt_consulta, c.hr_consulta, c.status, m.nome as nomemedico, p.nome as nomepaciente, 
                e.especialidade, p.id as idpaciente
                from tbconsulta c 
                inner join tbpaciente p ON p.id = c.paciente_id
                inner join tbmedico m ON m.id = c.medico_id
                inner join tbespecialidade e ON e.id = c.especialidade_id
                 WHERE c.dt_consulta ='".$dataDb."' 
                   ";

if($medico != "")
    $sqlConsulta .= " AND m.id =". $medico;
if($cpf != "")
    $sqlConsulta .= " AND p.cpf ='".$cpf."' ";
/*
STATUS
ATV
CAN 
FIN
*/
if($status != "")
         $sqlConsulta .= "AND c.status = '".$status."'";
else         
$sqlConsulta .= "AND c.status IN ('ATV','FIN')" ;   

$sqlConsulta .= "ORDER BY hr_consulta";                  

$resultSetConsulta = mysqli_query($conn, $sqlConsulta);
$lista = [];
if(mysqli_num_rows($resultSetConsulta)>0){
    while($consulta = mysqli_fetch_assoc($resultSetConsulta)){
      //  $dt = DateTime::createFromFormat("Y-m-d", $consulta["dt_consulta"]);
        //$consulta["dt_consulta"]= $dt->format("d/m/Y");
        $consulta["status"] =getStatus($consulta["status"]);
        $consulta["dt_consulta"]= convertDate($consulta["dt_consulta"],"-","/");
        array_push($lista,$consulta);
    }
}

echo json_encode(['status' => 'ok', 'dados' => $lista]); //
