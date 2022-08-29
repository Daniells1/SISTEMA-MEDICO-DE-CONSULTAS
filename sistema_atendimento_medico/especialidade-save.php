<?php

require_once "db/conexao.php";
$especialidade = mysqli_escape_string($conn,$_POST["especialidade"]);

$sql = "insert into tbespecialidade(especialidade) VALUES('$especialidade')";

if(mysqli_query($conn, $sql)){
    $msg = "Especialidade cadastratada com sucesso!";
}else{
    $msg = "Especialidade não cadastratada!";
}
mysqli_close($conn);
header("location: especialidade.php?m=" . base64_encode($msg));