<?php
// filepath: /c:/xampp/htdocs/tiendamvc/app/views/order/home.php
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Órdenes de Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <h1 class="navbar-text">
                    Listado de Órdenes
                </h1>
                <div class="d-flex">
                    <a href="<?= base_url() ?>order/newOrder" class="btn btn-primary me-2">Nueva Orden</a>
                    <a href="<?= base_url() ?>admin/home" class="btn btn-primary">Inicio</a>
                </div>
            </div>
        </nav>
        <?php if(empty($orders)): ?>
            <div class="alert alert-info mt-4">
                No hay órdenes disponibles. <a href="<?= base_url() ?>order/newOrder" class="alert-link">Crear nueva orden</a>.
            </div>
        <?php else: ?>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Productos</th>
                    <th scope="col">Total</th>
                    <th scope="col">Descuento</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <th scope="row"><?= $order->order_id ?></th>
                        <td><?= $order->customer ? $order->customer->name : 'Cliente no disponible' ?></td>
                        <td><?= date('d/m/Y', strtotime($order->date)) ?></td>
                        <td><?= count($order->products) ?></td>
                        <td>€<?= number_format($order->getTotal(), 2) ?></td>
                        <td><?= $order->discount > 0 ? $order->discount . '%' : '-' ?></td>
                        <td>
                            <a href="<?= base_url() ?>order/show/<?= $order->order_id ?>" class="me-2" title="Ver detalle">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="<?= base_url() ?>order/editOrder/<?= $order->order_id ?>" class="me-2" title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="<?= base_url() ?>order/deleteOrder/<?= $order->order_id ?>" 
                               onclick="return confirm('¿Estás seguro de eliminar esta orden?')" title="Eliminar">
                                <i class="fa-solid fa-trash text-danger"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</body>

</html>