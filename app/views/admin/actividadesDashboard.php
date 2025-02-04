<?php
require_once __DIR__ . '/../../controllers/ActividadController.php';

$actividadController = new ActividadController();
$actividadesLista = $actividadController->listar();
?>

<!doctype html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="http://localhost/retencion-vehicular/public/css/styles.css">
    <title>Gestión de Actividades</title>
</head>
<body class="d-flex">

<!-- Sidebar -->
<div class="d-flex flex-column border-end border-3 flex-shrink-0 bg-body-tertiary p-3 sticky" style="width: 280px; height: 100vh; position: fixed; z-index: 100">
    <a href="http://localhost/retencion-vehicular/admin?action=propietariosDashboard" class="bg-body rounded p-3 d-flex align-items-center mb-4 link-body-emphasis text-decoration-none">
        <i class='bx bxs-car me-3' style="font-size: 40px"></i>
        <span class="fs-5 fw-bold text-align-center">Retención vehicular</span>
    </a>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/admin?action=propietariosDashboard" class="nav-link link-body-emphasis">
                Propietarios
            </a>
        </li>
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/admin?action=patiosDashboard" class="nav-link link-body-emphasis">
                Patios
            </a>
        </li>
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/admin?action=infraccionesDashboard" class="nav-link link-body-emphasis">
                Infracciones
            </a>
        </li>
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/admin?action=modelosDashboard" class="nav-link link-body-emphasis">
                Modelos
            </a>
        </li>
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/admin?action=marcasDashboard" class="nav-link link-body-emphasis">
                Marcas
            </a>
        </li>
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/admin?action=vehiculosDashboard" class="nav-link link-body-emphasis">
                Vehículos
            </a>
        </li>
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/admin?action=registrosDashboard" class="nav-link link-body-emphasis">
                Registros
            </a>
        </li>
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/admin?action=responsablesDashboard" class="nav-link link-body-emphasis">
                Responsables
            </a>
        </li>
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/admin?action=actividadesDashboard" class="nav-link active">
                Actividades
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class='bx bx-shield-quarter my-1' style="font-size: 32px"></i>
            <strong>Administrador</strong>
        </a>
        <ul class="dropdown-menu text-small shadow">
            <li><a class="dropdown-item" href="http://localhost/retencion-vehicular/admin?action=logout">Salir</a></li>
        </ul>
    </div>
</div>

<!-- Contenido Principal -->
<div class="container" style="margin: 50px 50px 50px 325px">
    <h2 class="text-center">Dashboard de Actividades</h2>
    <p class="my-3">Administra las actividades registradas en el sistema.</p>

    <div class="row my-2 pb-5">
        <div class="col-md-12 my-2">
            <div class="main-card mb-3 card">
                <div class="card-header fw-semibold p-3 text-center">Lista de Actividades</div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">Código</th>
                            <th class="text-center">Detalle</th>
                            <th class="text-center">Valor</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        <?php if (empty($actividadesLista)) { ?>
                            <tr>
                                <td class="text-center" colspan="4">No hay actividades registradas</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($actividadesLista as $index => $actividad) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $actividad['id_actividad']; ?></td>
                                    <td class="text-center"><?php echo $actividad['detalle']; ?></td>
                                    <td class="text-center"><?php echo $actividad['valor']; ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm btn-editar"
                                                data-codigo="<?php echo $actividad['id_actividad']; ?>"
                                                data-detalle="<?php echo $actividad['detalle']; ?>"
                                                data-valor="<?php echo $actividad['valor']; ?>"
                                                data-bs-toggle="modal" data-bs-target="#editarModal">
                                            <i class='bx bxs-edit-alt' style="font-size: 20px"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar"
                                                data-codigo="<?php echo $actividad['id_actividad']; ?>"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class='bx bxs-trash-alt' style="font-size: 20px"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-block text-center card-footer">
                    <button class="btn btn-success my-2" data-bs-toggle="modal" data-bs-target="#agregarModal">Agregar Actividad</button>
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

<!-- Modal Agregar Actividad -->
<div class="modal fade" id="agregarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar Actividad</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAgregarActividad" action="http://localhost/retencion-vehicular/admin?action=agregarActividad" method="POST">
                <div class="modal-body">
                    <!-- Detalle -->
                    <div class="mb-3">
                        <label for="detalle" class="form-label">Detalle</label>
                        <input type="text" name="detalle" id="detalle" class="form-control" required>
                    </div>
                    <!-- Valor -->
                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor ($)</label>
                        <input type="number" step="0.01" name="valor" id="valor" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Actividad -->
<div class="modal fade" id="editarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Editar Actividad</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarActividad" action="http://localhost/retencion-vehicular/admin?action=editarActividad" method="POST">
                <div class="modal-body">
                    <!-- Código -->
                    <div class="mb-3">
                        <label for="codigo_editar" class="form-label">Código</label>
                        <input type="text" name="id_actividad" id="codigo_editar" class="form-control" required readonly>
                    </div>
                    <!-- Detalle -->
                    <div class="mb-3">
                        <label for="detalle_editar" class="form-label">Detalle</label>
                        <input type="text" name="detalle" id="detalle_editar" class="form-control" required>
                    </div>
                    <!-- Valor -->
                    <div class="mb-3">
                        <label for="valor_editar" class="form-label">Valor ($)</label>
                        <input type="number" step="0.01" name="valor" id="valor_editar" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar Actividad -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Confirmar Eliminación</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEliminarActividad" action="http://localhost/retencion-vehicular/admin?action=eliminarActividad" method="POST">
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar esta actividad?</p>
                    <input type="hidden" name="id_actividad" id="codigo_eliminar">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Pasar datos al modal de edición
        document.querySelectorAll(".btn-editar").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("codigo_editar").value = this.getAttribute("data-codigo");
                document.getElementById("detalle_editar").value = this.getAttribute("data-detalle");
                document.getElementById("valor_editar").value = this.getAttribute("data-valor"); // Nuevo campo valor
            });
        });

        // Pasar datos al modal de eliminación
        document.querySelectorAll(".btn-eliminar").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("codigo_eliminar").value = this.getAttribute("data-codigo");
            });
        });
    });
</script>
</html>
