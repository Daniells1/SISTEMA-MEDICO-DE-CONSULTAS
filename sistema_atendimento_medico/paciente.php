<?php require_once 'components/topo.php'; ?>
<h1>Sistema Médico de Consultas - Paciente</h1>
<?php require_once "components/message.php"; ?>

<form action="paciente-save.php" method="post" enctype="multipart/form-data">
    <div>
        <label class="form-label" for="nome">Nome:</label>
        <input type="text" class="form-control" name="nome" id="nome">
    </div>
    <div>
        <label class="form-label" for="cpf">CPF:</label>
        <input type="text" class="form-control" name="cpf" id="cpf">
    </div>
    <div>
        <label class="form-label" for="foto">Foto:</label>
        <input type="file" class="form-control" name="foto" id="foto">
    </div>
    <input type="submit" value="Salvar Paciente" class="btn btn-save">
</form>

<?php require_once 'components/rodape.php'; ?>