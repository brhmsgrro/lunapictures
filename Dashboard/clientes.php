<!DOCTYPE html>
<html>
<?php include '../DAO/MetodosAdmin.php'; ?>
  
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Luna pictures Merchandising - Clientes</title>
    <link href="https://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://getbootstrap.com/docs/4.4/examples/dashboard/dashboard.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Luna pictures STORE</a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="Cerrar.php">Sign out</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="Productos.php">Productos</a></li>
                        <li class="nav-item"><a class="nav-link" href="Pedidos.php">Pedidos</a></li>
                        <li class="nav-item"><a class="nav-link active" href="clientes.php">Clientes</a></li>
                        <li class="nav-item"><a class="nav-link" href="Cerrar.php">Salir</a></li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <h3 align="center" class="mt-4">Listado de clientes</h3>
                
                <?php if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'eliminado'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Cliente eliminado correctamente.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <!-- <th>Password</th> Oculto por seguridad -->
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $metodos = new MetodosAdmin();
                        $lista = $metodos->ListarClientes();
                        foreach ($lista as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row[0]; ?></td>
                            <td><?php echo $row[1]; ?></td>
                            <td><?php echo $row[2]; ?></td>
                            <td><?php echo $row[3]; ?></td>
                            <td><?php echo $row[4]; ?></td>
                            <td>
                                <a href="eliminar_cliente.php?id=<?php echo $row[0]; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('⚠️ ¿Estás seguro de que deseas eliminar este cliente? Esta acción no se puede deshacer.');">
                                   🗑️ Eliminar
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.4/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
    <script>feather.replace()</script>
</body>
</html>