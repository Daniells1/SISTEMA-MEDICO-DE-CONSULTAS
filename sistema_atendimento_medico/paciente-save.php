<?php
$nome=$_POST["nome"];
$cpf=$_POST["cpf"];
$foto =$_FILES["foto"];
$msg = "Paciente salvo com sucesso!";

$valid =true;

if($foto["name"]!=""){
    if($foto["size"] > (1024 * 1024 * 2)){
        $msg = "Tamanho da foto deve ser menor que 2MB";
        $valid = false;
    }

if(!in_array($foto["type"],['image/jpeg','image/png' ])){
    $msg = "Arquivo Inválido";
    $valid = false;
        }
}

require_once "db/conexao.php";

$sqlCpf= "select id from tbpaciente where cpf = '" .$cpf."'"; 
$rsPaciente = mysqli_query($conn , $sqlCpf);
if(mysqli_num_rows($rsPaciente) > 0){   
        $msg = "Paciente já cadastrado no sistema";
        $valid = false;
    }

if($valid){ 

   $fileName =""; 
   if($foto["name"] != ""){
    //CONSTRUÇÃO da extensão do $fileName
    //toda vez que encontrar um ponto ele vai criar uma posição no array
    $extensao = explode(".", $foto["name"]);
    $numeroPosicao = count($extensao);

    $ext = $extensao[$numeroPosicao - 1];

    //foto.jpg -- explode(".")
    //[0=>foto, 1=> jpg]  

    $fileName = date('YmdHis').rand(1000,9999) . "." . $ext;
   }

   $sqlInsertPaciente= "insert into tbpaciente values(NULL, '".$nome."', '".$cpf."','".$fileName."')";
  if(mysqli_query($conn,$sqlInsertPaciente)){
    move_uploaded_file($foto["tmp_name"],"fotopaciente/". $fileName);
    $msg ="Paciente salvo com sucesso!";
  }else{
    $msg ="Paciente não salvo";
  }
}

header("location:paciente.php?m=" . base64_encode($msg));
