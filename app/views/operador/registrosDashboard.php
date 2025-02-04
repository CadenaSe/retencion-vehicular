<?php
require_once __DIR__ . '/../../controllers/VehiculoController.php';
require_once __DIR__ . '/../../controllers/ResponsableController.php';
require_once __DIR__ . '/../../controllers/ActividadController.php';
require_once __DIR__ . '/../../controllers/RegistroController.php';

$vehiculoController = new VehiculoController();
$responsableController = new ResponsableController();
$actividadController = new ActividadController();
$registroController = new RegistroController();

$listaResponsables = $responsableController->listar();
$listaVehiculos = $vehiculoController->listar();
$listaActividades = $actividadController->listar();
$listaRegistros = $registroController->listarRegistros();
$opcionesPago = $registroController->listarOpcionesPagos();
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
    <a href="http://localhost/retencion-vehicular/operador?action=propietariosDashboard" class="bg-body rounded p-3 d-flex align-items-center mb-4 link-body-emphasis text-decoration-none">
        <i class='bx bxs-car me-3' style="font-size: 40px"></i>
        <span class="fs-5 fw-bold text-align-center">Retención vehicular</span>
    </a>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/operador?action=propietariosDashboard" class="nav-link link-body-emphasis">
                Propietarios
            </a>
        </li>
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/operador?action=vehiculosDashboard" class="nav-link link-body-emphasis">
                Vehículos
            </a>
        </li>
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/operador?action=registrosDashboard" class="nav-link active">
                Registros
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class='bx bx-cog my-2' style="font-size: 32px"></i>
            <strong>Operador</strong>
        </a>
        <ul class="dropdown-menu text-small shadow">
            <li><a class="dropdown-item" href="http://localhost/retencion-vehicular/operador?action=logout">Salir</a></li>
        </ul>
    </div>
