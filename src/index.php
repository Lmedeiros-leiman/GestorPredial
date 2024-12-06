<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor predial</title>

    <?php include_once "./Components/libs.php" ?>
</head>

<body class="container-fluid">
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
                    <a href="./dashboard.php" class="btn btn-primary btn-lg mt-3">Vire um morador!</a>
                </div>
                <!-- Image Section -->
                <div class="col-md-6 text-center">
                    <img src="/assets/outside.jpg"
                        class="img-fluid rounded shadow"
                        alt="foto de fora apartamento" />
                </div>
            </div>
        </div>

        <div class="container mt-5">
    <h2 class="mb-4">Avisos e Notícias</h2>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <!-- Post 1 -->
        <div class="col">
            <div class="card h-100">
                <img src="./assets/estragos.webp" height="240" class="card-img-top" alt="Post 1 Image">
                <div class="card-body">
                    <h5 class="card-title">Reformas no pátio</h5>
                    <p class="card-text">O temporal desta semana arruinou o pátio. conversando a equipe de manutenção teremos algumas demora.</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Publicado em 04/12/2024</small>
                </div>
            </div>
        </div>

        <!-- Post 2 -->
        <div class="col">
            <div class="card h-100">
                <img src="./assets/imagem2025.jpg" height="240" class="card-img-top" alt="Post 2 Image">
                <div class="card-body">
                    <h5 class="card-title">Evento: Futebol no ginásio</h5>
                    <p class="card-text">Teremos um evento dia 15 para festejar-mos o final de ano como comunidade. Confira os detalhes.</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Publicado em 03/12/2024</small>
                </div>
            </div>
        </div>

        <!-- Post 3 -->
        <div class="col">
            <div class="card h-100">
                <img src="./assets/financeiro.jpg" height="240" class="card-img-top" alt="Post 3 Image">
                <div class="card-body">
                    <h5 class="card-title">Planos futuros</h5>
                    <p class="card-text">Confira nossos planos futuros e objetivos junto a comunidade.</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Publicado em 02/12/2024</small>
                </div>
            </div>
        </div>
    </div>
</div>

    </section>

    <section>

    </section>

</body>

</html>