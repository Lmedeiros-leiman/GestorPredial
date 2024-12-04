<?php
if (!empty($_POST)) {
    header('Content-Type: application/json; charset=utf-8');
    require_once "../Scripts/Database.php";

    function prepareQuery($data) {
        $colunms = implode(",", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        return ["colunms" => $colunms, "placeholders" => $placeholders];
    }

    switch ($_POST["type"]) {
        case "get":
            $filter = $_POST["filter"];
            $dados = [];
            if (empty($filter)) {
                $dados = Database::query("Select * from pessoas");
            } else {
                $dados = Database::query("SELECT * FROM pessoas WHERE LOWER(nome) LIKE LOWER(?)", [$filter]);
            }


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

<style>
    tbody#dadosTabelaPessoas>tr>td {
        transition: all ease-in-out 0.3s;
    }

    tbody#dadosTabelaPessoas>.highlight>td {
        background-color: #198754 !important;
        /* Mesma cor que bg-success do Bootstrap */
        color: #fff !important;
        /* Texto branco */
    }
</style>

<!-- Tabela de pessoas -->
<section class="container mt-5">
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-3 p-3">
  <div class="container-fluid">
    <!-- Navbar Brand -->
    <a class="navbar-brand fw-bold fs-4" href="#">Gestor de Pessoas</a>

    <!-- Navbar Toggle for Responsive View -->
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarContent"
      aria-controls="navbarContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Content -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <button
            class="btn btn-primary me-2"
            data-bs-toggle="modal"
            data-bs-target="#ModalEdicaoDados"
            onclick="MontarCadastrador()"
          >
            Cadastrar
          </button>
        </li>
      </ul>

      <!-- Search Form -->
      <form class="d-flex align-items-center" id="searchPersonForm">
        <input
          class="form-control me-2"
          type="search"
          placeholder="Buscar pessoa"
          aria-label="Search"
        />
        <button class="btn btn-outline-success me-2" type="submit">Buscar</button>
        <button
          class="btn btn-outline-secondary"
          type="reset"
          id="btnExportar"
          onclick="BuscarDadosPessoas()"
        >
          Reiniciar
        </button>
      </form>
    </div>
  </div>
</nav>
    <table class="table table-hover  table-striped" id="tabelaPessoas">
        <thead class="table-primary">
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Numero</th>
                <th>Bloco</th>
                <th>Sexo</th>
                <th>Idade</th>
                <th>Telefone</th>
                <th>Email</th>
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




<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<section
    class="modal fade"
    id="ModalEdicaoDados"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    role="dialog"
    aria-labelledby="modalTitleId"
    aria-hidden="true">
    <div
        class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    {{ Titulo Modal }}
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="formAlertList">

                </div>
                <form id="cadastroForm" action="#" method="post" class="container mt-1 p-4 shadow-sm rounded">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo:</label>
                        <input type="text" id="nome" name="nome" class="form-control" required placeholder="Digite seu nome completo">
                    </div>
                    <div class="mb-3">
                        <label for="sexo" class="form-label">Sexo:</label>
                        <select id="sexo" name="sexo" class="form-select" required>
                            <option selected>Selecione</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                            <option value="outro">Outro</option>
                        </select>
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
                            <label for="numero" class="form-label">Número do Apartamento:</label>
                            <input type="text" id="numero" name="numero" class="form-control" required>
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

                    <div class="d-flex justify-content-between">
                        <button type="submit" name="submit" class="btn btn-primary"><b>Cadastrar</b></button>
                        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary"><b>Cancelar</b></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<script>
    const BuscarDadosPessoas = (filter = "") => {
        $.ajax({
            type: "POST",
            url: "/Components/CRUD/ListaPessoas.php",
            data: {
                "type": "get",
                filter: filter,
            },
            success: (response) => {
                console.log("Dados obtidos:")
                console.table(response)
                if (response) {
                    MontarTabelaPessoas(response);
                }
            }
        });

    }    
    const ReiniciarDadosPessoas = () => {

    }
    const DeletarPessoa = (row) => {
        //const row = actionCaller.parentElement
        const id = row.childNodes[1].innerText;

        const decision = confirm("Tem certeza que deseja deletar a pessoa de id: " + id + "?");
        if (!decision) {
            return;
        }

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
                    row.remove();
                }
            }
        });
    }
    //
    //
    const MontarCadastrador = () => {
        // Limpa os formulários.
        let rowData = {
            "id": "",
            "nome": "",
            "sexo": "",
            "email": "",
            "telefone": "",
            "numero": "",
            "bloco": "",
            "dataNascimento": "",
        }
        Object.keys(rowData).forEach(key => {
            $("#" + key).prop("value", rowData[key])
        })

        $("#modalTitleId").text("Adicionando nova pessoa");

        $("#cadastroForm")
            .removeAttr('onsubmit')
            .submit(function(event) {
                event.preventDefault();
                const formData = $("#cadastroForm").serializeArray();
                const data = {};
                formData.forEach(item => {
                    data[item.name] = item.value;
                })

                $.ajax({
                    type: "POST",
                    url: "/Components/CRUD/ListaPessoas.php",
                    data: {
                        "type": "post",
                        "data": data
                    },
                    success: (response) => {
                        const pessoa = response[0];
                        // adiciona o novo elemento.
                        const newRow = $('<tr></tr>');

                        newRow.append(`
                            <td>${pessoa.id}</td>
                            <td>${pessoa.nome}</td>
                            <td>${pessoa.numero}</td>
                            <td>${pessoa.bloco}</td>
                            <td>${pessoa.sexo}</td>
                            <td>${pessoa.dataNascimento}</td>
                            <td>${pessoa.email}</td>
                            <td>${pessoa.telefone}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalEdicaoDados" onclick="MontarEditor(this.parentElement.parentElement)" >
                                    Editar
                                </button>
                                <button class="btn btn-danger" onclick="DeletarPessoa(this.parentElement.parentElement)">Excluir</button>
                            </td>
                        `);

                        $("#dadosTabelaPessoas").append(newRow);

                        newRow.addClass('highlight');

                        setTimeout(() => {
                            newRow.removeClass('highlight');
                        }, 2000)

                        // esconde o modal
                        $("#ModalEdicaoDados").modal("hide");

                    }
                });
            })
    }
    const MontarEditor = (row) => {
        const rowData = {
            "id": row.childNodes[1].innerText,
            "nome": row.childNodes[3].innerText,
            "numero": row.childNodes[5].innerText,
            "bloco": row.childNodes[7].innerText,
            "sexo": row.childNodes[9].innerText,
            "dataNascimento": row.childNodes[11].innerText, //new Date(new Date().getTime() - (1000 * 60 * 60 * 24 * 30 * 12 * 20)).toISOString().split('T')[0],
            "email": row.childNodes[13].innerText,
            "telefone": row.childNodes[15].innerText,


        }
        Object.keys(rowData).forEach(key => {
            $("#" + key).prop("value", rowData[key])
        })

        $("#modalTitleId").text("Editando " + rowData.nome + " | id: " + rowData.id);
        $("#cadastroForm")
            .removeAttr('onsubmit')
            .submit(function(event) {
                event.preventDefault();
                const formData = $("#cadastroForm").serializeArray();
                const data = {};
                formData.forEach(item => {
                    data[item.name] = item.value;
                })
                data["id"] = rowData.id;

                // faz o pedido para alterar o cadastro.
                $.ajax({
                    type: "POST",
                    url: "/Components/CRUD/ListaPessoas.php",
                    data: {
                        "type": "patch",
                        "data": data,
                    },
                    success: (response) => {
                        if (response) {
                            const updatedData = response[0];

                            row.childNodes[1].innerText = updatedData["id"];
                            row.childNodes[3].innerText = updatedData["nome"];
                            row.childNodes[5].innerText = updatedData["numero"];
                            row.childNodes[7].innerText = updatedData["bloco"]
                            row.childNodes[9].innerText = updatedData["sexo"];
                            row.childNodes[11].innerText = updatedData["dataNascimento"] //new Date(new Date().getTime() - (1000 * 60 * 60 * 24 * 30 * 12 * 20)).toISOString().split('T')[0],
                            row.childNodes[13].innerText = updatedData["email"];
                            row.childNodes[15].innerText = updatedData["telefone"];


                            $("#ModalEdicaoDados").modal("hide");

                            $row = $(row);

                            $row.addClass('highlight');

                            setTimeout(() => {
                                $row.removeClass('highlight');
                            }, 2000)


                        }
                    }
                });

            })
    }
    //
    //
    const MontarTabelaPessoas = (dados) => {
        $("#dadosTabelaPessoas").html("");

        dados.forEach(pessoa => {
            $("#dadosTabelaPessoas").append(`
                <tr>
                    <td>${pessoa.id}</td>
                    <td>${pessoa.nome}</td>
                    <td>${pessoa.numero}</td>
                    <td>${pessoa.bloco}</td>
                    <td>${pessoa.sexo}</td>
                    <td>${pessoa.dataNascimento}</td>
                    <td>${pessoa.email}</td>
                    <td>${pessoa.telefone}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalEdicaoDados" onclick="MontarEditor(this.parentElement.parentElement)" >
                            Editar
                        </button>
                        <button class="btn btn-danger" onclick="DeletarPessoa(this.parentElement.parentElement)">Excluir</button>
                    </td>
                </tr>
            `);
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
        $("#searchPersonForm")
        .submit(function(event) {
            // adiciona a função de busca para o formulário de busca.
            event.preventDefault();
            BuscarDadosPessoas("%"+ $("#searchPersonForm input")[0].value +"%");
        })
        


        // busca os dados de pessoas quando a página carregar.
        BuscarDadosPessoas();
    })
</script>
</body>

</html>