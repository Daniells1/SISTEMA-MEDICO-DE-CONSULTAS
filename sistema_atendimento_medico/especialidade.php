
<?php require_once "components/topo.php"; ?>

<h1>Sistema Médico de Consultas - Especialidade</h1>

<?php require_once "components/message.php"; ?>


<form action="especialidade-save.php" method="post">
    <div>
        <label class="form-label">Nome da Especialidade:</label>
        <input type="text" name="especialidade" id="especialidade" class="form-control">
    </div>
    <input type="submit" value="Salvar" class="btn btn-save">
</form>
<?php 
require_once "db/conexao.php";
$sql = "select id, especialidade from tbespecialidade";
$rsEspecialidade = mysqli_query($conn,$sql);
if(mysqli_num_rows($rsEspecialidade)>0){


?>
<table class="my-table">
<thead>
    <tr>
        <th>ID</th>
        <th>ESPECIALIDADE</th>
    </tr>

</thead>
<tbody>
    <?php while($especialidade = mysqli_fetch_assoc($rsEspecialidade)){?>
    <tr>
        <td>
            <?=$especialidade["id"]?>
        </td>
        <td>
        <?=$especialidade["especialidade"]?>

        </td>
    </tr>
    <?php } ?>
</tbody>
</table>
<?php } ?>
<?php require_once 'components/rodape.php'; ?>