<?php
if (!empty($_POST)) {
    header('Content-Type: application/json; charset=utf-8');
    require_once "../Scripts/Database.php";

    function prepareQuery($data)
    {
        $colunms = implode(",", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        return ["colunms" => $colunms, "placeholders" => $placeholders];
    }

    switch ($_POST["type"]) {
        case "get":
            $dados = Database::query("Select * from pessoas");
            echo json_encode($dados);

            break;
        case "post":
            $props = prepareQuery($_POST["data"]);

            // Constroi a querry para colocar no bd.
            $query = "INSERT INTO pessoas (";
            $query .= implode(",", array_keys($_POST["data"]));
            $query .= ") VALUES (";
            $query .= str_repeat("?,", count($_POST["data"]) - 1) . "?";
            $query .= ")";

            // Execute insert and get the new ID
            $values = array_values($_POST["data"]);

            $lastId = Database::query($query, $values);

            $newRecord = Database::query("SELECT * FROM pessoas WHERE id = ?", [$lastId]);
            echo json_encode($newRecord);
            break;
        case "patch":
            $props = prepareQuery($_POST["data"]);
            $id = $_POST["data"]["id"];

            // Constroi a querry para colocar no bd.
            $query = "UPDATE pessoas SET ";
            $query .= implode(" = ?, ", array_keys($_POST["data"])) . " = ?";
            $query .= " WHERE id = ?";

            // Execute insert and get the new ID
            $values = array_values($_POST["data"]);
            $values[] = $id;

            Database::query($query, $values);

            $newRecord = Database::query("SELECT * FROM pessoas WHERE id = ?", [$id]);
            echo json_encode($newRecord);

            break;
        case "delete":
            $id = $_POST["id"];
            $query = "DELETE FROM pessoas WHERE id = ?";
            Database::query($query, [$id]);
            echo json_encode(["success" => true]);
            break;
    }


    return;
    exit();
}




?>


<!-- Gestor de pessoas -->
<section class="container mt-5">
    <table class="table table-hover  table-striped" id="tabelaPessoas">
        <thead class="table-primary">
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Idade</th>
                <th>Numero</th>
                <th>Bloco</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Sexo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="dadosTabelaPessoas">
            <tr>
                <td colspan="8" class="text-center py-5">
                    <img src="/assets/loading.gif" alt="Carregando..." class="loading-img">
                    <p class="mt-3 text-muted">Carregando dados, por favor aguarde...</p>
                </td>
            </tr>
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

    const AdicionarPessoa = (dados) => {
        $.ajax({
            type: "POST",
            url: "/Components/CRUD/ListaPessoas.php",
            data: {
                "type": "post",
                "data": dados
            },
            success: (response) => {
                if (response) {
                    console.log(response);
                }
            }
        });
    }
    const AlterarPessoa = (dados) => {
        $.ajax({
            type: "POST",
            url: "/Components/CRUD/ListaPessoas.php",
            data: {
                "type": "patch",
                "data": dados,
            },
            success: (response) => {
                if (response) {
                    console.log(response);
                }
            }
        });
    }
    const DeletarPessoa = (id) => {
        $.ajax({
            type: "POST",
            url: "/Components/CRUD/ListaPessoas.php",
            data: {
                "type": "delete",
                "id": id,
            },
            success: (response) => {
                if (response) {
                    console.log(response);
                }
            }
        });
    }

    /*{
        "id": "1",
        "nome": "Caroline",
        "dataNascimento": new Date(new Date().getTime() - (1000 * 60 * 60 * 24 * 30 * 12 * 20)).toISOString().split('T')[0],
        "numero": "123456789",
        "bloco": "C",
        "sexo": "Masculino",
        "email": "joao@gmail.com",
        "telefone": "123456789",
    }*/
    document.addEventListener("DOMContentLoaded", () => {
        BuscarDadosPessoas();
    })

    const MontarTabelaPessoas = (dados) => {
        $("#dadosTabelaPessoas").html("");

        dados.forEach(pessoa => {
            $("#dadosTabelaPessoas").append(`
                <tr>
                    <td>${pessoa.id}</td>
                    <td>${pessoa.nome}</td>
                    <td>${pessoa.dataNascimento}</td>
                    <td>${pessoa.numero}</td>
                    <td>${pessoa.bloco}</td>
                    <td>${pessoa.sexo}</td>
                    <td>${pessoa.email}</td>
                    <td>${pessoa.telefone}</td>
                    <td>
                        <button class="btn btn-primary" onclick="EditarPessoa(${pessoa.id})">Editar</button>
                        <button class="btn btn-danger" onclick="ExcluirPessoa(${pessoa.id})">Excluir</button>
                    </td>
                </tr>
            `);
        });
    }
</script>
</body>

</html>