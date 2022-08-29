<?php
//id =="" insert ----- $id!="" uptdate
$id = $_POST["id"];
$nome = $_POST["nome"];
$crm = $_POST["crm"];
$especialidades=$_POST["especialidades"];


$foto = $_FILES["foto"];

$valid =true;
$msg ="";


//foi enviado uma foto?
if($foto["name"] != ""){
    

//validações: 

    //1024 * 1024 * 2 = 2MB

    if($foto["size"] > (1024 * 1024 * 2)){
    $msg ="Tamanho da foto é inválido,adcionar apenas arquivos menores ou iguais a 2MB";
    $valid = false;
    }

    if(!in_array($foto["type"] , ['image/jpeg'])){
        $msg = "Tipo do arquivo é inválido";
        $valid = false; 
    }
    
    
//enviar foto para o servidor
 /*  if($valid){
    move_uploaded_file($foto["tmp_name"], "fotomedico/foto1.jpg");
   }
   */
}
if(!$valid){
    header("location: medico.php?m=" . base64_encode($msg));
    exit;
}

require_once "db/conexao.php";
mysqli_autocommit($conn, false);

//foto1.jpg
$extensao = explode(".", $foto["name"]);
//0 => foto1, 1 => jpg

$numeroPosicao = count($extensao);

$ext = $extensao[$numeroPosicao - 1];

$fileName = date('YmdHis').rand(1000,9999) . "." . $ext;

$sql = "insert into tbmedico values(NULL, '".$nome."', '".$crm."','".$fileName."')";

if($id != ""){
$sqlMedico = "select id, foto from tbmedico where id = ".$id;

$resultSetMedico = mysqli_query($conn , $sqlMedico);
if(mysqli_num_rows($resultSetMedico)>0){
    $medico = mysqli_fetch_assoc($resultSetMedico);
    if($foto["name"] == ""){

        $fileName = $medico["foto"];
    }
    $sql = "update tbmedico set nome = '".$nome."',crm ='".$crm."', foto = '".$fileName."' where id = " . $id;

    
         }
} 
if(mysqli_query($conn,$sql)){

    $idmedico= mysqli_insert_id($conn);
    if($id != "") $idmedico = $id;

    $sqlDeleteEspecialidade = "delete from tbespecialidademedico where medico_id = " . $idmedico;
    mysqli_query($conn,$sqlDeleteEspecialidade);

    if(count($especialidades)>0){
        foreach($especialidades as $value  ){
            $sqlInsertEspecialidade = "insert into tbespecialidademedico values(" .$value.", ".  $idmedico .")";
            mysqli_query($conn,$sqlInsertEspecialidade);
        }
    } 

    mysqli_commit($conn);

    if($id != "" && $foto["name"] != ""){
    //excluir arquivo    
    unlink("fotomedico/" . $medico["foto"]) ;   
   
    }
    if($foto["name"] != "")
    move_uploaded_file($foto["tmp_name"],"fotomedico/" . $fileName);
    $msg ="Médico cadastrado com sucesso!";
    

}else{
    $msg ="Erro:Médico não salvo";

}


    

mysqli_close($conn);
header("location: medico.php?m=" . base64_encode($msg)) ;
exit;