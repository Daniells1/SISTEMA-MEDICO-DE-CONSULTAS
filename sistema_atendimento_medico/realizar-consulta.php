
<?php require_once "components/topo.php";
require_once 'db/conexao.php';
require_once 'util/funcao.php';


$id = mysqli_escape_string($conn,$_GET["id"]);
$sqlConsulta = "select m.nome nomemedico, m.crm crmmedico, c.id idconsulta , c.dt_consulta, c.hr_consulta, e.especialidade, p.nome nomepaciente, p.cpf cpfpaciente
                from tbconsulta c
                inner join tbmedico m on m.id = c.medico_id
                inner join tbpaciente p on p.id = c.paciente_id
                inner join tbespecialidade e on e.id = c.especialidade_id
                where c.id=".$id;

$resultsetConsulta = mysqli_query($conn,$sqlConsulta);
if(mysqli_num_rows($resultsetConsulta)!= 1){
    mysqli_close($conn);
    header("location: buscar-consulta.php?m=". base64_encode("Consulta não encontrada"));

}       
$consulta = mysqli_fetch_array($resultsetConsulta) ;        
?>
<link href="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/css/suneditor.min.css" rel="stylesheet">
<!-- <link href="https://cdn.jsdelivr.net/npm/suneditor@latest/assets/css/suneditor.css" rel="stylesheet"> -->
<!-- <link href="https://cdn.jsdelivr.net/npm/suneditor@latest/assets/css/suneditor-contents.css" rel="stylesheet"> -->
<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/suneditor.min.js"></script>


<h1>Sistema Médico de Consultas - Buscar Consulta</h1>


<p id="detalhes">
    <form action="realizar-consulta-save.php" method="post">
     <input type="hidden" name="idconsulta" value = "<?=$consulta["idconsulta"]?>">   
    <div>
        <label for="" class="form-label">Paciente:</label>
        <?=$consulta["nomepaciente"] . "/" . $consulta["cpfpaciente"]?>
    </div>
    <div>
        <label for="" class="form-label">Médico:</label>
        <?=$consulta["nomemedico"] . "/" . $consulta["crmmedico"]. "/" .$consulta["especialidade"]?>
    </div>
    <div>
        <label for="" class="form-label">Data da Consulta:</label>
        <?=convertDate($consulta["dt_consulta"],"-","/") ?>
    </div>
    <div>
        <label for="" class="form-label">Hora da Consulta:</label>
        <?=$consulta["hr_consulta"] ?>
    </div>
    <div>
        <label for="" class="form-label">Consulta médica:</label>
        <textarea name="consulta_medica" class="form-control" id="consulta_medico"></textarea>
    </div>
    <input type="submit" value="Salvar Consulta" class="btn btn-save">
    </form>
</p>
<script>
    const editor = SUNEDITOR.create((document.getElementById('consulta_medico')||'consulta_medico'),{
        font:[
            'Arial',
            'tohoma',
            'Courier New,Courier'
        ],
        fontSize : [
            8,10,14,18,24,36
        ],
        colorList : [
            ['#ccc','#dedede','OrangeRed','Orange','RoyalBlue','SaddleBrown'],
            ['SlateGray','BurlyWood','DeepPink','FireBrick','Gold','SeaGreen'],
        ],
        buttonList : [
            ['font','fontSize','formatBlock',
        'bold','underline','italic','strike','subscript','superscript',
        'fontColor','hiliteColor','textStyle'],
        ]

        

    });
    editor.onChange = function(e,core){
        document.getElementById("consulta_medico").value = e
    }
</script>
<?php require_once "components/rodape.php";?>