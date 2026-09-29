<?php
// 1. ARQUITECTURA: Lógica de negocio al principio (Controlador)
require_once '../DAO/MetodosAdmin.php';

$metodos = new MetodosAdmin();
$listaProductos = $metodos->ListarProductos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Panel de administración de Luna Pictures">
    <meta name="author" content="Luna Pictures">
    <title>Dashboard | Luna Pictures Merchandising</title>

    <!-- Bootstrap 4.4 Core CSS -->
    <link href="https://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Dashboard Custom CSS -->
    <link href="https://getbootstrap.com/docs/4.4/examples/dashboard/dashboard.css" rel="stylesheet">
    
    <style>
        /* Ajustes profesionales menores */
        .table img {
            object-fit: cover;
            border: 1px solid #dee2e6;
        }
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <!-- Navbar Superior -->
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Luna Pictures STORE</a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="Cerrar.php">Cerrar Sesión</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <span data-feather="home"></span> Dashboard <span class="sr-only">(actual)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file"></span> Productos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Pedidos.php">
                                <span data-feather="shopping-cart"></span> Pedidos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="clientes.php">
                                <span data-feather="users"></span> Clientes
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link text-danger" href="Cerrar.php">
                                <span data-feather="log-out"></span> Salir
                            </a>
                        </li>
                    </ul> <!-- CORREGIDO: Faltaba cerrar este ul en tu código original -->
                </div>
            </nav>

            <!-- Contenido Principal -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                
                <!-- Encabezado de la sección con botón de acción -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Listado de Productos</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="Formulario.php?op=1&cod=0" class="btn btn-primary btn-sm shadow-sm">
                            <span data-feather="plus-circle" class="mr-1"></span> Nuevo Producto
                        </a>
                    </div>
                </div>

                <!-- Tarjeta de Contenido -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0 align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Código</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col" class="text-center">Imagen</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($listaProductos)): ?>
                                        <?php foreach ($listaProductos as $row): ?>
                                            <?php
                                            // 2. SEGURIDAD: Escapar salida y asignar variables para legibilidad
                                            $codigo     = htmlspecialchars($row[0]);
                                            $descripcion= htmlspecialchars($row[1]);
                                            $precio     = htmlspecialchars($row[2]);
                                            $stock      = htmlspecialchars($row[3]);
                                            $estado     = htmlspecialchars($row[4]);
                                            $imagen     = htmlspecialchars($row[6]);
                                            
                                            // Lógica visual para el badge de estado
                                            $badgeClass = (strtolower($estado) === 'activo' || $estado == '1') ? 'success' : 'secondary';
                                            ?>
                                            <tr>
                                                <td class="font-weight-bold"><?= $codigo ?></td>
                                                <td><?= $descripcion ?></td>
                                                <td class="text-right font-weight-bold text-success">
                                                    $<?= number_format($precio, 2) ?>
                                                </td>
                                                <td><?= $stock ?></td>
                                                <td>
                                                    <span class="badge badge-<?= $badgeClass ?> p-2"><?= $estado ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <img src="../images/<?= $imagen ?>" 
                                                         width="40" height="40" class="rounded" 
                                                         onerror="this.src='https://via.placeholder.com/40x40?text=Sin+Img';" 
                                                         alt="Imagen del producto">
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group" aria-label="Acciones">
                                                        <a href="Formulario.php?op=2&cod=<?= $codigo ?>" 
                                                           class="btn btn-outline-primary" title="Editar">
                                                            <span data-feather="edit-2" style="width:16px;"></span>
                                                        </a>
                                                        <a href="Mantenimiento.php?op=3&cod=<?= $codigo ?>" 
                                                           class="btn btn-outline-danger" 
                                                           onclick="return confirm('¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.');" 
                                                           title="Eliminar">
                                                            <span data-feather="trash-2" style="width:16px;"></span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                <span data-feather="inbox" class="mb-2" style="width: 32px; height: 32px;"></span>
                                                <p class="mb-0">No se encontraron productos registrados.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Scripts al final del body para mejor rendimiento -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://getbootstrap.com/docs/4.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    
    <script>
        // Inicializar iconos de Feather
        feather.replace();
    </script>
</body>
</html>