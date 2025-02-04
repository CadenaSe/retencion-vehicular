<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="http://localhost/proyecto-retencion-vehicular/public/css/styles.css">
    <link rel="stylesheet" href="style.css">
    
    <title>Sistema recaudación</title>
</head>
<main>
    <div class="container py-4">
        <header class="pb-3 mb-4 border-bottom">
            <div class="d-flex justify-content-start">
                <a href="http://localhost/retencion-vehicular" class="d-flex align-items-center text-body-emphasis text-decoration-none">
                    <span class="fs-5 p-2 rounded bg-body-tertiary">Retención Vehicular</span>
                </a>
            </div>
        </header>
        <img src="http://localhost\retencion-vehicular\public\assets\fondo.png" class="img-fluid" alt="...">

        <div class="my-5 text-center rounded-3">
            <h1 class="text-body-emphasis">Bienvenido/a al Sistema de Retención Vehicular</h1>
            <p class="lead">
                Este es el Sistema de Retención Vehicular en donde podrás ver toda la informacion de los clientes.
            </p>
        </div>

        <div class="container px-4 my-4" id="custom-cards">
            <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 my-2">
                <div class="col">
                    <a href="http://localhost/retencion-vehicular/admin?action=index" class="text-decoration-none">
                        <div class="card card-cover h-100 overflow-hidden bg-body-tertiary rounded-4 shadow-lg">
                            <div class="d-flex flex-column justify-content-center align-items-center h-auto p-4">
                                <i class='bx bx-shield-quarter my-2' style="font-size: 80px"></i>
                                <h4 class="">Administrador</h4>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="http://localhost/retencion-vehicular/operador?action=index" class="text-decoration-none">
                        <div class="card card-cover h-100 overflow-hidden bg-body-tertiary rounded-4 shadow-lg">
                            <div class="d-flex flex-column justify-content-center align-items-center h-100 p-4">
                                <i class='bx bx-cog my-2' style="font-size: 80px"></i>
                                <h4 class="">Operador</h4>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="http://localhost/retencion-vehicular/usuario?action=index" class="text-decoration-none">
                        <div class="card card-cover h-100 overflow-hidden bg-body-tertiary rounded-4 shadow-lg">
                            <div class="d-flex flex-column justify-content-center align-items-center h-100 p-4">
                                <i class='bx bxs-user-circle my-2' style="font-size: 80px"></i>
                                <h4 class="">Usuario</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <footer class="pt-3 mt-4 text-body-secondary border-top">
            © 2025
        </footer>
    </div>
</main>
</html>