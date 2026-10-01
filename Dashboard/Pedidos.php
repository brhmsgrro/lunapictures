<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../DAO/MetodosAdmin.php';

$metodos = new MetodosAdmin();
$listaPedidos = $metodos->ListarPedidos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pedidos | Luna Pictures Merchandising</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://getbootstrap.com/docs/4.4/examples/dashboard/dashboard.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"></script>
    <style>
        #mostrar { min-height: 50px; margin-top: 20px; }
        .btn-detalle { white-space: nowrap; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Luna Pictures STORE</a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="Cerrar.php">Cerrar Sesion</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="index.php"><span data-feather="home"></span> Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="Productos.php"><span data-feather="package"></span> Productos</a></li>
                        <li class="nav-item"><a class="nav-link active" href="Pedidos.php"><span data-feather="shopping-cart"></span> Pedidos</a></li>
                        <li class="nav-item"><a class="nav-link" href="clientes.php"><span data-feather="users"></span> Clientes</a></li>
                        <li class="nav-item mt-4"><a class="nav-link text-danger" href="Cerrar.php"><span data-feather="log-out"></span> Salir</a></li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Listado de Pedidos</h2>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="thead-dark">
                            <tr>
                                <th>Numero</th>
                                <th>Cod. Cliente</th>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($listaPedidos)): ?>
                                <?php foreach ($listaPedidos as $row): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row[0], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row[2], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row[3], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary btn-detalle" onclick="mostrarDetallePedido(<?php echo (int)$row[0]; ?>)">
                                                <span data-feather="eye"></span> Ver Detalle
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center text-muted py-4">No se encontraron pedidos.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div id="mostrar"></div>
            </main>
        </div>
    </div>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <script>
        // 1. Inicializar iconos Feather
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });

        // 2. FUNCIÓN PARA CARGAR EL DETALLE DEL PEDIDO
        function mostrarDetallePedido(n) {
            console.log('Cargando detalle del pedido:', n);
            
            var contenedor = document.getElementById("mostrar");
            contenedor.innerHTML = '<div class="d-flex justify-content-center my-3"><div class="spinner-border text-primary" role="status"><span class="sr-only">Cargando...</span></div></div>';

            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }

            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    contenedor.innerHTML = xmlhttp.responseText;
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                }
            };

            xmlhttp.open("GET", "detallePedido.php?num=" + n, true);
            xmlhttp.send();
        }

        // 3. FUNCIÓN PARA MARCAR COMO DESPACHADO
        async function marcarComoDespachado(idPedido, emailCliente, nombreCliente) {
    console.log('Despachando:', idPedido, emailCliente, nombreCliente);
    
    if (!emailCliente || emailCliente.trim() === '') {
        alert('No hay email registrado para este cliente');
        return;
    }

    var mensaje = 'Confirmar envio del pedido a ' + nombreCliente + ' (' + emailCliente + ')';
    if (!confirm(mensaje)) {
        return;
    }

    // ✅ AQUÍ PEDIMOS EL NÚMERO DE RASTREO
    var numeroRastreo = prompt("Ingresa el Número de Rastreo (Guía) para este pedido:\n(Déjalo en blanco si aún no lo tienes)", "");
    
    // Si el usuario cancela el prompt, detenemos el proceso
    if (numeroRastreo === null) {
        return; 
    }

    var btn = event.currentTarget;
    var textoOriginal = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Procesando...';

    try {
        var formData = new FormData();
        formData.append('id_pedido', idPedido);
        formData.append('email_cliente', emailCliente);
        formData.append('nombre_cliente', nombreCliente);
        formData.append('numero_rastreo', numeroRastreo.trim() === '' ? 'En proceso de asignación' : numeroRastreo);

        var respuesta = await fetch('actualizarEstadoPedido.php', {
            method: 'POST',
            body: formData
        });

        var resultado = await respuesta.json();
        console.log('Respuesta del servidor:', resultado);

        if (resultado.exito) {
            alert('Exito! ' + resultado.mensaje);
            location.reload();
        } else {
            alert('Error: ' + resultado.mensaje);
            btn.disabled = false;
            btn.innerHTML = textoOriginal;
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexion: ' + error.message);
        btn.disabled = false;
        btn.innerHTML = textoOriginal;
    }
}
    </script>

</body>
</html>