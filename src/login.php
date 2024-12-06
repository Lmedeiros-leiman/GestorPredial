<?php
if (!empty($_POST) and isset($_POST["action"])) {
    header('Content-Type: application/json; charset=utf-8'); // o  browser enteenderá que estamos enviando um JSON.
    require_once "./Components/Scripts/Database.php"; // chama o banco de dados.
    session_start();
    //
    // as páginas PHP possuem 2 modos: POST e GET
    // o navegador por padrão envia os dados via GET (o html abaixo destas linhas de código.)
    // porem formulários podem acessar as ações de cada página, neste caso: logar e deslogar.
    //
    switch ($_POST["action"]) {
        case "login":
            // separamos os dados do formulário em um array.
            $formData = [
                "nome" => $_POST["nome"],
                "senha" => $_POST["senha"]
            ];
            $data = Database::query("SELECT * FROM administrador WHERE (nome=? AND senha=?)", $formData);
            // inicializa com um valor padrão de erro.
            $result = [
                "status" => "danger",
                "message" => "Usuário ou senha inválidos."
            ];

            if (count($data) > 0) {
                // caso tenhamos encontrado uma conta válida no banco de dados, armazenamos seu ID na sessão e indicamos sucesso ao usuário.
                $_SESSION["user"] = $data[0]["id"];

                $result = [
                    "status" => "success",
                    "message" => "Login efetuado com sucesso",
                    "redirect" => "./dashboard.php"
                ];
            }
            echo json_encode($result); // entrega o objeto $result para o frontend análisar.
            break;
        case "logout":
            unset($_SESSION["user"]);
            session_destroy();
            echo json_encode(["status" => "sucess"]);
            break;
        default:
            break;
    }
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor predial - Login</title>

    <?php require_once "./Components/libs.php" ?>
</head>

<body class="bg-light p-2">
    <nav>
        <a class="navbar-brand" href="./index.php">
            <h1>
                Gestor Predial
            </h1>
        </a>
    </nav>

    <div class="container d-flex flex-column gap-2 justify-content-center align-items-center mt-5 ">
        <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
            <h2 class="text-center mb-4">Login</h2>
            <form id="loginForm" method="post">
                <!-- Usuário -->
                <div class="mb-3">
                    <label for="user" class="form-label">Usuário:</label>
                    <input
                        type="text"
                        id="usuario"
                        name="usuario"
                        class="form-control"
                        placeholder="Digite seu Usuário"
                        required>
                </div>
                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Senha:</label>
                    <input
                        type="password"
                        id="senha"
                        name="password"
                        class="form-control"
                        placeholder="Digite sua senha"
                        required>
                </div>
                <!-- Submit Button -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        Entrar
                    </button>

                </div>
            </form>
        </div>
        <div id="alert" class="alert d-none mt-3" role="alert">
            Esperando retorno do formulário.
        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $("#loginForm")
            .removeAttr('submit')
            .submit(function(event) {
                event.preventDefault();

                var formData = $(this).serializeArray();

                $.ajax({
                    type: "POST",
                    url: "/login.php",
                    data: {
                        "nome": formData[0].value,
                        "senha": formData[1].value,
                        "action": "login",
                    },
                    success: function(response) {
                        console.log(response)
                        $("#alert").addClass("alert-" + response.status)
                            .text(response.message)
                            .removeClass("d-none");

                        if (response.status == "success") {
                            window.location.href = response.redirect;
                        }
                    }
                })
            })
    });
</script>

</html>