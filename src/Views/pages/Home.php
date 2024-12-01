<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor Predial</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</head>

<body class="container-fluid">
    <?php require VIEW_DIR ."/components/HomeNavbar.php" ?>
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