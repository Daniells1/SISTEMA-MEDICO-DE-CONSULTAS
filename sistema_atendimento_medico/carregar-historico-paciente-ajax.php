<?php 
require_once "db/conexao.php";
require_once "util/funcao.php";

$id =mysqli_escape_string($conn,$_GET["id"]);

$sql = "select dt_consulta, hr_consulta, m.nome nomemedico, p.nome nomepaciente, m.crm crmmedico,p.cpf cpfpaciente,c.status,
         c.consulta,IFNULL(c.consulta,'') consulta, e.especialidade
         from tbconsulta c
         inner join tbpaciente p on p.id = c.paciente_id
         inner join tbmedico m on m.id = c.medico_id
         inner join tbespecialidade e on e.id = c.especialidade_id
         where p.id = ".$id." order by c.dt_consulta DESC";

$resultSetConsulta = mysqli_query($conn,$sql);
$lista =[];
if(mysqli_num_rows($resultSetConsulta)>0){
    while($consulta = mysqli_fetch_assoc($resultSetConsulta)){
        $consulta["dt_consulta"] = convertDate($consulta["dt_consulta"],"-","/");
        $consulta["status"] = getStatus($consulta["status"]);
        
        array_push($lista, $consulta);
    }

}       
mysqli_close($conn);
echo json_encode(['status' => 'ok','lista' => $lista]) ; 