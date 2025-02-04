<?php
require_once __DIR__ . '/../../controllers/PropietarioController.php';

$propietarioController = new PropietarioController();
$propietariosLista = $propietarioController->listar();
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
            <a href="http://localhost/retencion-vehicular/operador?action=propietariosDashboard" class="nav-link active">
                Propietarios
            </a>
        </li>
        <li class="nav-item">
            <a href="http://localhost/retencion-vehicular/operador?action=vehiculosDashboard" class="nav-link link-body-emphasis">
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
    <h2 class="text-center">Dashboard de propietarios</h2>
    <p class="my-3">Esta es la sección principal donde podrás ver la información de los propietarios.</p>
    <div class="row my-2 pb-5">
        <div class="col-md-12 my-2">
            <div class="main-card mb-3 card">
                <div class="card-header fw-semibold p-3 text-center">Lista de propietarios</div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Cédula</th>
                            <th class="text-center">Nombres</th>
                            <th class="text-center">Apellidos</th>
                            <th class="text-center">Teléfono</th>
                            <th class="text-center">Correo</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        <?php if (empty($propietariosLista)) { ?>
                            <tr>
                                <td class="text-center" colspan="8">No hay propietarios</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($propietariosLista as $index => $propietario) { ?>
                                <tr>
                                    <td class="text-center text-muted"><?php echo $index + 1?></td>
                                    <td class="text-center"><?php echo $propietario['cedula'] ?></td>
                                    <td class="text-center"><?php echo $propietario['nombres'] ?></td>
                                    <td class="text-center"><?php echo $propietario['apellidos'] ?></td>
                                    <td class="text-center"><?php echo $propietario['telefono'] ?></td>
                                    <td class="text-center"><?php echo $propietario['correo'] ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm btn-editar"
                                                data-cedula="<?php echo $propietario['cedula']; ?>"
                                                data-nombres="<?php echo $propietario['nombres']; ?>"
                                                data-apellidos="<?php echo $propietario['apellidos']; ?>"
                                                data-telefono="<?php echo $propietario['telefono']; ?>"
                                                data-correo="<?php echo $propietario['correo']; ?>"
                                                data-bs-toggle="modal" data-bs-target="#editarModal"
                                        >
                                            <i class='bx bxs-edit-alt' style="font-size: 20px"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar"
                                                data-cedula="<?php echo $propietario['cedula']; ?>"
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
                    <a type="button" class="btn btn-success my-2" data-bs-toggle="modal" data-bs-target="#agregarModal">Agregar propietario</a>
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
            document.getElementById("formAgregarPropietario").reset();
        }
    </script>

<div class="modal fade" id="agregarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Propietario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAgregarPropietario" action="http://localhost/retencion-vehicular/operador?action=agregarPropietario" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cedula" class="form-label">Cédula</label>
                        <input minlength="10" maxlength="10" type="text" name="cedula" id="cedula" class="form-control" placeholder="Ingrese N° de cédula" pattern="[0-9]+" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombres" class="form-label">Nombres</label>
                        <input type="text" name="nombres" id="nombres" class="form-control" placeholder="Ingrese nombres" 
                         pattern="[a-z-A-Z]" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Ingrese apellidos" pattern="[a-z-A-Z]" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input minlength="10" maxlength="10" type="text" name="telefono" id="telefono" class="form-control" placeholder="Ingrese teléfono" pattern="[0-9]+" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" name="correo" id="correo" class="form-control" placeholder="Ingrese correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese contraseña" required>
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

<div class="modal fade" id="editarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Editar Propietario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarPropietario" action="http://localhost/retencion-vehicular/operador?action=editarPropietario" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cedula_editar" class="form-label">Cédula</label>
                        <input type="text" name="cedula" id="cedula_editar" class="form-control" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nombres_editar" class="form-label">Nombres</label>
                        <input type="text" name="nombres" id="nombres_editar" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos_editar" class="form-label">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos_editar" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono_editar" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" id="telefono_editar" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo_editar" class="form-label">Correo</label>
                        <input type="text" name="correo_editar" id="correo_editar" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_editar" class="form-label">Contraseña</label>
                        <input type="text" name="password_editar" id="password_editar" class="form-control">
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

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Confirmar Eliminación</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formEliminarPropietario" action="http://localhost/retencion-vehicular/operador?action=eliminarPropietario" method="POST">
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar a este propietario?</p>
                    <input type="hidden" name="cedula" id="cedula_eliminar">
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
        // Seleccionar todos los botones de editar
        document.querySelectorAll(".btn-editar").forEach(button => {
            button.addEventListener("click", function () {
                // Obtener los datos del propietario desde los atributos del botón
                const cedula = this.getAttribute("data-cedula");
                const nombres = this.getAttribute("data-nombres");
                const apellidos = this.getAttribute("data-apellidos");
                const telefono = this.getAttribute("data-telefono");
                const correo = this.getAttribute("data-correo");

                // Llenar los inputs del modal con los datos del propietario
                document.getElementById("cedula_editar").value = cedula;
                document.getElementById("nombres_editar").value = nombres;
                document.getElementById("apellidos_editar").value = apellidos;
                document.getElementById("telefono_editar").value = telefono;
                document.getElementById("correo_editar").value = correo;
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".btn-eliminar").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("cedula_eliminar").value = this.getAttribute("data-cedula");
            });
        });
    });
</script>
</html>
