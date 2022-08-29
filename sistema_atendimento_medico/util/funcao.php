<?php

function getTipo($tipo = ""){
    if($tipo == "MED"){
        return "Médico";
    
}else if($tipo == "PAC"){
      return "Paciente";    
}
return "";
}

function convertDate($data, $patternIn = "/", $patternOut = "-"){
    //20/10/2020 ----- /
    //[20, 10 , 2020]
    $dataExplode = explode($patternIn, $data);
    //20/10/2020
    //[2020, 10 , 20]
    $dataExplode = array_reverse($dataExplode);

     //[2020, 10 , 20] 
     //2020-10-20 
    return implode($patternOut, $dataExplode );

}

function onlyNumber($valor){
    //adicionar ^ procurar todos que não forem números
    //123.456--123456
    //la98.53b1--98531
    return preg_replace("/[^0-9]/","",$valor);
}

function getStatus($status){
    switch($status){
        case 'ATV':
           return "Ativo";
        case 'FIN':
            return "Finalizado";
        case 'CAN':
            return "Cancelado";
            default: return "NTD";   
    }
}