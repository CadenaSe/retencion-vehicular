<?php
require_once __DIR__ . '/../../controllers/ModeloController.php';

$modeloController = new ModeloController();
$modelosLista = $modeloController->listar();
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
            <a href="http://localhost/retencion-vehicular/admin?action=modelosDashboard" class="nav-link active">
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
<div class="container" style="margin: 50px 50px 50px 325px">
    <h2 class="text-center">Dashboard de modelos</h2>
    <p class="my-3">Esta es la sección principal donde podrás ver la información de los modelos.</p>
    <div class="row my-2 pb-5">
        <div class="col-md-12 my-2">
            <div class="main-card mb-3 card">
                <div class="card-header fw-semibold p-3 text-center">Lista de modelos</div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Código Modelo</th>
                            <th class="text-center">Detalle</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        <?php if (empty($modelosLista)) { ?>
                            <tr>
                                <td class="text-center" colspan="7">No hay modelos</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($modelosLista as $index => $modelo) { ?>
                                <tr>
                                    <td class="text-center text-muted"><?php echo $index + 1?></td>
                                    <td class="text-center"><?php echo $modelo['codigo_modelo'] ?></td>
                                    <td class="text-center"><?php echo $modelo['detalle'] ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm btn-editar"
                                                data-codigo="<?php echo $modelo['codigo_modelo']; ?>"
                                                data-detalle="<?php echo $modelo['detalle']; ?>"
                                                data-bs-toggle="modal" data-bs-target="#editarModal">
                                            <i class='bx bxs-edit-alt' style="font-size: 20px"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar"
                                                data-codigo="<?php echo $modelo['codigo_modelo']; ?>"
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
                    <a type="button" class="btn btn-success my-2" data-bs-toggle="modal" data-bs-target="#agregarModal">Agregar modelo</a>
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
            document.getElementById("formAgregarModelo").reset();
        }
    </script>

<!-- Modal Agregar Modelo -->
<div class="modal fade" id="agregarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar Modelo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAgregarModelo" action="http://localhost/retencion-vehicular/admin?action=agregarModelo" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="codigo_modelo" class="form-label">Código Modelo</label>
                        <input minlength="6" maxlength="6" type="text" name="codigo_modelo" id="codigo_modelo" class="form-control" placeholder="Ingrese código del modelo"   required>
                    </div>
                    <div class="mb-3">
                        <label for="detalle" class="form-label">Detalle</label>
                        <input type="text" name="detalle" id="detalle" class="form-control" placeholder="Ingrese detalle" pattern="[a-z-A-Z]" required>
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

<!-- Modal Editar Modelo -->
<div class="modal fade" id="editarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Editar Modelo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarModelo" action="http://localhost/retencion-vehicular/admin?action=editarModelo" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="codigo_editar" class="form-label">Código Modelo</label>
                        <input type="text" name="codigo_modelo" id="codigo_editar" class="form-control" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="detalle_editar" class="form-label">Detalle</label>
                        <input type="text" name="detalle" id="detalle_editar" class="form-control" required>
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

<!-- Modal Eliminar Modelo -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Confirmar Eliminación</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEliminarModelo" action="http://localhost/retencion-vehicular/admin?action=eliminarModelo" method="POST">
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este modelo?</p>
                    <input type="hidden" name="codigo_modelo" id="codigo_eliminar">
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
        // Llenar modal de edición con datos del modelo
        document.querySelectorAll(".btn-editar").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("codigo_editar").value = this.getAttribute("data-codigo");
                document.getElementById("detalle_editar").value = this.getAttribute("data-detalle");
            });
        });

        // Llenar modal de eliminación con el código del modelo
        document.querySelectorAll(".btn-eliminar").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("codigo_eliminar").value = this.getAttribute("data-codigo");
            });
        });
    });
</script>

</html>
