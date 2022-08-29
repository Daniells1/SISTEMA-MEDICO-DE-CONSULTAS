<?php
$nome = $_POST["nome"];

$cpfcrm = $_POST["cpf_crm"];
$tipo = $_POST["tipo"];

require_once "db/conexao.php";
require_once "util/funcao.php";


//$sql ="select  id, nome, cpf , foto from tbpaciente p WHERE  p.nome like '".$nome."%'";

$sql = "select id,nome,cpfcrm,foto,tipo FROM(
    select id,nome,crm as cpfcrm,concat('fotomedico/',foto) as foto,'MED' as tipo from tbmedico
     UNION ALL
    select id,nome,cpf as cpfcrm,concat('fotopaciente/',foto) as foto,'PAC' as tipo from tbpaciente
        ) as consulta  WHERE  consulta.nome like '".$nome."%'  ";

if($cpfcrm != ""){
    $sql .= " AND cpfcrm = '".$cpfcrm."' ";
}
if($tipo != ""){
    $sql .= " AND tipo = '".$tipo."' ";
}

$registro =[];
$resultSetUsuario = mysqli_query($conn, $sql);
if(mysqli_num_rows($resultSetUsuario)){
    while($usuario = mysqli_fetch_assoc($resultSetUsuario)){
        $usuario["tipo"] = getTipo($usuario["tipo"]);
        array_push($registro,$usuario);

    }
}
mysqli_close($conn);
echo json_encode(['usuarios' => $registro]);
