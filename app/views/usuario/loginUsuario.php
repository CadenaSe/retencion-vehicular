<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
<body background="http://localhost\retencion-vehicular\public\assets\back.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="http://localhost/retencion-vehicular/public/css/styles.css">

    <div class="bg-body p-5 rounded-5">
        
    <title>Sistema retención</title>
</head>
<body class="d-flex align-items-center justify-content-center bg-body-tertiary">
<main class="form-signin w-100">
    <form action="http://localhost/retencion-vehicular/usuario?action=login" method="POST">
        <div class="d-flex flex-row align-items-center justify-content-between">
            <h1 class="h3 mb-3 fw-normal">Ingresar como Usuario</h1>
            <i class='bx bxs-user-circle my-2' style="font-size: 50px"></i>
        </div>
        <div class="form-floating my-2">
            <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cedula">
            <label for="cedula">Cédula</label>
        </div>
        <div class="form-floating my-2">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            <label for="password">Contraseña</label>
        </div>
        <?php if (!empty($mensajeError)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $mensajeError; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <button class="btn btn-primary w-100 py-2 my-2" type="submit">Ingresar</button>
        <a class="btn btn-secondary w-100 py-2 my-2" type="button" href="http://localhost/retencion-vehicular/">Volver al inicio</a>
        <p class="mt-5 mb-3 text-body-secondary">©2025</p>
    </form>
</main>
</body>