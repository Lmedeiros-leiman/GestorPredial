<?php

use Database\CRUD;
?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
        <h4>Gerencie pessoas</h4>
        <a href="add-person.php" class="btn btn-primary">Adicionar Pessoa</a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#FormInputPessoas">
            Launch demo modal
        </button>

    </div>
    <table class="table table-bordered table-striped">
        <thead class="table-dark" id="tablePessoasHeader">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>Unidade</th>
                <th>Data Criação</th>
                <th>Data Alteração</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tablePessoasData">
            <tr>
                <td class="text-center" colspan="8">
                    <img src="./assets/loading.gif" />
                </td>
            </tr>

            
        </tbody>
    </table>
</div>

<div class="modal fade" id="FormInputPessoas" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionando pessoa.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
                <form id="formAddPessoa" onsubmit="addPerson(event)">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome*</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF*</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" required>
                    </div>
                    <div class="mb-3">
                        <label for="unidade" class="form-label">Unidade*</label>
                        <input type="text" class="form-control" id="unidade" name="unidade" required>
                    </div>
                    <div class="mb-3">
                        <label for="dataCriacao" class="form-label">Data de Nascimento </label>
                        <input type="date" class="form-control" id="dataCriacao" name="dataCriacao" required>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Adicionar</button>
                        <button type="reset" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="FormModifyPessoas" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionando pessoa.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
                <form id="formModifyPessoa" onsubmit="editPerson(event)">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome*</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF*</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" required>
                    </div>
                    <div class="mb-3">
                        <label for="unidade" class="form-label">Unidade*</label>
                        <input type="text" class="form-control" id="unidade" name="unidade" required>
                    </div>
                    <div class="mb-3">
                        <label for="dataCriacao" class="form-label">Data de Nascimento </label>
                        <input type="date" class="form-control" id="dataCriacao" name="dataCriacao" required>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Adicionar</button>
                        <button type="reset" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script defer>
    function deletePerson(id) {
        const confirmation = confirm("Tem certeza que deseja excluir esta pessoa?");
        if (confirmation) {
            $.ajax({
                url: `/api/pessoas/delete`,
                data: {
                    id: id
                },
                type: "POST",
                success: function(response) {
                    console.log(response);
                    updatePeopleTable();
                },
                error: function(error) {
                    console.error("Erro ao excluir a pessoa:", error);
                    alert("Ocorreu um erro ao excluir a pessoa: " . error);
                }
            });
        }
    }

    function editPerson(originalId, formData) {
        // change form values to fit the curr

        const confirmation = confirm("Tem certeza que deseja editar esta pessoa?");
        if (confirmation) {
            $.ajax({
                url: `/api/pessoas/modify`,
                data: {
                    id: originalId,
                    nome: formData.nome,
                    cpf: formData.cpf,
                    telefone: formData.telefone,
                    unidade: formData.unidade,
                    dataCriacao: formData.dataCriacao
                },
                type: "POST",
                success: function(response) {
                    console.log(response);
                    updatePeopleTable();
                },
                error: function(error) {
                    console.error("Erro ao editar a pessoa:", error);
                    alert("Ocorreu um erro ao editar a pessoa: " . error);
                }
            });
        }
    }

    // functions to make the form either be empty or filled with the current person data
    function prepareForm(tableRow) {
        //


        //
        let form = document.querySelector("#FormModifyPessoas");
        let inputs = form.querySelectorAll("input");
        inputs.forEach(input => {
            input.value = 123 //tableRow.querySelector(`td:nth-child(${input.id})`).innerText;


        });
    }
    
    function clearForm() {

    }



    const updatePeopleTable = () => {
        $.get("/api/pessoas", (response) => {
            let table = $("#tablePessoasData");

            if (response.length > 0) {
                table.html("");
                response.forEach(pessoa => {

                    

                    table.append(`
                            <tr>
                                <td>${pessoa.id}</td>
                                <td>${pessoa.nome}</td>
                                <td>${pessoa.cpf}</td>
                                <td>${pessoa.telefone}</td>
                                <td>${pessoa.unidade}</td>
                                <td>${pessoa.dataCriacao}</td>                                    
                                <td>${pessoa.dataAlteracao}</td>
                                <td>
                                    <button onclick="deletePerson(${pessoa.id})">Deletar</button>
                                    <button onclick='() => {}' >Edit</button>
                                </td>
                            </tr>
                            `);
                });
            } else {
                table.html("<tr> <td colspan ='8' class='text-center' > Não existem pessoas salvas. < /td> < /tr > ");
            }
        });
    }

    function addPerson(event) {
        event.preventDefault();
        let formData = new FormData(event.target);

        $.post("/api/pessoas", (response) => {
            if (response.status === 200) {
                alert("Pessoa adicionada com sucesso!");
                updatePeopleTable();
                $("#FormInputPessoas").modal("hide");
            } else {
                alert("Erro ao adicionar pessoa!");
            }
        });
    }

    
    document.addEventListener("DOMContentLoaded", () => {
        updatePeopleTable();
    });
</script>