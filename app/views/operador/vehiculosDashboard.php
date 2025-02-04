<?php
require_once __DIR__ . '/../../controllers/ModeloController.php';
require_once __DIR__ . '/../../controllers/MarcaController.php';
require_once __DIR__ . '/../../controllers/PropietarioController.php';
require_once __DIR__ . '/../../controllers/InfraccionController.php';
require_once __DIR__ . '/../../controllers/PatioController.php';
require_once __DIR__ . '/../../controllers/VehiculoController.php';

$modeloController = new ModeloController();
$marcaController = new MarcaController();
$propietarioController = new PropietarioController();
$infraccionController = new InfraccionController();
$patioController = new PatioController();
$vehiculoController = new VehiculoController();

$listaModelos = $modeloController->listar();
$listaMarcas = $marcaController->listar();
$listaInfracciones = $infraccionController->listar();
$listaPatios = $patioController->listar();
$listaPropietario = $propietarioController->listar();
$listaVehiculos = $vehiculoController->listar();
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
            <a href="http://localhost/retencion-vehicular/operador?action=vehiculosDashboard" class="nav-link active">
                Vehículos
            </a>
        </li>
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/operador?action=registrosDashboard" class="nav-link link-body-emphasis">
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
    <h2 class="text-center">Dashboard de vehículos</h2>
    <p class="my-3">Esta es la sección principal donde podrás ver la información de los vehículos.</p>
    <div class="row my-2 pb-5">
        <div class="col-md-12 my-2">
            <div class="main-card mb-3 card">
                <div class="card-header fw-semibold p-3 text-center">Lista de vehículos</div>
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
                            <th class="text-center">Ced. Propietario</th>
                            <th class="text-center">Infracción</th>
                            <th class="text-center">Patio</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        <?php if (empty($listaVehiculos)) { ?>
                            <tr>
                                <td class="text-center" colspan="10">No hay vehículos</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($listaVehiculos as $index => $vehiculo) { ?>
                                <tr>
                                    <td class="text-center text-muted"><?php echo $index + 1?></td>
                                    <td class="text-center"><?php echo $vehiculo['placa'] ?></td>
                                    <td class="text-center"><?php echo $vehiculo['anio'] ?></td>
                                    <td class="text-center">
                                        <?php
                                        if ($vehiculo['estado'] === 'Liberado') { ?>
                                            <span class="badge bg-success">Liberado</span>
                                        <?php } elseif ($vehiculo['estado'] === 'Retenido') { ?>
                                            <span class="badge bg-warning text-dark">Retenido</span>
                                        <?php } elseif ($vehiculo['estado'] === 'Chatarización') { ?>
                                            <span class="badge bg-danger">Chatarización</span>
                                        <?php } else { ?>
                                            <span class="badge bg-secondary">Desconocido</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center"><?php echo $vehiculo['marca'] ?></td>
                                    <td class="text-center"><?php echo $vehiculo['modelo'] ?></td>
                                    <td class="text-center"><?php echo $vehiculo['cedula_propietario'] ?></td>
                                    <td class="text-center"><?php echo $vehiculo['infraccion'] ?></td>
                                    <td class="text-center"><?php echo $vehiculo['patio'] ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm my-1 mx-1 btn-editar"
                                                data-bs-toggle="modal" data-bs-target="#editaModal"
                                                data-placa="<?php echo $vehiculo['placa']; ?>"
                                                data-anio="<?php echo $vehiculo['anio']; ?>"
                                                data-estado="<?php echo $vehiculo['estado']; ?>"
                                                data-codigo-marca="<?php echo $vehiculo['codigo_marca']; ?>"
                                                data-codigo-modelo="<?php echo $vehiculo['codigo_modelo']; ?>"
                                                data-codigo-infraccion="<?php echo $vehiculo['codigo_infraccion']; ?>"
                                                data-codigo-patio="<?php echo $vehiculo['codigo_patio']; ?>"
                                                data-cedula-propietario="<?php echo $vehiculo['cedula_propietario']; ?>">
                                            <i class='bx bxs-edit-alt' style="font-size: 20px"></i>
                                        </button>

                                        <button type="button" class="btn btn-danger btn-sm my-1 mx-1 btn-eliminar"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-placa="<?php echo $vehiculo['placa']; ?>">
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
                    <a type="button" class="btn btn-success my-2" data-bs-toggle="modal" data-bs-target="#agregarModal">Agregar vehículo</a>
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
                <h1 class="modal-title fs-5">Agregar Vehículo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAgregarVehiculo" action="http://localhost/retencion-vehicular/operador?action=agregarVehiculo" method="POST">
                <div class="modal-body">
                    <!-- Placa -->
                    <div class="mb-3">
                        <label for="placa" class="form-label">Placa</label>
                        <input type="text" name="placa" id="placa" class="form-control" required>
                    </div>

                    <!-- Año -->
                    <div class="mb-3">
                        <label for="anio" class="form-label">Año</label>
                        <input type="number" name="anio" id="anio" class="form-control" required>
                    </div>

                    <!-- Estado -->
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-select" required>
                            <option value="Retenido">Retenido</option>
                            <option value="Liberado">Liberado</option>
                            <option value="Chatarrizacion">Enviado a chatarrización</option>
                        </select>
                    </div>

                    <!-- Modelo -->
                    <div class="mb-3">
                        <label for="codigo_modelo" class="form-label">Modelo</label>
                        <select name="codigo_modelo" id="codigo_modelo" class="form-select">
                            <option value="">Seleccione un modelo</option>
                            <?php foreach ($listaModelos as $modelo): ?>
                                <option value="<?php echo $modelo['codigo_modelo']; ?>">
                                    <?php echo $modelo['detalle']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Marca -->
                    <div class="mb-3">
                        <label for="codigo_marca" class="form-label">Marca</label>
                        <select name="codigo_marca" id="codigo_marca" class="form-select">
                            <option value="">Seleccione una marca</option>
                            <?php foreach ($listaMarcas as $marca): ?>
                                <option value="<?php echo $marca['codigo_marca']; ?>">
                                    <?php echo $marca['detalle']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Infracción -->
                    <div class="mb-3">
                        <label for="codigo_infraccion" class="form-label">Infracción</label>
                        <select name="codigo_infraccion" id="codigo_infraccion" class="form-select">
                            <option value="">Seleccione una infracción</option>
                            <?php foreach ($listaInfracciones as $infraccion): ?>
                                <option value="<?php echo $infraccion['codigo_infraccion']; ?>">
                                    <?php echo $infraccion['detalle']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Patio -->
                    <div class="mb-3">
                        <label for="codigo_patio" class="form-label">Patio</label>
                        <select name="codigo_patio" id="codigo_patio" class="form-select">
                            <option value="">Seleccione un patio</option>
                            <?php foreach ($listaPatios as $patio): ?>
                                <option value="<?php echo $patio['codigo_patio']; ?>">
                                    <?php echo $patio['detalle']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Propietario -->
                    <div class="mb-3">
                        <label for="cedula_propietario" class="form-label">Propietario</label>
                        <select name="cedula_propietario" id="cedula_propietario" class="form-select">
                            <option value="">Seleccione un propietario</option>
                            <?php foreach ($listaPropietario as $propietario): ?>
                                <option value="<?php echo $propietario['cedula']; ?>">
                                    <?php echo $propietario['nombres'] . " " . $propietario['apellidos']; ?>
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
                <h1 class="modal-title fs-5">Editar Vehículo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarVehiculo" action="http://localhost/retencion-vehicular/operador?action=editarVehiculo" method="POST">
                <div class="modal-body">
                    <!-- Placa (No editable) -->
                    <div class="mb-3">
                        <label for="placa_editar" class="form-label">Placa</label>
                        <input type="text" name="placa" id="placa_editar" class="form-control" required readonly>
                    </div>

                    <!-- Año -->
                    <div class="mb-3">
                        <label for="anio_editar" class="form-label">Año</label>
                        <input type="number" name="anio" id="anio_editar" class="form-control" required>
                    </div>

                    <!-- Estado -->
                    <div class="mb-3">
                        <label for="estado_editar" class="form-label">Estado</label>
                        <select name="estado" id="estado_editar" class="form-select" required>
                            <option value="Retenido">Retenido</option>
                            <option value="Liberado">Liberado</option>
                            <option value="Chatarrizacion">Enviado a chatarrización</option>
                        </select>
                    </div>

                    <!-- Modelo -->
                    <div class="mb-3">
                        <label for="codigo_modelo_editar" class="form-label">Modelo</label>
                        <select name="codigo_modelo" id="codigo_modelo_editar" class="form-select">
                            <option value="">Seleccione un modelo</option>
                            <?php foreach ($listaModelos as $modelo): ?>
                                <option value="<?php echo $modelo['codigo_modelo']; ?>">
                                    <?php echo $modelo['detalle']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Marca -->
                    <div class="mb-3">
                        <label for="codigo_marca_editar" class="form-label">Marca</label>
                        <select name="codigo_marca" id="codigo_marca_editar" class="form-select">
                            <option value="">Seleccione una marca</option>
                            <?php foreach ($listaMarcas as $marca): ?>
                                <option value="<?php echo $marca['codigo_marca']; ?>">
                                    <?php echo $marca['detalle']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Infracción -->
                    <div class="mb-3">
                        <label for="codigo_infraccion_editar" class="form-label">Infracción</label>
                        <select name="codigo_infraccion" id="codigo_infraccion_editar" class="form-select">
                            <option value="">Seleccione una infracción</option>
                            <?php foreach ($listaInfracciones as $infraccion): ?>
                                <option value="<?php echo $infraccion['codigo_infraccion']; ?>">
                                    <?php echo $infraccion['detalle']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Patio -->
                    <div class="mb-3">
                        <label for="codigo_patio_editar" class="form-label">Patio</label>
                        <select name="codigo_patio" id="codigo_patio_editar" class="form-select">
                            <option value="">Seleccione un patio</option>
                            <?php foreach ($listaPatios as $patio): ?>
                                <option value="<?php echo $patio['codigo_patio']; ?>">
                                    <?php echo $patio['detalle']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Propietario -->
                    <div class="mb-3">
                        <label for="cedula_propietario_editar" class="form-label">Propietario</label>
                        <select name="cedula_propietario" id="cedula_propietario_editar" class="form-select">
                            <option value="">Seleccione un propietario</option>
                            <?php foreach ($listaPropietario as $propietario): ?>
                                <option value="<?php echo $propietario['cedula']; ?>">
                                    <?php echo $propietario['nombres'] . " " . $propietario['apellidos']; ?>
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
                <h1 class="modal-title fs-5">Eliminar Vehículo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEliminarVehiculo" action="http://localhost/retencion-vehicular/operador?action=eliminarVehiculo" method="POST">
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este vehículo?</p>
                    <input type="hidden" name="placa" id="placa_eliminar">
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
        // Configurar el modal de edición
        document.querySelectorAll(".btn-editar").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("placa_editar").value = this.getAttribute("data-placa");
                document.getElementById("anio_editar").value = this.getAttribute("data-anio");
                document.getElementById("estado_editar").value = this.getAttribute("data-estado");
                document.getElementById("codigo_marca_editar").value = this.getAttribute("data-codigo-marca");
                document.getElementById("codigo_modelo_editar").value = this.getAttribute("data-codigo-modelo");
                document.getElementById("codigo_infraccion_editar").value = this.getAttribute("data-codigo-infraccion");
                document.getElementById("codigo_patio_editar").value = this.getAttribute("data-codigo-patio");
                document.getElementById("cedula_propietario_editar").value = this.getAttribute("data-cedula-propietario");
            });
        });

        // Configurar el modal de eliminación
        document.querySelectorAll(".btn-eliminar").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("placa_eliminar").value = this.getAttribute("data-placa");
            });
        });
    });
</script>
</html>
