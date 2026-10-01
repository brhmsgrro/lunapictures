<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$idPedido = isset($_GET['num']) ? (int)$_GET['num'] : 0;

if ($idPedido <= 0) {
    echo '<div class="alert alert-danger">ID de pedido no válido: ' . htmlspecialchars($idPedido) . '</div>';
    exit;
}

include '../DAO/MetodosAdmin.php';

try {
    $metodos = new MetodosAdmin();
    $infoPedido = $metodos->ObtenerInfoPedido($idPedido);
    $listaProductos = $metodos->ListarPedidosNum($idPedido);
} catch (Exception $e) {
    echo '<div class="alert alert-danger">Error al cargar datos: ' . htmlspecialchars($e->getMessage()) . '</div>';
    exit;
}

if (!$infoPedido) {
  // Definir variables para usar en el HTML
$emailCliente = !empty($infoPedido['email_cliente']) ? $infoPedido['email_cliente'] : '';
$estadoPedido = !empty($infoPedido['estado']) ? $infoPedido['estado'] : 'pendiente';
    echo '<div class="alert alert-warning">No se encontró el pedido #' . $idPedido . '</div>';
    exit;
}
?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">📦 Pedido #<?= htmlspecialchars($idPedido) ?></h5>
        <span class="badge badge-<?= ($infoPedido['estado'] ?? 'pendiente') === 'despachado' ? 'success' : 'warning' ?> p-2">
            ESTADO: <?= strtoupper(htmlspecialchars($infoPedido['estado'] ?? 'PENDIENTE')) ?>
        </span>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card bg-light h-100">
                    <div class="card-body">
                        <h6 class="card-title text-primary font-weight-bold">📍 Dirección de Envío</h6>
                        <p class="mb-1 font-weight-bold"><?= htmlspecialchars($infoPedido['nombre_cliente'] ?? 'N/A') ?></p>
                        <p class="mb-1"><?= htmlspecialchars($infoPedido['direccion'] ?? 'Dirección no registrada') ?></p>
                        <hr>
                        <p class="mb-1">📞 <?= htmlspecialchars($infoPedido['telefono'] ?? 'Sin teléfono') ?></p>
                        <p class="mb-0">✉️ <?= htmlspecialchars($infoPedido['email_cliente'] ?? 'Sin email') ?></p>
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA: Acción de Despacho -->
<div class="col-md-6 mb-3">
    <div class="card h-100 border-primary">
        <div class="card-body text-center d-flex flex-column justify-content-center">
            <h6 class="font-weight-bold">¿El pedido ya salió de almacén?</h6>
            
            <?php if (empty($infoPedido['email_cliente'])): ?>
                <div class="alert alert-warning mt-2 mb-0">
                    <strong>⚠️ Atención:</strong> Este cliente no tiene email registrado.
                </div>
                <button class="btn btn-secondary btn-lg mt-2" disabled>
                    ✉️ Email no disponible
                </button>
            <?php elseif (($infoPedido['estado'] ?? 'pendiente') === 'despachado'): ?>
                <div class="alert alert-success mt-2 mb-0">
                    ✅ Este pedido ya fue despachado
                </div>
            <?php else: ?>
                <p class="text-muted small">Al hacer clic, se actualizará el estado y se enviará un correo automático al cliente.</p>
                
                <!-- ✅ BOTÓN CON DATA-ATTRIBUTES -->
                <button class="btn btn-success btn-lg mt-2" 
        onclick="marcarComoDespachado(<?= (int)$idPedido ?>, '<?= addslashes($infoPedido['email_cliente'] ?? '') ?>', '<?= addslashes($infoPedido['nombre_cliente'] ?? 'Cliente') ?>')">
    ✉️ Marcar como Enviado y Notificar
</button>
            <?php endif; ?>
        </div>
    </div>
</div>

        <h6 class="font-weight-bold mt-4 mb-3">🛒 Productos en este pedido:</h6>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th># Pedido</th>
                        <th>Cód. Producto</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Cant.</th>
                        <th>Color</th>
                        <th>Talla</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($listaProductos)): ?>
                        <?php foreach ($listaProductos as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row[0]) ?></td>
                            <td><?= htmlspecialchars($row[1]) ?></td>
                            <td><?= htmlspecialchars($row[2]) ?></td>
                            <td>$<?= number_format($row[3], 2) ?></td>
                            <td><?= htmlspecialchars($row[4]) ?></td>
                            <td><?= htmlspecialchars($row[5] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row[6] ?? 'N/A') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay productos</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
async function marcarComoDespachado(idPedido, emailCliente) {
    console.log('ID:', idPedido, 'Email:', emailCliente);
    
    if (!emailCliente || emailCliente.trim() === '') {
        alert('No hay email registrado para este cliente');
        return;
    }

    var mensaje = 'Confirmar envio del pedido #' + idPedido + ' y enviar notificacion a: ' + emailCliente;
    if (!confirm(mensaje)) {
        return;
    }

    var btn = event.currentTarget;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Procesando...';

    try {
        var formData = new FormData();
        formData.append('id_pedido', idPedido);
        formData.append('email_cliente', emailCliente);

        var respuesta = await fetch('actualizarEstadoPedido.php', {
            method: 'POST',
            body: formData
        });

        var resultado = await respuesta.json();
        console.log('Respuesta:', resultado);

        if (resultado.exito) {
            alert('Exito! ' + resultado.mensaje);
            location.reload();
        } else {
            alert('Error: ' + resultado.mensaje);
            btn.disabled = false;
            btn.innerHTML = 'Marcar como Enviado y Notificar';
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexion: ' + error.message);
        btn.disabled = false;
        btn.innerHTML = 'Marcar como Enviado y Notificar';
    }
}
</script>