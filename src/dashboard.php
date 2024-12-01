<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor predial</title>
    <?php require_once "./Components/libs.php" ?>
</head>
<body>
<nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand" href="#">Gestor Predial</a>

            <!-- Toggler for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">Inicio</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php require_once "./Components/CRUD/ListaPessoas.php" ?>
</body>
</html>