</div>
<div class="container" style="margin: 50px 50px 50px 325px">
    <h2 class="text-center">Dashboard de Registros</h2>
    <p class="my-3">Esta es la sección principal donde podrás ver la información de los registros.</p>
    <div class="row my-2 pb-5">
        <div class="col-md-12 my-2">
            <div class="main-card mb-3 card">
                <div class="card-header fw-semibold p-3 text-center">Lista de registros</div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Placa</th>
                            <th class="text-center">Responsable</th>
                            <th class="text-center">Fecha Registro</th>
                            <th class="text-center">Retención Hasta</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Forma de Pago</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        <?php if (empty($listaRegistros)) { ?>
                            <tr>
                                <td class="text-center" colspan="9">No hay registros</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($listaRegistros as $index => $registro) { ?>
                                <tr>
                                    <td class="text-center text-muted"><?php echo $index + 1; ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($registro['placa_vehiculo']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($registro['responsable']); ?></td>
                                    <td class="text-center"><?php echo date("d/m/Y H:i", strtotime($registro['fecha'])); ?></td>
                                    <td class="text-center"><?php echo date("d/m/Y", strtotime($registro['fecha_retener_hasta'])); ?></td>
                                    <td class="text-center">
                                        <?php if ($registro['estado'] === 'pagado') { ?>
                                            <span class="badge bg-success">Pagado</span>
                                        <?php } else { ?>
                                            <span class="badge bg-warning text-dark">Pendiente</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center"><?php echo $registro['forma_pago'] ? htmlspecialchars($registro['forma_pago']) : 'N/A'; ?></td>
                                    <td class="text-center">$<?php echo number_format($registro['total'], 2); ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm btn-editar"
                                                data-codigo="<?php echo $registro['codigo_registro']; ?>"
                                                data-placa="<?php echo $registro['placa_vehiculo']; ?>"
                                                data-responsable="<?php echo $registro['cedula_responsable']; ?>"
                                                data-estado="<?php echo $registro['estado']; ?>"
                                                data-retener="<?php echo $registro['fecha_retener_hasta']; ?>"
                                                data-forma-pago='<?php echo $registro['id_forma_pago']; ?>'
                                                data-actividades="<?php echo $registro['actividades']; ?>"
                                                data-bs-toggle="modal" data-bs-target="#editaModal"
                                        >
                                            <i class='bx bxs-edit-alt' style="font-size: 20px"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar"
                                                data-codigo="<?php echo htmlspecialchars($registro['codigo_registro']); ?>"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        >
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
                    <a type="button" class="btn btn-success my-2" data-bs-toggle="modal" data-bs-target="#agregarModal">Agregar registro</a>
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

<div class="modal fade" id="agregarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar registro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAgregarRegistro" action="http://localhost/retencion-vehicular/operador?action=agregarRegistro" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="placa" class="form-label">Vehículo ingresado:</label>
                        <select name="placa" id="placa" class="form-select" required>
                            <option value="">Seleccione una placa</option>
                            <?php foreach ($listaVehiculos as $vehiculo): ?>
                                <option value="<?php echo $vehiculo['placa']; ?>">
                                    <?php echo $vehiculo['placa']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="responsable" class="form-label">Responsable de actividades:</label>
                        <select name="responsable" id="responsable" class="form-select" required>
                            <option value="">Seleccione un responsable</option>
                            <?php foreach ($listaResponsables as $responsable): ?>
                                <option value="<?php echo $responsable['cedula_responsable']; ?>">
                                    <?php echo $responsable['nombres_responsable'] . ' ' . $responsable['apellidos_responsable']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Detalle de actividades a realizar:</label>
                        <div class="border rounded p-2">
                            <?php foreach ($listaActividades as $actividad): ?>
                                <div class="form-check">
                                    <input class="form-check-input actividad-checkbox" type="checkbox"
                                           name="actividades[]" value="<?php echo $actividad['id_actividad']; ?>"
                                           id="actividad_<?php echo $actividad['id_actividad']; ?>">
                                    <label class="form-check-label" for="actividad_<?php echo $actividad['id_actividad']; ?>">
                                        <?php echo $actividad['detalle']; ?> - $<?php echo number_format($actividad['valor'], 2); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="retener_hasta" class="form-label fw-semibold">Retener hasta:</label>
                        <input type="date" class="form-control" id="retener_hasta" name="retener_hasta" required>
                    </div>

                    <div class="mb-3">
                        <label for="estado_pago" class="form-label fw-semibold">Estado de pago:</label>
                        <select name="estado_pago" id="estado_pago" class="form-select">
                            <option value="">Seleccione una opción</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="pagado">Pagado</option>
                            
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_forma_pago" class="form-label fw-semibold">Forma de Pago (Opcional):</label>
                        <select name="id_forma_pago" id="id_forma_pago" class="form-select">
                            <option value="">Seleccione una forma de pago</option>
                            <?php foreach ($opcionesPago as $pago): ?>
                                <option value="<?php echo $pago['id_forma_pago']; ?>">
                                    <?php echo $pago['detalle']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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

<div class="modal fade" id="editaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Registro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarRegistro" action="http://localhost/retencion-vehicular/operador?action=editarRegistro" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="codigo_registro" id="codigo_editar">

                    <div class="mb-3">
                        <label for="placa_editar" class="form-label">Vehículo ingresado:</label>
                        <select name="placa" id="placa_editar" class="form-select">
                            <option value="">Seleccione una placa</option>
                            <?php foreach ($listaVehiculos as $vehiculo): ?>
                                <option value="<?php echo $vehiculo['placa']; ?>">
                                    <?php echo $vehiculo['placa']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="responsable_editar" class="form-label">Responsable de actividades:</label>
                        <select name="responsable" id="responsable_editar" class="form-select">
                            <option value="">Seleccione un responsable</option>
                            <?php foreach ($listaResponsables as $responsable): ?>
                                <option value="<?php echo $responsable['cedula_responsable']; ?>">
                                    <?php echo $responsable['nombres_responsable'] . ' ' . $responsable['apellidos_responsable']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Detalle de actividades a realizar:</label>
                        <div class="border rounded p-2">
                            <?php foreach ($listaActividades as $actividad): ?>
                                <div class="form-check">
                                    <input class="form-check-input actividad-checkbox" type="checkbox" name="actividades[]"
                                           value="<?php echo $actividad['id_actividad']; ?>" id="actividad_<?php echo $actividad['id_actividad']; ?>">
                                    <label class="form-check-label" for="actividad_<?php echo $actividad['id_actividad']; ?>">
                                        <?php echo $actividad['detalle']; ?> - $<?php echo number_format($actividad['valor'], 2); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="retener_hasta_editar" class="form-label fw-semibold">Retener hasta:</label>
                        <input type="date" class="form-control" id="retener_hasta_editar" name="retener_hasta" required>
                    </div>

                    <div class="mb-3">
                        <label for="estado_pago_editar" class="form-label fw-semibold">Estado de pago:</label>
                        <select name="estado_pago" id="estado_pago_editar" class="form-select">
                            <option value="pendiente">Pendiente</option>
                            <option value="pagado">Pagado</option>
                            
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_forma_pago_editar" class="form-label fw-semibold">Forma de pago:</label>
                        <select name="id_forma_pago" id="id_forma_pago_editar" class="form-select">
                            <option value="">Seleccione una forma de pago</option>
                            <?php foreach ($opcionesPago as $pago): ?>
                                <option value="<?php echo $pago['id_forma_pago']; ?>">
                                    <?php echo $pago['detalle']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Confirmar Eliminación</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEliminarRegistro" action="http://localhost/retencion-vehicular/operador?action=eliminarRegistro" method="POST">
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este registro?</p>
                    <input type="hidden" name="codigo_registro" id="codigo_eliminar">
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
                document.getElementById("placa_editar").value = this.getAttribute("data-placa");
                document.getElementById("responsable_editar").value = this.getAttribute("data-responsable");
                document.getElementById("estado_pago_editar").value = this.getAttribute("data-estado");
                document.getElementById("retener_hasta_editar").value = this.getAttribute("data-retener");
                document.getElementById("id_forma_pago_editar").value = this.getAttribute("data-forma-pago");

                // Marcar checkboxes de actividades
                let actividadesSeleccionadas = this.getAttribute("data-actividades").split(",");
                document.querySelectorAll(".actividad-checkbox").forEach(checkbox => {
                    checkbox.checked = actividadesSeleccionadas.includes(checkbox.value);
                });
            });
        });

        // Pasar datos al modal de eliminación
        document.querySelectorAll(".btn-eliminar").forEach(button => {
            button.addEventListener("click", function () {
                let codigo = this.getAttribute("data-codigo");
                console.log("Código seleccionado para eliminar:", codigo); // Verifica en consola
                document.getElementById("codigo_eliminar").value = codigo;
            });
        });
    });
</script>
</html>
