<?php
require_once __DIR__ . '/../../controllers/ResponsableController.php';

$responsableController = new ResponsableController();
$responsablesLista = $responsableController->listar();
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
    <title>Gestión de Responsables</title>
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
            <a href="http://localhost/retencion-vehicular/admin?action=responsablesDashboard" class="nav-link active">
                Responsables
            </a>
        </li>
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/admin?action=actividadesDashboard" class="nav-link link-body-emphasis">
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
    <h2 class="text-center">Dashboard de Responsables</h2>
    <p class="my-3">Administra los responsables registrados en el sistema.</p>

    <div class="row my-2 pb-5">
        <div class="col-md-12 my-2">
            <div class="main-card mb-3 card">
                <div class="card-header fw-semibold p-3 text-center">Lista de Responsables</div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Cédula</th>
                            <th class="text-center">Nombres</th>
                            <th class="text-center">Apellidos</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        <?php if (empty($responsablesLista)) { ?>
                            <tr>
                                <td class="text-center" colspan="6">No hay responsables registrados</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($responsablesLista as $index => $responsable) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $index + 1 ?></td>
                                    <td class="text-center"><?php echo $responsable['cedula_responsable']; ?></td>
                                    <td class="text-center"><?php echo $responsable['nombres_responsable']; ?></td>
                                    <td class="text-center"><?php echo $responsable['apellidos_responsable']; ?></td>
                                    <td class="text-center"><?php echo $responsable['email_responsable']; ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm btn-editar"
                                                data-cedula="<?php echo $responsable['cedula_responsable']; ?>"
                                                data-nombres="<?php echo $responsable['nombres_responsable']; ?>"
                                                data-apellidos="<?php echo $responsable['apellidos_responsable']; ?>"
                                                data-email="<?php echo $responsable['email_responsable']; ?>"
                                                data-bs-toggle="modal" data-bs-target="#editarModal">
                                            <i class='bx bxs-edit-alt' style="font-size: 20px"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar"
                                                data-cedula="<?php echo $responsable['cedula_responsable']; ?>"
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
                    <button class="btn btn-success my-2" data-bs-toggle="modal" data-bs-target="#agregarModal">Agregar Responsable</button>
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

<script>
        function limpiarCampos() {
            document.getElementById("formAgregarResponsable").reset();
        }
    </script>

<!-- Modal Agregar Responsable -->
<div class="modal fade" id="agregarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar Responsable</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAgregarResponsable" action="http://localhost/retencion-vehicular/admin?action=agregarResponsable" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cedula_responsable" class="form-label">Cédula</label>
                        <input minlength="10" maxlength="10" type="text" name="cedula_responsable" id="cedula_responsable" class="form-control" placeholder="Ingrese N° de cédula" pattern="[0-9]+" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombres_responsable" class="form-label">Nombres</label>
                        <input type="text" name="nombres_responsable" id="nombres_responsable" class="form-control" 
                         pattern="[a-z-A-Z]" placeholder="Ingrese nombres" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos_responsable" class="form-label">Apellidos</label>
                        <input type="text" name="apellidos_responsable" id="apellidos_responsable" class="form-control" 
                         pattern="[a-z-A-Z]" placeholder="Ingrese apellidos" required>
                    </div>
                    <div class="mb-3">
                        <label for="email_responsable" class="form-label">Email</label>
                        <input type="email" name="email_responsable" id="email_responsable" class="form-control" placeholder="Ingrese email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="limpiarCampos()" class="btn btn-success my-2">Limpiar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Responsable -->
<div class="modal fade" id="editarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Editar Responsable</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarResponsable" action="http://localhost/retencion-vehicular/admin?action=editarResponsable" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cedula_responsable_editar" class="form-label">Cédula</label>
                        <input type="text" name="cedula_responsable" id="cedula_responsable_editar" class="form-control" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nombres_responsable_editar" class="form-label">Nombres</label>
                        <input type="text" name="nombres_responsable" id="nombres_responsable_editar" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos_responsable_editar" class="form-label">Apellidos</label>
                        <input type="text" name="apellidos_responsable" id="apellidos_responsable_editar" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email_responsable_editar" class="form-label">Email</label>
                        <input type="email" name="email_responsable" id="email_responsable_editar" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar Responsable -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Confirmar Eliminación</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEliminarResponsable" action="http://localhost/retencion-vehicular/admin?action=eliminarResponsable" method="POST">
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar a este responsable?</p>
                    <input type="hidden" name="cedula_responsable" id="cedula_responsable_eliminar">
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
        // Editar Responsable
        document.querySelectorAll(".btn-editar").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("cedula_responsable_editar").value = this.getAttribute("data-cedula");
                document.getElementById("nombres_responsable_editar").value = this.getAttribute("data-nombres");
                document.getElementById("apellidos_responsable_editar").value = this.getAttribute("data-apellidos");
                document.getElementById("email_responsable_editar").value = this.getAttribute("data-email");
            });
        });

        // Eliminar Responsable
        document.querySelectorAll(".btn-eliminar").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("cedula_responsable_eliminar").value = this.getAttribute("data-cedula");
            });
        });
    });
</script>
</html>
