<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php include_once "./Components/libs.php" ?>
</head>

<body class="container-fluid">
    <<nav class="navbar navbar-expand-lg ">
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
                        <a class="nav-link" href="/dashboard.php">Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
        </nav>
        <section class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Text Section -->
                    <div class="col-md-6">
                        <h1 class="display-4 fw-bold">Precisando de um espaço?</h1>
                        <p class="lead text-muted">
                            Conheça a melhor seleção de apartamentos da sua área! espaços volumosos e preços baixos.
                        </p>
                        <a href="/register/" class="btn btn-primary btn-lg mt-3">Vire um morador!</a>
                    </div>
                    <!-- Image Section -->
                    <div class="col-md-6 text-center">
                        <img src="/assets/outside.jpg"
                            class="img-fluid rounded shadow"
                            alt="foto de fora apartamento" />
                    </div>
                </div>
            </div>
        </section>


</body>

</html>