<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ./login.php");
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor predial - Dashboard</title>
    <?php require_once "./Components/libs.php" ?>
</head>

<body>
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand" href="./">Gestor Predial</a>

            <!-- Toggler for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="userDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img
                                src="https://via.placeholder.com/30"
                                alt="User Avatar"
                                class="rounded-circle me-2"
                                style="width: 30px; height: 30px;">
                            Usuário
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a id="logout" class="dropdown-item" onclick="">Deslogar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <ul id="tabWindows" class=" hidden ">

    </ul>

    <?php require_once "./Components/CRUD/ListaPessoas.php" ?>

</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $("#logout")
        .click(function(event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "/login.php",
                data: { "action" : "logout" },
                success: function(response) {
                    window.location.href = "/";
                }
            })
        });


    });
</script>


</html>