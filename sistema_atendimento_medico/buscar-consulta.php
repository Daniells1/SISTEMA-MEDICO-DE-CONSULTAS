<style>
  .btn-danger{
    background-color: #720000;
    color: #FFF;

}
a.btn-link{
  text-decoration: none;
}

.w-25{
    float:left;
    width: calc(100% / 4);
    box-sizing: border-box;
    padding:0.5rem;


}
#modal-conteudo{
   padding :0.5rem; 
}
#modal-conteudo div{
    padding :1rem 0; 
    border-bottom: 1px solid #600086;
}

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/ldCover@v1.0.0/dist/ldcv.min.css">
<?php require_once "components/topo.php";
require_once 'db/conexao.php'
?>

<h1>Sistema Médico de Consultas - Buscar Consulta</h1>

<?php require_once "components/message.php"; ?>

<form action="" method ="POST">
    <div class="w-25">
      <label for="data" class="form-label">Data:</label>
      <input type="text" class="form-control data-form" name="data" id ="data" data-mask="99/99/9999">
    </div>
    <div class="w-25">
      <label for="medico" class="form-label">Medico:</label>
      <select name="medico" id="medico" class = "form-control">
        <option value=""></option>
        <?php 
          $sql = "select id, nome, crm from tbmedico order by nome";
          $resultSetMedico = mysqli_query($conn,$sql);
          if(mysqli_num_rows( $resultSetMedico) > 0){
            while($medico = mysqli_fetch_assoc($resultSetMedico)){
                echo "<option value ='".$medico["id"]."'>".$medico["nome"]." - "."CRM: ".$medico["crm"]."</option>";
            }
          }
        ?>
      </select>
    </div>
    <div class="w-25">
      <label for="paciente" class="form-label">CPF do Paciente:</label>
      <input type="text" class="form-control" name="cpf" id ="cpf" data-mask="999.999.999-99">
    </div>
    <div class="w-25">
      <label for="status" class="form-label">Status da Consulta:</label>
      <select name="status" id="status" class="form-control">
        <option value=""></option>
        <option value="ATV">Ativos</option>
        <option value="FIN">Finalizados</option>
        <option value="CAN">Cancelados</option>
      </select>
    </div>
    <div class="clear"></div>
<input type="submit" value="Consultar" class="btn btn-save" id="btnfind">
</form>
<div id="resultado" style = "display:none">
<table id="myTable" class="my-table">
  <thead>
   <th>Paciente</th>
   <th>Médico</th> 
   <th>Especialidade</th>
   <th>Data / Hora</th>
   <th>Status</th>
   <th></th>
  
  </thead>
  <tbody></tbody>
</table>
</div>
<div id="my-modal" class="ldcv lg">
  <div class="base">
    <div class="inner card">
      <div class="modal-body">
        <div id="modal-conteudo">
          Consulta do Paciente
        </div>
      </div>

    </div>
  </div>

</div>
<script src="js/mascara.js"> </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.5/dayjs.min.js" integrity="sha512-Ot7ArUEhJDU0cwoBNNnWe487kjL5wAOsIYig8llY/l0P2TUFwgsAHVmrZMHsT8NGo+HwkjTJsNErS6QqIkBxDw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.5/plugin/customParseFormat.min.js" integrity="sha512-FM59hRKwY7JfAluyciYEi3QahhG/wPBo6Yjv6SaPsh061nFDVSukJlpN+4Ow5zgNyuDKkP3deru35PHOEncwsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script> 
dayjs.extend(window.dayjs_plugin_customParseFormat)
</script>
<script src="https://cdn.jsdelivr.net/gh/loadingio/ldCover@v1.0.0/dist/ldcv.min.js"></script>


<script src="js/validar.js"> </script>
<script>
    document.getElementById("btnfind").addEventListener('click',(event) => {
        event.preventDefault()
        document.querySelector("#myTable tbody").innerHTML = ''
        document.querySelector("#resultado").style.display = 'none'
        let cpf = document.getElementById("cpf").value
        let medico = document.getElementById("medico").value
        let data = document.getElementById("data").value
        let status = document.getElementById("status").value


        let formData = new FormData()
        formData.append("cpf",cpf)
        formData.append("medico",medico)
        formData.append("data",data)
        formData.append("status",status)

        fetch(`buscar-consulta-ajax.php`,{
            method:'POST',
            body:formData
        })
        .then(result => result.json())
        .then(result => {
           if(result.dados.length > 0){
            if(result.status == "ok"){
              result.dados.forEach((value,index) => {
              document.querySelector("#resultado").style.display = 'block'  
              linha = `<tr>
              <td>${value.nomepaciente}</td>
              <td>${value.nomemedico}</td> 
              <td>${value.especialidade}</td>
              <td>${value.dt_consulta} ${value.hr_consulta}</td>
              
              <td>${value.status}</td>
              <td>
              <a href='#' onclick='carregarHistorico(${value.idpaciente})' class = 'btn btn-save btn-link'><i class="fas fa-history"></i></a>`
              

              if(value.status == 'Ativo'){
                 linha +=`
                 <a href='realizar-consulta.php?id=${value.idconsulta}' class = 'btn btn-save btn-link'><i class="fa-solid fa-calendar-check"></i></a>
                 <a href='cancelar-consulta.php?id=${value.idconsulta}' class = 'btn btn-danger btn-link'><i class="fa-solid fa-calendar-xmark"></i></a>`
                }
                linha += `</td></tr>`

              document.querySelector("#myTable tbody").innerHTML += linha;
              })
            }
          }
        })
        .catch(error => {
            console.log(error)
            alert("Consulta não pode ser realizada.")
        }
        )
        
    }
    
    )
    function carregarHistorico(idPaciente){
      document.getElementById("modal-conteudo").innerHTML =''
      fetch(`carregar-historico-paciente-ajax.php?id=${idPaciente}`)
      .then(result => result.json())
      .then(result =>{
        console.log(result)
        result.lista.forEach((value,index) =>{
          let msg =`<div>

                     Médico: ${value.nomemedico} - CRM:  ${value.crmmedico}<br>
                     Especialidade: ${value.especialidade}<br> 
                     Data da Consulta: ${value.dt_consulta}<br>
                     Hora da Consulta: ${value.hr_consulta}<br>
                     Status da Consulta: ${value.status}<br>
                     Consulta: ${value.consulta}<br>
                    

                    </div>
          
          `
          document.getElementById("modal-conteudo").innerHTML += msg

        })

        let ldcv =  new ldCover({root: '#my-modal'})
        ldcv.toggle()
      
      })
      .catch(error => {
        console.log(error)
        alert("Ocorreu um erro na consulta do histórico.")
      })

    }

</script>

<?php require_once 'components/rodape.php'; ?>