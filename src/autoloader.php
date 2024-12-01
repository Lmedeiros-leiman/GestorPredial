<?php


define("ROOT_DIR",__DIR__);


// função de autoloader
spl_autoload_register(function ($class) {
    str_replace("\\","/",$class);
    $filePath = ROOT_DIR . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . ".php";


    require_once $filePath;
});


// função de erro automatico.

set_exception_handler(function (Throwable $ex) {
    echo '<!DOCTYPE html>
    <html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <div class="container mt-5">
            <div class="alert alert-danger shadow-sm">
                <h4 class="alert-heading">
                    <i class="bi bi-exclamation-triangle-fill"></i> 
                    Erro encontrado.
                </h4>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Mensagem:</strong> ' . htmlspecialchars($ex->getMessage()) . '</p>
                        <p><strong>Arquivo:</strong> ' . htmlspecialchars($ex->getFile()) . '</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Line:</strong> ' . $ex->getLine() . '</p>
                        <p><strong>Code:</strong> ' . $ex->getCode() . '</p>
                    </div>
                </div>
                <hr>
                <div class="bg-light p-3 rounded ">
                    <textarea class="w-100" rows="8">
                        '. $ex->getTraceAsString() .'
                    </textarea>
                </div>
                <div class="bg-light p-3 rounded">
                    <p class="mb-1"><strong>Stack Trace:</strong></p>

                    <pre class="mb-0"><code>' . htmlspecialchars(print_r($ex->getTrace(), true)) . '</code></pre>
                </div>
            </div>
        </div>
    </body>
    </html>';
});
