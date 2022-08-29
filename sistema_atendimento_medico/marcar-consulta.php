<?php require_once "components/topo.php"; ?>
<style>
    .w-50{
    float:left;
    width: calc(100% / 2);
    box-sizing: border-box;
    padding:0.5rem;


}

.error{
    margin:0.5rem 0;
    padding: 1rem;
    border:1px solid #720000;
    background-color: #f82929;
    border-radius: 5px;
    color:#FFF;
}

</style>
<h1>Sistema Médico de Consultas - Marcar Consulta</h1>
<?php 
 require_once 'components/message.php'; 
 require_once 'db/conexao.php';
?>
<div id="resultError"></div>
<form action="marcar-consulta-save.php" method = "post" id="my-form">
    <input type="hidden" name = "idpaciente" id ="idpaciente">
    <div>
        <label for="" class="form-label">Informe o cpf do paciente:</label>
        <input type="text" name="cpf" id ="cpf" class="form-control">
    </div>
    <div id="resultado-paciente">

    </div>
    <div id="detalhes-consulta" style="display:none">
        <div class="w-50"> 
        <label for="" class="form-label">Especialidade:</label>
            <select name="especialidade" id="especialidade" class="form-control">
            <option value=""></option>
        <?php

 $sqlEspecialidade= "select id, especialidade from tbespecialidade";
 $rsEspecialidade = mysqli_query($conn,$sqlEspecialidade);
 if(mysqli_num_rows($rsEspecialidade)>0){
    while($especialidade = mysqli_fetch_assoc($rsEspecialidade)){
    ?>
        <option value="<?=$especialidade["id"] ?>"><?=$especialidade["especialidade"] ?></option>

   
    <?php    
    }
 }
 ?>

          
            </select>
        </div>
        <div class="w-50">
            <label for="" class="form-label">Médico:</label>
            <select name="medico" class="form-control" id="medico">
             <option value=""></option>
            </select>
        </div>
        <div class="w-50">
            <label for="" class="form-label">Data da Consulta:</label>
            <input type="text" id="dt_consulta" name="dt_consulta" class="form-control data-form" data-mask="99/99/9999">
        </div>
        <div class="w-50">
            <label for="" class="form-label">Hora da Consulta:</label>
            <input type="text" id="hr_consulta" name="hr_consulta" class="form-control" data-mask="99:99">
        </div>
        <input type="submit" value="Marcar Consulta" class="btn btn-save salvar-consulta">
    </div>

</form>
<script src='js/mascara.js'> </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.5/dayjs.min.js" integrity="sha512-Ot7ArUEhJDU0cwoBNNnWe487kjL5wAOsIYig8llY/l0P2TUFwgsAHVmrZMHsT8NGo+HwkjTJsNErS6QqIkBxDw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.5/plugin/customParseFormat.min.js" integrity="sha512-FM59hRKwY7JfAluyciYEi3QahhG/wPBo6Yjv6SaPsh061nFDVSukJlpN+4Ow5zgNyuDKkP3deru35PHOEncwsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script> 
dayjs.extend(window.dayjs_plugin_customParseFormat)
</script>
<script src="js/validar.js"> </script>

<script> 
    function limpar(){

        document.getElementById("idpaciente").value = ""
        document.getElementById("detalhes-consulta").style.display= 'none'
        
        document.getElementById("resultado-paciente").innerHTML = ""
 
    }
     document.getElementById('especialidade').addEventListener('change',(event)=>{
        let value = event.target.value
        
        let comboMedico = document.getElementById("medico")
        comboMedico.length = 1
        console.log(value)
        if(value !=""){
            fetch(`marcar-consulta-medico.php?idespecialidade=${value}`)
            .then(result => result.json())
        .then(result => {
          if(result.status == "ok"){
              result.medicos.forEach((value,index)=>{
                let option = document.createElement("option")
                  option.value = value.id
                  option.text = value.nome

                  comboMedico.add(option)

              })
          }else{

          }
        })
        .catch(error => {
            alert("Consulta do paciente não pode ser marcada")
            console.log(error)
        }) 

        }else{

        }
     })
    document.getElementById("cpf").addEventListener("blur",(event)=>{
        let cpf = event.target.value
        if(cpf != ''){
        fetch(`marcar-consulta-paciente.php?cpf=${cpf}`)
        .then(result => result.json())
        .then(result => {
        if(result.status == 'ok'){
            document.getElementById("detalhes-consulta").style.display= 'block'
            document.getElementById("idpaciente").value = result.paciente.id
            document.getElementById("resultado-paciente").innerHTML = `Paciente: ${result.paciente.nome}
            Preencha os outros campos para a consulta`

        }else{
            limpar()
            document.getElementById("resultado-paciente").innerHTML = "Paciente não encontrado."
        }
        })
        .catch(error => {
            alert("Consulta do paciente não pode ser marcada")
            console.log(error)
            limpar()
        })
    }else{
        limpar()
    }
    })

   

    document.getElementById("hr_consulta").addEventListener("blur",(event) =>{
        let valor = event.target.value
        let dateValid = dayjs(valor, 'HH:mm', true).isValid() 
        if(!dateValid){
            event.target.value = ""
            alert("Preencha uma hora válida")
        }
    })
    document.querySelector(".salvar-consulta").addEventListener('click', async (event)=> {
       
        document.getElementById("resultError").innerHTML= ""
        document.getElementById("resultError").classList.remove("error")
        

       let idpaciente = document.getElementById("idpaciente").value
       let medico = document.getElementById("medico").value
       let especialidade = document.getElementById("especialidade").value
       let dt_consulta = document.getElementById("dt_consulta").value
       let hr_consulta = document.getElementById("hr_consulta").value

       console.log(`${medico} ${especialidade} ${dt_consulta} ${hr_consulta} ${idpaciente}`)

       let msgErro = ""
       if(idpaciente ==""){
        msgErro += "Escolha o paciente<br>"
       }
       if(medico==""){
        msgErro += "Escolha um médico<br>"
       }
       if(especialidade==""){
        msgErro += "Escolha uma especialidade<br>"
       }
       if(dt_consulta==""){
        msgErro += "Escolha uma data de consulta<br>"
       }
       if(hr_consulta==""){
        msgErro += "Escolha um horário de consulta<br>"
       }
       if( msgErro != ""){
        document.getElementById("resultError").innerHTML= msgErro
        document.getElementById("resultError").classList.add("error")
        event.preventDefault()
        return;
       }
       let formData = new FormData();
       formData.append("idpaciente",idpaciente)
       formData.append("medico",medico)
       formData.append("especialidade",especialidade)
       formData.append("dtconsulta",dt_consulta)
       formData.append("hrconsulta",hr_consulta)
       event.preventDefault()
       let result = await  fetch('marcar-consulta-validar-ajax.php',{
        method: 'POST',
        body:formData
       })
       let dados = await result.json()
       if(dados.status == 'invalid'){
        document.getElementById("resultError").innerHTML = dados.message
        document.getElementById("resultError").classList.add("error")
       }else{
        document.querySelector("#my-form").submit()
       }

      

})
</script>
<?php require_once 'components/rodape.php'; ?>

