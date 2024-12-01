<?php 
if (!empty($_POST)) {
    header('Content-Type: application/json; charset=utf-8');
    require_once "../Scripts/Database.php";


    switch($_POST["type"]) {
        case "get":
            $dados = Database::query("Select * from pessoas");
            echo json_encode($dados);
            break;
        case "post":

            break;

        case "patch":
            break;
        case "delete":

            break;
    }



    exit();
}




?>


<!-- Gestor de pessoas -->
<section>
    <table class="" id="tabelaPessoas">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Idade</th>
                <th>Numero</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Sexo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="dadosTabelaPessoas">

        </tbody>
    </table>
</section>

<form id="cadastroForm" action="#" method="post" onsubmit="return validarFormulario()" class="container mt-4 p-4 shadow-sm rounded bg-light">
    <h3 class="mb-4 text-center">Cadastro</h3>
    <div class="mb-3">
        <label for="nome" class="form-label">Nome Completo:</label>
        <input type="text" id="nome" name="nome" class="form-control" required placeholder="Digite seu nome completo">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">E-mail:</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="telefone" class="form-label">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" class="form-control" required>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="apartamento" class="form-label">Número do Apartamento:</label>
            <input type="text" id="apartamento" name="apartamento" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="bloco" class="form-label">Bloco:</label>
            <input type="text" id="bloco" name="bloco" class="form-control" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="dataNascimento" class="form-label">Data de Nascimento:</label>
        <input type="date" id="dataNascimento" name="dataNascimento" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="sexo" class="form-label">Sexo:</label>
        <select id="sexo" name="sexo" class="form-select" required>
            <option value="">Selecione</option>
            <option value="masculino">Masculino</option>
            <option value="feminino">Feminino</option>
            <option value="outro">Outro</option>
        </select>
    </div>
    <div class="d-flex justify-content-between">
        <button type="submit" name="submit" class="btn btn-primary"><b>Cadastrar</b></button>
        <button type="button" class="btn btn-secondary"><b>Cancelar</b></button>
    </div>
</form>








<script>
    const BuscarDadosPessoas = () => {
        $.ajax({
            type: "POST",
            url: "/Components/CRUD/ListaPessoas.php",
            data: {
                "type": "get",
            },
            success: (response) => {
                if (response) {
                    MontarTabelaPessoas(response);
                }
            }
        });

    }

    document.addEventListener("DOMContentLoaded", () => {
        BuscarDadosPessoas();
    })

    const MontarTabelaPessoas = (dados) => {
        console.log(dados)
        $("#dadosTabelaPessoas").html(
            "yo waddup"
        )



        
    }
</script>
</body>

</html>