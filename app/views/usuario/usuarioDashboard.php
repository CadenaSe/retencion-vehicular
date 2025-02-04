<?php
require_once __DIR__ . '/../../controllers/VehiculoController.php';
require_once __DIR__ . '/../../controllers/RegistroController.php';
$vehiculoController = new VehiculoController();
$registroController = new RegistroController();

function verificarSesion()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) {
        // Redirigir al login si no está autenticado
        header('Location: usuario?action=loginUsuario');
        exit;
    }

    // Retornar los datos de sesión
    return [
        'usuario' => $_SESSION['usuario'],
        'rol' => $_SESSION['rol']
    ];
}

$sesionUsuario = verificarSesion();
$vehiculosRetenidos = $vehiculoController->listarVehiculosRetenidos($_SESSION['usuario']);
$listaFormasPago = $registroController->listarOpcionesPagos();
?>

<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="http://localhost/retencion-vehicular/public/css/styles.css">
    <title>Sistema retención</title>
</head>
<body class="d-flex">
<div class="d-flex flex-column border-end border-3 flex-shrink-0 bg-body-tertiary p-3 sticky" style="width: 280px; height: 100vh; position: fixed; z-index: 100">
    <a href="http://localhost/retencion-vehicular/usuario?action=usuarioDashboard" class="bg-body rounded p-3 d-flex align-items-center mb-4 link-body-emphasis text-decoration-none">
        <i class='bx bxs-car me-3' style="font-size: 40px"></i>
        <span class="fs-5 fw-bold text-align-center">Retención vehicular</span>
    </a>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/usuario?action=usuarioDashboard" class="nav-link active">
                Inicio
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class='bx bxs-user-circle my-2' style="font-size: 32px"></i>
            <strong>Usuario: <?php echo htmlspecialchars($sesionUsuario['usuario'])?></strong>
        </a>
        <ul class="dropdown-menu text-small shadow">
            <li><a class="dropdown-item" href="http://localhost/retencion-vehicular/usuario?action=logout">Salir</a></li>
        </ul>
    </div>
</div>
<div class="container" style="margin: 50px 50px 50px 325px">
    <p class="my-3 fw-light">Sesión con el usuario: <?php echo htmlspecialchars($sesionUsuario['usuario'])?></p>
    <h2 class="text-center">Inicio</h2>
    <p class="my-3">Esta es la sección principal donde podrás ver la información de tus vehículos.</p>
    <div class="row my-2 pb-5">
        <div class="col-md-12 my-2">
            <div class="main-card mb-3 card">
                <div class="card-header fw-semibold p-3 text-center">Lista de tus vehiculos registrados</div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Placa</th>
                            <th class="text-center">Año</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Marca</th>
                            <th class="text-center">Modelo</th>
                            <th class="text-center">Patio</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        <?php if (empty($vehiculosRetenidos)) { ?>
                            <tr>
                                <td class="text-center" colspan="8">No tienes vehículos registrados</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($vehiculosRetenidos as $index => $vehiculo) { ?>
                                <tr>
                                    <td class="text-center text-muted"><?php echo $index + 1?></td>
                                    <td class="text-center"><?php echo $vehiculo['placa'] ?></td>
                                    <td class="text-center"><?php echo $vehiculo['anio'] ?></td>
                                    <td class="text-center">
                                        <?php
                                        if ($vehiculo['estado_vehiculo'] === 'Liberado') { ?>
                                            <span class="badge bg-success">Liberado</span>
                                        <?php } elseif ($vehiculo['estado_vehiculo'] === 'Retenido') { ?>
                                            <span class="badge bg-warning text-dark">Retenido</span>
                                        <?php } elseif ($vehiculo['estado_vehiculo'] === 'Chatarización') { ?>
                                            <span class="badge bg-danger">Chatarización</span>
                                        <?php } else { ?>
                                            <span class="badge bg-secondary">Desconocido</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center"><?php echo $vehiculo['marca'] ?></td>
                                    <td class="text-center"><?php echo $vehiculo['modelo'] ?></td>
                                    <td class="text-center"><?php echo $vehiculo['patio'] ?></td>
                                    <td class="text-center">
                                        <?php if ($vehiculo['estado_vehiculo'] === 'Retenido') { ?>
                                            <button type="button" class="btn btn-primary btn-sm my-1 mx-1 btn-editar"
                                                    data-bs-toggle="modal" data-bs-target="#pagoModal"
                                                    data-placa="<?php echo $vehiculo['placa']; ?>"
                                                    data-infraccion="<?php echo $vehiculo['infraccion']; ?>"
                                                    data-cedula-propietario="<?php echo $vehiculo['cedula_propietario']; ?>"
                                                    data-fecha="<?php echo $vehiculo['fecha_retener_hasta']; ?>"
                                                    data-total="<?php echo $vehiculo['total']; ?>"
                                                    data-codigo-registro="<?php echo $vehiculo['codigo_registro']; ?>"
                                            >
                                                <i class='bx bx-money-withdraw' style="font-size: 20px"></i>
                                            </button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Mensaje de error -->
            <?php if (!empty($mensajeError)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $mensajeError; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Mensaje de éxito -->
            <?php if (!empty($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_GET['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="pagoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Realizar Pago</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formPago" action="http://localhost/retencion-vehicular/usuario?action=realizarPago" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="placa" id="placa_pago">
                    <input type="hidden" name="cedula_propietario" id="cedula_propietario_pago">
                    <input type="hidden" name="codigo_registro" id="codigo_registro">

                    <div class="mb-3">
                        <label for="infraccion_pago" class="form-label">Infracción:</label>
                        <input type="text" id="infraccion_pago" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_pago" class="form-label">Pagar hasta:</label>
                        <input type="text" id="fecha_pago" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="total_pago" class="form-label">Total a Pagar:</label>
                        <input type="text" id="total_pago" class="form-control fw-bold text-success" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="forma_pago" class="form-label">Forma de Pago:</label>
                        <select name="id_forma_pago" id="forma_pago" class="form-select" required>
                            <option value="">Seleccione una forma de pago</option>
                            <?php foreach ($listaFormasPago as $formaPago): ?>
                                <option value="<?php echo $formaPago['id_forma_pago']; ?>">
                                    <?php echo $formaPago['detalle']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Pagar</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".btn-editar").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("placa_pago").value = this.getAttribute("data-placa");
                document.getElementById("codigo_registro").value = this.getAttribute("data-codigo-registro");
                document.getElementById("cedula_propietario_pago").value = this.getAttribute("data-cedula-propietario");
                document.getElementById("infraccion_pago").value = this.getAttribute("data-infraccion");
                document.getElementById("fecha_pago").value = this.getAttribute("data-fecha");
                document.getElementById("total_pago").value = "$" + parseFloat(this.getAttribute("data-total")).toFixed(2);
            });
        });
    });
</script>
</html>
