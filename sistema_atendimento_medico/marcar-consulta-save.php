<?php 
//resgate dos dados
$idpaciente =$_POST["idpaciente"];
$especialidade =$_POST["especialidade"];
$medico =$_POST["medico"];
$dt_consulta = $_POST["dt_consulta"];
$hr_consulta = $_POST["hr_consulta"];


require_once "util/funcao.php";

$dt_consulta_db = convertDate($dt_consulta);



require_once "db/conexao.php";

$sqlMarcarConsulta = "insert into tbconsulta values(NULL, '".$dt_consulta_db."','".$hr_consulta."', 'ATV', NULL,
". $medico .  " ," .$especialidade." ," .$idpaciente. ")";

//echo $sqlMarcarConsulta;

 if(mysqli_query($conn,$sqlMarcarConsulta)){
    $msg = "Consulta marcada com sucesso!";
 }else{
    $msg = "Consulta não pode ser marcada";
 }
 mysqli_close($conn);
 header("location: marcar-consulta.php?m=" . base64_encode($msg));
