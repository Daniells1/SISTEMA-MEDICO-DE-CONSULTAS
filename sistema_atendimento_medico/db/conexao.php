<?php 

//$dbEnv = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "projetos/sistema_atendimento_medico/.env");
//var_dump($dbEnv);
/*$host = $dbEnv["HOST"];
$username = $dbEnv["USERNAME"];
$password =$dbEnv["PASSWORD"];
$dbname =$dbEnv["DBNAME"];
era para funcionar
*/
$host = "localhost";
$username = "root";
$password ="";
$dbname ="sistemamedico";

$conn =mysqli_connect($host, $username, $password, $dbname);

if(mysqli_connect_errno()){
    echo "Erro na conexão com o banco de dados". mysqli_connect_error();
    exit;
}